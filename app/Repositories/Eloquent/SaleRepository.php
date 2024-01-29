<?php

namespace App\Repositories\Eloquent;

use App\Models\Sale;
use App\Repositories\Interfaces\SaleRepositoryInterface;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class SaleRepository
 *
 * @package App\Repositories\Eloquent
 */
class SaleRepository implements SaleRepositoryInterface
{
    /**
     * @var Sale
     */
    protected $sale;

    /**
     * SaleRepository constructor.
     *
     * @param Sale $sale
     */
    public function __construct(Sale $sale)
    {
        $this->sale = $sale;
    }

    /**
     * Get all sales.
     *
     * @return mixed
     * @throws \Exception
     */
    public function getAll()
    {
        try {
            $sales = $this->sale->all();

            // Perform additional validation or logic if needed
            if ($sales->isEmpty()) {
                // Handle the case where no records are found
                throw new \Exception('No sale records found.');
            }

            // Return the retrieved records
            return $sales;
        } catch (\Exception $exception) {
            // Handle the exception (e.g., log, return a custom response, or rethrow)
            throw new \Exception('Error retrieving sale records: ' . $exception->getMessage());
        }
    }

    /**
     * Get the count of sales.
     *
     * @return int
     * @throws \Exception
     */
    public function count()
    {
        try {
            $count = $this->sale->count();

            // Perform additional validation or logic if needed
            if ($count < 0) {
                // Handle the case where the count is unexpected (less than 0)
                throw new \Exception('Invalid count value.');
            }

            // Return the count
            return $count;
        } catch (\Exception $exception) {
            // Handle the exception (e.g., log, return a custom response, or rethrow)
            throw new \Exception('Error counting sale records: ' . $exception->getMessage());
        }
    }

    /**
     * Find a sale by its ID.
     *
     * @param int $id
     * @return mixed
     * @throws \Exception
     */
    public function findByID($id)
    {
        try {
            $sale = $this->sale->find($id);

            // Perform additional validation or logic if needed
            if ($sale === null) {
                // Handle the case where the sale with the given ID is not found
                throw new ModelNotFoundException('Sale not found.');
            }

            // Return the retrieved sale
            return $sale;
        } catch (\Exception $exception) {
            // Handle the exception (e.g., log, return a custom response, or rethrow)
            throw new \Exception('Error finding sale by ID: ' . $exception->getMessage());
        }
    }

    /**
     * Find a sale by a specific column and value.
     *
     * @param string $column
     * @param mixed $value
     * @return mixed
     * @throws \Exception
     */
    public function findByColumn($column, $value)
    {
        try {
            // Validate that the column is valid (you might have a predefined list of valid columns)
            $validColumns = Schema::getColumnListing($this->sale->getTable()); // Replace with your valid columns

            if (!in_array($column, $validColumns)) {
                // Handle the case where the provided column is not valid
                throw new \InvalidArgumentException('Invalid column specified.');
            }

            $sales = $this->sale->where($column, $value)->get();

            // Perform additional validation or logic if needed
            if ($sales->isEmpty()) {
                // Handle the case where no matching records are found
                throw new ModelNotFoundException('No sales found with the specified column and value.');
            }

            // Return the retrieved sales
            return $sales;
        } catch (\Exception $exception) {
            // Handle the exception (e.g., log, return a custom response, or rethrow)
            throw new \Exception('Error finding sales by column: ' . $exception->getMessage());
        }
    }

    /**
     * Find sales by multiple columns.
     *
     * @param array $columns
     * @return mixed
     * @throws \Exception
     */
    public function findByColumns(array $columns)
    {
        try {
            // Validate that all columns are valid (similar to the above example)
            $validColumns = Schema::getColumnListing($this->sale->getTable());

            foreach ($columns as $column) {
                if (!in_array($column, $validColumns)) {
                    // Handle the case where one of the provided columns is not valid
                    throw new \InvalidArgumentException('Invalid column specified.');
                }
            }

            $sales = $this->sale->where($columns)->get();

            // Perform additional validation or logic if needed
            if ($sales->isEmpty()) {
                // Handle the case where no matching records are found
                throw new ModelNotFoundException('No sales found with the specified columns and values.');
            }

            // Return the retrieved sales
            return $sales;
        } catch (\Exception $exception) {
            // Handle the exception (e.g., log, return a custom response, or rethrow)
            throw new \Exception('Error finding sales by columns: ' . $exception->getMessage());
        }
    }

    /**
     * Store a new sale.
     *
     * @param array $input
     * @return mixed
     * @throws \Exception
     */
    public function store($input)
    {
        try {
            $data = [
                'ref_num' => $input['ref_num'] ?? null,
                'status' => $input['status'] ?? 1,
                'invoice_date' => $input['invoice_date'] ?? null,
                'delivery_date' => $input['delivery_date'] ?? null,
                'payee' => $input['payee'] ?? null,
                'payee_id' => $input['payee_id'] ?? null,
                'total' => $input['total'] ?? null,
                'currency' => $input['currency'] ?? null,
                'currency_total' => $input['currency_total'] ?? null,
                'paid' => $input['paid'] ?? null,
                'due' => $input['due'] ?? null,
                'rounding' => $input['rounding'] ?? null,
                'due_date' => $input['due_date'] ?? null,
                'attn' => $input['attn'] ?? null,
                'payment_term' => $input['payment_term'] ?? null,
                'payment_status' => $input['payment_status'] ?? null,
                'delivery_status' => $input['delivery_status'] ?? null,
                'branch_id' => $input['branch_id'] ?? null,
                'locked' => $input['locked'] ?? null,
                'staff_id' => $input['staff_id'] ?? null,
                'author_id' => $input['author_id'] ?? null,
                'invoice_date' => Carbon::now()->format('Y-m-d'),
                'delivery_date' => Carbon::now()->format('Y-m-d'),
                'due_date' => Carbon::now()->format('Y-m-d'),
                'created_at' => Carbon::now()
            ];
            $sale = $this->sale->create($data);

            // Check if the record was successfully created
            if ($sale) {
                // Return the created sale instance
                return $sale;
            } else {
                // Handle the case where the record creation failed
                throw new \Exception('Error creating sale record.');
            }
        } catch (\Exception $exception) {
            // Handle the exception (e.g., log, return a custom response, or rethrow)
            throw new \Exception('Error storing sale: ' . $exception->getMessage());
        }
    }

    /**
     * Update a sale by ID.
     *
     * @param int $id
     * @param array $input
     * @return mixed
     * @throws \Exception
     */
    public function update($id, $input)
    {
        try {
            // Find the sale with the given ID
            $sale = $this->sale->find($id);

            if (!$sale) {
                // Handle the case where the sale with the given ID is not found
                throw new ModelNotFoundException('Sale not found for updating.');
            }

            // Prepare the data for updating
            $data = [
                'ref_num' => $input['ref_num'] ?? $sale->ref_num,
                'status' => $input['status'] ?? $sale->status,
                'invoice_date' => $input['invoice_date'] ?? $sale->invoice_date,
                'delivery_date' => $input['delivery_date'] ?? $sale->delivery_date,
                'payee' => $input['payee'] ?? $sale->payee,
                'payee_id' => $input['payee_id'] ?? $sale->payee_id,
                'total' => $input['total'] ?? $sale->total,
                'currency' => $input['currency'] ?? $sale->currency,
                'currency_total' => $input['currency_total'] ?? $sale->currency_total,
                'paid' => $input['paid'] ?? $sale->paid,
                'due' => $input['due'] ?? $sale->due,
                'rounding' => $input['rounding'] ?? $sale->rounding,
                'due_date' => $input['due_date'] ?? $sale->due_date,
                'attn' => $input['attn'] ?? $sale->attn,
                'payment_term' => $input['payment_term'] ?? $sale->payment_term,
                'payment_status' => $input['payment_status'] ?? $sale->payment_status,
                'delivery_status' => $input['delivery_status'] ?? $sale->delivery_status,
                'branch_id' => $input['branch_id'] ?? $sale->branch_id,
                'locked' => $input['locked'] ?? $sale->locked,
                'staff_id' => $input['staff_id'] ?? $sale->staff_id,
                'author_id' => $input['author_id'] ?? $sale->author_id,
                'invoice_date' => Carbon::now()->format('Y-m-d'),
                'delivery_date' => Carbon::now()->format('Y-m-d'),
                'due_date' => Carbon::now()->format('Y-m-d')
            ];

            $updated = $sale->update($data);

            if ($updated) {
                // Return the updated sale instance
                return $sale;
            } else {
                // Handle the case where the update operation failed
                throw new \Exception('Error updating sale record.');
            }
        } catch (\Exception $exception) {
            // Handle the exception (e.g., log, return a custom response, or rethrow)
            throw new \Exception('Error updating sale: ' . $exception->getMessage());
        }
    }

    /**
     * Delete a sale by ID.
     *
     * @param int $id
     * @return mixed
     * @throws \Exception
     */
    public function destroy($id)
    {
        try {
            // Find the sale with the given ID
            $sale = $this->sale->find($id);

            if (!$sale) {
                // Handle the case where the sale with the given ID is not found
                throw new ModelNotFoundException('Sale not found for deletion.');
            }

            // Delete the sale
            return $sale->delete();
        } catch (\Exception $exception) {
            // Handle the exception (e.g., log, return a custom response, or rethrow)
            throw new \Exception('Error deleting sale: ' . $exception->getMessage());
        }
    }

    /**
     * Soft delete a sale by ID.
     *
     * @param int $id
     * @return mixed
     * @throws \Exception
     */
    public function softDelete($id)
    {
        try {
            // Find the sale with the given ID
            $sale = $this->sale->findOrFail($id);

            // Soft delete the sale
            return $sale->delete();
        } catch (\Exception $exception) {
            // Handle the exception (e.g., log, return a custom response, or rethrow)
            throw new \Exception('Error soft deleting sale: ' . $exception->getMessage());
        }
    }

    /**
     * Bulk soft delete sales by IDs.
     *
     * @param array $ids
     * @return mixed
     * @throws \Exception
     */
    public function bulkSoftDelete(array $ids)
    {
        if (empty($ids)) {
            // Handle the case where no IDs are provided
            throw new \InvalidArgumentException('No IDs provided for bulk soft delete.');
        }

        // Validate that the records exist and are not soft-deleted
        $existingRecords = $this->sale->whereIn('id', $ids)->get();

        // Check if all provided IDs exist
        if (count($existingRecords) !== count($ids)) {
            // Handle the validation error (e.g., throw an exception, log, or return a response)
            throw new ModelNotFoundException('One or more records not found or already deleted.');
        }

        // Perform soft deletion
        return $this->sale->whereIn('id', $ids)->delete();
    }

    /**
     * Force delete a soft-deleted sale by ID.
     *
     * @param int $id
     * @return mixed
     * @throws \Exception
     */
    public function forceDelete($id)
    {
        try {
            // Find the soft-deleted sale with the given ID
            $sale = $this->sale->withTrashed()->findOrFail($id);

            // Permanently delete the sale
            return $sale->forceDelete();
        } catch (\Exception $exception) {
            // Handle the exception (e.g., log, return a custom response, or rethrow)
            throw new \Exception('Error force deleting sale: ' . $exception->getMessage());
        }
    }

    /**
     * Bulk force delete soft-deleted sales by IDs.
     *
     * @param array $ids
     * @return mixed
     * @throws \Exception
     */
    public function bulkForceDelete(array $ids)
    {
        if (empty($ids)) {
            // Handle the case where no IDs are provided
            throw new \InvalidArgumentException('No IDs provided for bulk force delete.');
        }

        // Validate that the records exist and are not soft-deleted
        $existingRecords = $this->sale->whereIn('id', $ids)->withTrashed()->get();

        // Check if all provided IDs exist
        if (count($existingRecords) !== count($ids)) {
            // Handle the validation error (e.g., throw an exception, log, or return a response)
            throw new ModelNotFoundException('One or more records not found or already deleted.');
        }

        // Perform force deletion
        return $this->sale->whereIn('id', $ids)->forceDelete();
    }

    /**
     * Get soft-deleted sales.
     *
     * @return mixed
     * @throws \Exception
     */
    public function getSoftDeleted()
    {
        try {
            // Retrieve all soft-deleted sales
            $softDeletedSales = $this->sale->onlyTrashed()->get();

            // Check if there are any soft-deleted sales
            if ($softDeletedSales->isEmpty()) {
                // Handle the case where no soft-deleted sales are found
                throw new ModelNotFoundException('No soft-deleted sales found.');
            }

            // Return the soft-deleted sales
            return $softDeletedSales;
        } catch (\Exception $exception) {
            // Handle other exceptions (e.g., log, return a custom response, or rethrow)
            throw new \Exception('Error getting soft-deleted sales: ' . $exception->getMessage());
        }
    }

    /**
     * Recover a soft-deleted sale by ID.
     *
     * @param int $id
     * @return mixed
     * @throws \Exception
     */
    public function recover($id)
    {
        try {
            $sale = $this->sale->withTrashed()->findOrFail($id);

            if ($sale->trashed()) {
                return $sale->restore();
            } else {
                // Sale is not soft-deleted
                throw new \LogicException('The sale is not soft-deleted.');
            }
        } catch (ModelNotFoundException $exception) {
            // Handle the exception (e.g., log, return a custom response, or rethrow)
            throw new ModelNotFoundException('Sale not found or soft-deleted.', 404);
        }
    }

    /**
     * Bulk recover soft-deleted sales by IDs.
     *
     * @param array $ids
     * @return mixed
     * @throws \Exception
     */
    public function bulkRecoverSoftDelete(array $ids)
    {
        if (empty($ids)) {
            // Handle the case where no IDs are provided
            throw new \InvalidArgumentException('No IDs provided for bulk recover soft delete.');
        }

        // Validate that the records exist and are not soft-deleted
        $existingRecords = $this->sale->whereIn('id', $ids)->withTrashed()->get();

        // Check if all provided IDs exist
        if (count($existingRecords) !== count($ids)) {
            // Handle the validation error (e.g., throw an exception, log, or return a response)
            throw new ModelNotFoundException('One or more records not found or already deleted.');
        }

        // Perform force deletion
        return $this->sale->whereIn('id', $ids)->restore();
    }


    /**
     * Find a sale with trashed records by ID.
     *
     * @param int $id
     * @return mixed
     * @throws \Exception
     */
    public function findWithTrashed($id)
    {
        try {
            // Find the sale with the given ID, including soft-deleted ones
            $sale = $this->sale->withTrashed()->findOrFail($id);

            // Return the retrieved sale
            return $sale;
        } catch (ModelNotFoundException $exception) {
            // Handle the case where the sale with the given ID is not found (soft-deleted or permanently deleted)
            throw new ModelNotFoundException('Sale not found.');
        } catch (\Exception $exception) {
            // Handle other exceptions (e.g., log, return a custom response, or rethrow)
            throw new \Exception('Error finding sale with trashed: ' . $exception->getMessage());
        }
    }
    /**
     * Paginate sales.
     *
     * @param int $perPage
     * @param string $orderColumn
     * @param string $orderDirection
     * @return mixed
     * @throws \Exception
     */
    public function paginate($perPage = 10, $orderColumn = 'id', $orderDirection = 'asc')
    {
        // Ensure $perPage is a positive integer
        if (!is_int($perPage) || $perPage < 1) {
            // Handle the validation error (e.g., throw an exception, log, or return a response)
            throw new \InvalidArgumentException('Invalid perPage value. It must be a positive integer.');
        }

        try {
            // Perform pagination
            return $this->sale->orderBy($orderColumn, $orderDirection)->paginate($perPage);
        } catch (ModelNotFoundException $exception) {
            // Handle the case where no records are found
            // (Note: paginate won't throw a ModelNotFoundException, but other methods might)
            throw new ModelNotFoundException('No records found.');
        } catch (\Exception $exception) {
            // Handle other exceptions (e.g., log, return a custom response, or rethrow)
            throw new \Exception('Error paginating records: ' . $exception->getMessage());
        }
    }

    /**
     * Filter sales based on provided filters.
     *
     * @param array $filters
     * @param string $orderColumn
     * @param string $orderDirection
     * @return mixed
     * @throws \Exception
     */
    public function filter(array $filters, $orderColumn = 'id', $orderDirection = 'asc')
    {
        // Check if the specified filter columns exist in the table
        $tableColumns = Schema::getColumnListing($this->sale->getTable());
        foreach (array_keys($filters) as $column) {
            if (!in_array($column, $tableColumns)) {
                // Handle the case where a specified filter column does not exist
                throw new \InvalidArgumentException("Column '$column' does not exist in the table.");
            }
        }

        try {
            // Start with a base query
            $sale = $this->sale->orderBy($orderColumn, $orderDirection);

            // Apply filters to the query
            // foreach ($filters as $column => $value) {
            //     $sale->where($column, $value);
            // }

            // Apply filters to the query using OR conditions
            $sale->where(function ($query) use ($filters) {
                foreach ($filters as $column => $value) {
                    $query->orWhere($column, $value);
                }
            });


            // Retrieve the filtered records
            return $sale->get();
        } catch (ModelNotFoundException $exception) {
            // Handle the case where no records are found
            throw new ModelNotFoundException('No records found.');
        } catch (\Exception $exception) {
            // Handle other exceptions (e.g., log, return a custom response, or rethrow)
            throw new \Exception('Error filtering records: ' . $exception->getMessage());
        }
    }

    /**
     * Bulk update sales with the given data for specified IDs.
     *
     * @param array $ids
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function bulkUpdate(array $ids, array $data)
    {
        if (empty($ids)) {
            // Handle the case where no IDs are provided
            throw new \InvalidArgumentException('No IDs provided for bulk update.');
        }

        // Validate that the records exist
        $existingRecords = $this->sale->whereIn('id', $ids)->get();

        // Check if all provided IDs exist
        if ($existingRecords->count() !== count($ids)) {
            // Handle the validation error (e.g., throw an exception, log, or return a response)
            throw new ModelNotFoundException('One or more records not found.');
        }

        // Perform bulk update
        return $this->sale->whereIn('id', $ids)->update($data);
    }
}
