<?php

namespace App\Model\Trait;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait PaginateSortAndFilter
{
    /**
     * Default number of items per page for pagination.
     *
     * @var int
     */
    protected $defaultSize = 100;

    /**
     * Get the filterable fields.
     *
     * @return array
     */
    public function getFilterableFields(): array
    {
        return $this->filterableFields? $this->filterableFields : [];
    }

    /**
     * Set the filterable fields.
     *
     * @param array $filterableFields
     * @return void
     */
    public function setFilterableFields(array $filterableFields): void
    {
        $this->filterableFields = $filterableFields;
    }

    /**
     * Get the default size for pagination.
     *
     * @return int
     */
    public function getDefaultSize(): int
    {
        return $this->defaultSize;
    }

    /**
     * Set the default size for pagination.
     *
     * @param int $defaultSize
     * @return void
     */
    public function setDefaultSize(int $defaultSize): void
    {
        $this->defaultSize = $defaultSize;
    }


    /**
     * Scope a query to paginate, sort, and filter results.
     *
     * @param Builder $query
     * @param Request|null $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function scopePaginateSortAndFilter(Builder $query, $paginateSortAndFilter = null): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {

        $paginateSortAndFilter = $paginateSortAndFilter ?? request()->all();
        // Filtering
        if (isset($paginateSortAndFilter['filter'])) {
            foreach ($paginateSortAndFilter['filter'] as $field => $value) {
                if (!in_array($field, $this->getFilterableFields() ?? [])) {
                    continue; // Skip fields that are not enabled for filtering
                }
                if (is_array($value)) {
                    $query->whereIn($field, $value);
                } else {
                    $query->where($field, 'like', "%$value%");
                }
            }
        }

        // Sorting
        if (isset($paginateSortAndFilter['sort'])) {
            // Example: sort=name,asc
            [$column, $direction] = explode(',', $paginateSortAndFilter['sort']) + [null, 'desc'];
            if ($column) {
                $query->orderBy($column, $direction);
            }
        }

        // Pagination
        $perPage = (int) ($paginateSortAndFilter['size'] ?? $this->defaultSize);
        return $query->paginate($perPage)->appends($paginateSortAndFilter);
    }
}