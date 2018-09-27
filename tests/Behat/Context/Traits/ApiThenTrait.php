<?php

namespace App\Tests\Behat\Context\Traits;

use Behatch\Json\Json;
use Symfony\Component\HttpFoundation\Response;

trait ApiThenTrait
{
    /**
     * A proper response is defined by a Status Code of 20*
     * And valid JSON if the response has a body
     *
     * @Then a proper response should be returned
     */
    public function aProperResponseShouldBeReturned(): void
    {
        $statusCode = $this->getSession()->getStatusCode();
        if (Response::HTTP_OK !== $statusCode
            && Response::HTTP_CREATED !== $statusCode
            && Response::HTTP_NO_CONTENT !== $statusCode) {
            throw new \Exception("Status code expected: 200|201|204. Actual: $statusCode");
        }

        $content = $this->getSession()->getDriver()->getContent();
        if (false === empty($content)) {
            try {
                new Json($content);
            } catch (\Exception $exception) {
                throw new \Exception('Response do not contain a valid JSON');
            }
        }
    }

    /**
     * @Then form errors should be returned
     */
    public function formErrorsShouldBeReturned(): void
    {
        $this->assertResponseStatus(422);
    }

    /**
     * @param string $fileName
     *
     * @throws \Exception
     *
     * @Then the content should be similar to :fileName
     */
    public function contentShouldBeSimilarTo(string $fileName): void
    {
        $result   = new Json($this->getSession()->getDriver()->getContent());
        $expected = $this->loadDataFromJsonFile($fileName);
        $actual   = json_decode($result->encode(), true);

        if ($expected !== $actual) {
            $message = "The result are not equals. \n";
            $message .= 'Expected:' . print_r($this->arrayRecursiveDiff($expected, $actual), true);
            $message .= 'Actual:'   . print_r($this->arrayRecursiveDiff($actual, $expected), true);

            throw new \Exception($message);
        }
    }

    /**
     * @param string $filename
     *
     * @return array
     */
    private function loadDataFromJsonFile(string $filename): array
    {
        return json_decode(file_get_contents('tests/Resources/json/' . $filename), true);
    }

    /**
     * @param $aArray1
     * @param $aArray2
     *
     * @return array
     */
    private function arrayRecursiveDiff($aArray1, $aArray2): array
    {
        $aReturn = [];
        foreach ($aArray1 as $mKey => $mValue) {
            if (is_array($aArray2) && array_key_exists($mKey, $aArray2)) {
                if (is_array($mValue)) {
                    $aRecursiveDiff = $this->arrayRecursiveDiff($mValue, $aArray2[$mKey]);
                    if (count($aRecursiveDiff)) {
                        $aReturn[$mKey] = $aRecursiveDiff;
                    }
                } else {
                    if ($mValue !== $aArray2[$mKey]) {
                        $aReturn[$mKey] = $mValue;
                    }
                }
            } else {
                $aReturn[$mKey] = $mValue;
            }
        }

        return $aReturn;
    }
}
