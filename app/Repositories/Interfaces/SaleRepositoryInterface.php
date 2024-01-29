<?php

namespace App\Repositories\Interfaces;

/**
 * Interface SaleRepositoryInterface
 *
 * @package App\Repositories\Interfaces
 */
interface SaleRepositoryInterface
{
    /**
     * Get all sales.
     *
     * @return mixed
     */
    public function getAll();

    /**
     * Get the count of sales.
     *
     * @return int
     */
    public function count();

    /**
     * Find a sale by its ID.
     *
     * @param int $id
     * @return mixed
     */
    public function findByID($id);

    /**
     * Find a sale by a specific column and value.
     *
     * @param string $column
     * @param mixed $value
     * @return mixed
     */
    public function findByColumn($column, $value);

    /**
     * Find sales by multiple columns.
     *
     * @param array $columns
     * @return mixed
     */
    public function findByColumns(array $columns);

    /**
     * Store a new sale.
     *
     * @param array $input
     * @return mixed
     */
    public function store($input);

    /**
     * Update a sale by ID.
     *
     * @param int $id
     * @param array $input
     * @return mixed
     */
    public function update($id, $input);

    /**
     * Delete a sale by ID.
     *
     * @param int $id
     * @return mixed
     */
    public function destroy($id);

    /**
     * Soft delete a sale by ID.
     *
     * @param int $id
     * @return mixed
     */
    public function softDelete($id);

    /**
     * Bulk soft delete sales by IDs.
     *
     * @param array $ids
     * @return mixed
     */
    public function bulkSoftDelete(array $ids);

    /**
     * Force delete a soft-deleted sale by ID.
     *
     * @param int $id
     * @return mixed
     */
    public function forceDelete($id);

    /**
     * Bulk force delete soft-deleted sales by IDs.
     *
     * @param array $ids
     * @return mixed
     */
    public function bulkForceDelete(array $ids);

    /**
     * Recover a soft-deleted sale by ID.
     *
     * @param int $id
     * @return mixed
     */
    public function recover($id);

    /**
     * Bulk recover soft-deleted sales by IDs.
     *
     * @param array $ids
     * @return mixed
     */
    public function bulkRecoverSoftDelete(array $ids);

    /**
     * Get soft-deleted sales.
     *
     * @return mixed
     */
    public function getSoftDeleted();

    /**
     * Find a sale with trashed records by ID.
     *
     * @param int $id
     * @return mixed
     */
    public function findWithTrashed($id);

    /**
     * Paginate sales.
     *
     * @param int $perPage
     * @param string $orderColumn
     * @param string $orderDirection
     * @return mixed
     */
    public function paginate($perPage = 10, $orderColumn = 'id', $orderDirection = 'asc');

    /**
     * Filter sales based on provided filters.
     *
     * @param array $filters
     * @param string $orderColumn
     * @param string $orderDirection
     * @return mixed
     */
    public function filter(array $filters, $orderColumn = 'id', $orderDirection = 'asc');

    /**
     * Bulk update sales with the given data for specified IDs.
     *
     * @param array $ids
     * @param array $data
     * @return mixed
     */
    public function bulkUpdate(array $ids, array $data);
}
