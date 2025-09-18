<?php

namespace App\Services;

class SearchEngine
{

    private $searchModels = [];
    private $searchKey = null;

    public function registerModel($model)
    {
        $this->searchModels[$model] = [];
    }

    public function getRegisteredModels()
    {
        return $this->searchModels;
    }

    public function getSearchKey()
    {
        return $this->searchKey;
    }

    public function executeSearch($search_key)
    {

        $this->clearResults();
        $this->searchKey = $search_key;

        foreach ($this->searchModels as $model => $values) {
       
            if (method_exists($model, 'scopePaginateSortAndFilter')) {

                $filter['relation'] = 'or';
                $filter['filter'] = collect((new $model)->getFilterableFields())->mapWithKeys(fn($item) => [$item => $this->searchKey])->toArray();

                $this->searchModels[$model] = $model::paginateSortAndFilter($filter);
            }
        }
    }

    public function getResultsFor($model)
    {

        if (!array_key_exists($model, $this->searchModels)) {
            return [];
        }

        return $this->searchModels[$model];
    }

    public function clearResults()
    {
        $this->searchKey = null;
        foreach ($this->searchModels as $key => $values) {
            if (array_key_exists((string) $key, $this->searchModels)) {
                $this->searchModels[$key] = [];
            }
        }
    }

    public function getAllResults()
    {
        return $this->searchModels;
    }

    public function getTotalCount()
    {

        $total_count = 0;

        foreach ($this->getAllResults() as $key => $values) {
            $total_count += count($values);
        }

        return $total_count;
    }
}
