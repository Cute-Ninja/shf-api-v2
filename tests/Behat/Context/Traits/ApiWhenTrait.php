<?php

namespace App\tests\Behat\Context\Traits;

use Behat\Gherkin\Node\TableNode;

trait ApiWhenTrait
{
    abstract public function visit($page);
    abstract public function request(string $method, string $apiName, array $parameters = []);

    /**
     * @param string $apiName
     *
     * @When I request the api :apiName
     */
    public function iRequestTheApi(string $apiName): void
    {
        $this->request('GET', $apiName);
    }

    /**
     * @param string    $apiName
     * @param TableNode $tableNode
     *
     * @When I want to add information using the api :apiName with the following values
     */
    public function iSubmitToTheApiTheFollowingValues(string $apiName, TableNode $tableNode): void
    {
        $this->request('POST', $apiName, $this->getFormData($tableNode));
    }

    /**
     * @param string    $apiName
     * @param TableNode $tableNode
     *
     * @When I want to modify information using the api :apiName with the following values
     */
    public function iWantToModifyInformation(string $apiName, TableNode $tableNode): void
    {
        $this->request('PUT', $apiName, $this->getFormData($tableNode));
    }

    /**
     * @param string $apiName
     *
     * @When I want to delete information using the api :apiName
     */
    public function iWantToDeleteInformation(string $apiName): void
    {
        $this->request('DELETE', $apiName);
    }

    /**
     * @param TableNode|null $table
     *
     * @return array
     */
    protected function getFormData(TableNode $table = null): array
    {
        $formData = [];
        if ($table) {
            $rows     = $table->getRows();
            $formData = $this->combineKeysAndValues($rows);
        }
        
        return $formData;
    }

    /**
     * @param string[] $tableRows
     *
     * @return array
     */
    private function combineKeysAndValues(array $tableRows): array
    {
        $result = [];
        foreach ($tableRows as $index => $row) {
            $key = array_shift($row);
            $value = (1 === count($row)) ? $row[0] : $row;
            // if key is an array
            if (preg_match('/([a-zA-Z]*)\[[a-zA-Z0-9]*\]/', $key, $keyMatches)) {
                $newKey = $keyMatches[1];
                // for multiple dimensions array
                if (preg_match_all('/\[([a-zA-Z0-9]*)\]/', $key, $valueMatches)) {
                    $keyValues = array_reverse($valueMatches[1]);
                    foreach ($keyValues as $keyValue) {
                        // array_merge_recursive does not merge integer key so we add a prefix that we delete later
                        $value = ($keyValue !== '' ? ['_prefix_' . $keyValue => $value] : [$value]);
                    }
                    if (isset($result[$newKey]) && is_array($result[$newKey])) {
                        $value = array_merge_recursive($result[$newKey], $value);
                    }
                }
                $key = $newKey;
            }
            $result[$key] = $value;
        }

        return $this->deleteKeyPrefixRecursively($result);
    }

    /**
     * @param array $array
     *
     * @return array
     */
    private function deleteKeyPrefixRecursively(array $array): array
    {
        $newArray = [];
        foreach ($array as $key => $value) {
            $newKey = str_replace('_prefix_', '', $key);
            if (is_array($value)) {
                $value = $this->deleteKeyPrefixRecursively($value);
            }
            $newArray[$newKey] = $value;
        }
        return $newArray;
    }
}
