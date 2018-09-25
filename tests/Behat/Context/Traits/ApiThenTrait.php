<?php

namespace App\Tests\Behat\Context\Traits;

use Behatch\Json\Json;
use Symfony\Component\HttpFoundation\Response;

trait ApiThenTrait
{
    /**
     * @Then a proper response should be return
     */
    public function aProperResponseShouldBeReturned(): void
    {
        $statusCode = $this->getSession()->getStatusCode();
        if (Response::HTTP_OK !== $statusCode && Response::HTTP_CREATED !== $statusCode) {
            throw new \Exception("Status code expected: 200|201. Actual: $statusCode");
        }
        new Json($this->getSession()->getDriver()->getContent());
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
