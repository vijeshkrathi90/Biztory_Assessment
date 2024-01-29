<?php

namespace App\Http\Controllers\Api\V1;

use App\Repositories\Interfaces\SaleRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SaleController extends BaseController
{
    protected $salesRepositoryInterface;

    public function __construct(SaleRepositoryInterface $salesRepositoryInterface)
    {
        $this->salesRepositoryInterface = $salesRepositoryInterface;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            // Retrieve all sales records
            $sales = $this->salesRepositoryInterface->getAll();

            if ($sales) {
                // Respond with success and sales data
                return $this->respond($sales, [], true, false, 'Success!');
            } else {
                // Respond with not found if no records are available
                return $this->respondNotFound([], false, true, 'Records Not Found!');
            }
        } catch (\Exception $exception) {
            // Respond with internal error if an exception occurs
            return $this->respondInternalError($exception->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            // Validate incoming request data
            $validatedData = $request->validate([
                'status'            => 'required|numeric|in:1,2,3',
                'ref_num'           => 'required|string|max:50|unique:sales',
                'invoice_date'      => 'required|date|date_format:Y-m-d|after_or_equal:' . now()->toDateString(),
                'delivery_date'     => 'nullable|date|date_format:Y-m-d|after_or_equal:' . now()->toDateString(),
                'payee'             => 'required|string|max:255',
                'payee_id'          => 'required|numeric',
                'total'             => 'required|numeric',
                'currency'          => 'nullable|string|max:3',
                'currency_total'    => 'required|numeric',
                'paid'              => 'required|numeric',
                'due'               => 'required|numeric',
                'rounding'          => 'nullable|numeric',
                'due_date'          => 'nullable|date|date_format:Y-m-d|after_or_equal:' . now()->toDateString(),
                'attn'              => 'nullable|string|max:200',
                'payment_term'      => 'nullable|string|max:20',
                'payment_status'    => 'required|numeric|in:0,1',
                'delivery_status'   => 'required|numeric|in:0,1',
                'branch_id'         => 'nullable|numeric',
                'locked'            => 'required|numeric|in:1,2,3',
                'staff_id'          => 'nullable|numeric'
            ]);

            // Create a new sale record
            $sales = $this->salesRepositoryInterface->store($validatedData);

            // Respond with success and the created sale data
            return $this->respondObjectCreated($sales, [], true, 'Sales created successfully');
        } catch (ValidationException $e) {
            // Respond with unprocessable entity if validation fails
            return $this->respondUnprocessableEntity($e->errors(), false, true, 'Unprocessable Entity!');
        } catch (\Exception $exception) {
            // Respond with internal error if an exception occurs
            return $this->respondInternalError($exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $id)
    {
        try {
            // Get a single record with where clause
            $sales = $this->salesRepositoryInterface->findByID($id);

            // Return a response
            if ($sales) {
                // Respond with success and the retrieved sale data
                return $this->respond($sales, [], true, false, 'Success!');
            } else {
                // Respond with not found if the record is not available
                return $this->respondNotFound([], false, true, 'Records Not Found!');
            }
        } catch (\Exception $exception) {
            // Respond with internal error if an exception occurs
            return $this->respondInternalError($exception->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, string $id)
    {
        try {
            // Find the sale record by ID
            $sales = $this->salesRepositoryInterface->findByID($id);

            if (!$sales) {
                // Respond with not found if the record is not available
                return $this->respondNotFound([], false, true, 'Record not found');
            }

            $validatedData = $request->validate([
                'status'            => 'required|numeric|in:1,2,3',
                'ref_num'           => 'required|string|max:50|unique:sales,ref_num,' . $id,
                'invoice_date'      => 'required|date|date_format:Y-m-d|after_or_equal:' . now()->toDateString(),
                'delivery_date'     => 'nullable|date|date_format:Y-m-d|after_or_equal:' . now()->toDateString(),
                'payee'             => 'required|string|max:255',
                'payee_id'          => 'required|numeric',
                'total'             => 'required|numeric',
                'currency'          => 'nullable|string|max:3',
                'currency_total'    => 'required|numeric',
                'paid'              => 'required|numeric',
                'due'               => 'required|numeric',
                'rounding'          => 'nullable|numeric',
                'due_date'          => 'nullable|date|date_format:Y-m-d|after_or_equal:' . now()->toDateString(),
                'attn'              => 'nullable|string|max:200',
                'payment_term'      => 'nullable|string|max:20',
                'payment_status'    => 'required|numeric|in:0,1',
                'delivery_status'   => 'required|numeric|in:0,1',
                'branch_id'         => 'nullable|numeric',
                'locked'            => 'required|numeric|in:1,2,3',
                'staff_id'          => 'nullable|numeric'
            ]);

            // Update the sale record
            $sales = $this->salesRepositoryInterface->update($id, $validatedData);

            // Respond with success and the updated sale data
            return $this->respond($sales, [], true, false, 'Success!');
        } catch (ValidationException $exception) {
            // Respond with unprocessable entity if validation fails
            return $this->respondUnprocessableEntity($exception->errors(), false, true, 'Unprocessable Entity!');
        } catch (\Exception $exception) {
            // Respond with internal error if an exception occurs
            return $this->respondInternalError($exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage Soft Delete.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id)
    {
        try {
            // Find the sale record by ID
            $sales = $this->salesRepositoryInterface->findByID($id);

            if (!$sales) {
                // Respond with not found if the record is not available
                return $this->respondNotFound([], false, true, 'Record not found');
            }

            // Soft delete the sale record
            $this->salesRepositoryInterface->softDelete($id);

            // Respond with success for soft deletion
            return $this->respondNoContent([], true, false, 'Sale soft deleted successfully');
        } catch (\Exception $exception) {
            // Respond with internal error if an exception occurs
            return $this->respondInternalError($exception->getMessage());
        }
    }

    /**
     * Bulk Soft Delete the specified resources from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function bulkSoftDelete(Request $request)
    {
        $saleIds = $request->input('ids', []);

        try {
            // Get sale IDs from the request
            // Check if any sale IDs are provided
            if (empty($saleIds)) {
                // Respond with unprocessable entity if no sale IDs are provided
                return $this->respondUnprocessableEntity([], false, true, 'No sale IDs provided for bulk soft delete');
            }

            // Perform bulk soft delete
            $this->salesRepositoryInterface->bulkSoftDelete($saleIds);

            // Respond with success for bulk soft delete
            return $this->respondNoContent([], true, false, 'Sales bulk soft deleted successfully');
        } catch (\Exception $exception) {
            // Respond with internal error if an exception occurs
            return $this->respondInternalError($exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage Hard Delete.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function forceDelete(string $id)
    {
        try {
            // Find the sale record with trashed data by ID
            $sales = $this->salesRepositoryInterface->findWithTrashed($id);

            if (!$sales) {
                // Respond with not found if the record is not available
                return $this->respondNotFound([], false, true, 'Record not found');
            }

            // Hard delete the sale record
            $this->salesRepositoryInterface->forceDelete($id);

            // Respond with success for permanent deletion
            return $this->respondNoContent([], true, false, 'Sales permanently deleted successfully');
        } catch (\Exception $exception) {
            // Respond with internal error if an exception occurs
            return $this->respondInternalError($exception->getMessage());
        }
    }

    /**
     * Bulk Force Delete the specified resources from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function bulkForceDelete(Request $request)
    {
        try {
            // Get sale IDs from the request
            $saleIds = $request->input('ids', []);

            // Check if any sale IDs are provided
            if (empty($saleIds)) {
                // Respond with unprocessable entity if no sale IDs are provided
                return $this->respondUnprocessableEntity([], false, true, 'No sale IDs provided for bulk force delete');
            }

            // Perform bulk force delete
            $this->salesRepositoryInterface->bulkForceDelete($saleIds);

            // Respond with success for bulk force delete
            return $this->respondNoContent([], true, false, 'Sales bulk force deleted successfully');
        } catch (\Exception $exception) {
            // Respond with internal error if an exception occurs
            return $this->respondInternalError($exception->getMessage());
        }
    }

    /**
     * Recover or Restored Soft Delete Record.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function recoverSoftDeleted(string $id)
    {
        try {
            // Find the sale record with trashed data by ID
            $sales = $this->salesRepositoryInterface->findWithTrashed($id);

            if (!$sales) {
                // Respond with not found if the record is not available
                return $this->respondNotFound([], false, true, 'Record not found');
            }

            // Recover the soft-deleted sale record
            $this->salesRepositoryInterface->recover($id);

            // Respond with success for recovery
            return $this->respond($sales, [], true, false, 'Sales recovered successfully');
        } catch (\Exception $exception) {
            // Respond with internal error if an exception occurs
            return $this->respondInternalError($exception->getMessage());
        }
    }

    /**
     * Bulk Recover Soft Deleted resources.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function bulkRecoverSoftDeleted(Request $request)
    {
        try {
            // Get sale IDs from the request
            $saleIds = $request->input('ids', []);

            // Check if any sale IDs are provided
            if (empty($saleIds)) {
                // Respond with unprocessable entity if no sale IDs are provided
                return $this->respondUnprocessableEntity([], false, true, 'No sale IDs provided for bulk recover');
            }

            // Perform bulk recover for soft-deleted records
            foreach ($saleIds as $saleId) {
                $this->salesRepositoryInterface->recover($saleId);
            }

            // Respond with success for bulk recover
            return $this->respondNoContent([], true, false, 'Sales bulk recovered successfully');
        } catch (\Exception $exception) {
            // Respond with internal error if an exception occurs
            return $this->respondInternalError($exception->getMessage());
        }
    }

    /**
     * Get soft-deleted sales records.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSoftDeleted()
    {
        try {
            // Get soft-deleted sales records
            $sales = $this->salesRepositoryInterface->getSoftDeleted();

            // Respond with success and soft-deleted sales data
            return $this->respond($sales, [], true, false, 'Sales soft deleted records successfully');
        } catch (\Exception $exception) {
            // Respond with internal error if an exception occurs
            return $this->respondInternalError($exception->getMessage());
        }
    }

    /**
     * Paginate and return sales records.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function paginate(Request $request)
    {
        try {
            // Get the per_page parameter from the request (default: 10)
            $per_page = $request->input('per_page', 10);

            // Paginate sales records
            $sales = $this->salesRepositoryInterface->paginate($per_page);

            // Respond with success and paginated sales data
            return $this->respond($sales, [], true, false, 'Sales paginated successfully');
        } catch (\Exception $exception) {
            // Respond with internal error if an exception occurs
            return $this->respondInternalError($exception->getMessage());
        }
    }

    /**
     * Filter and return sales records based on specified criteria.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function filter(Request $request)
    {
        try {
            // Get all filters from the request
            $filters = $request->all(); // Adjust based on your filter criteria

            // Filter sales records based on specified criteria
            $sales = $this->salesRepositoryInterface->filter($filters);

            // Respond with success and filtered sales data
            return $this->respond($sales, [], true, false, 'Sales filtered successfully');
        } catch (\Exception $exception) {
            // Respond with internal error if an exception occurs
            return $this->respondInternalError($exception->getMessage());
        }
    }

    /**
     * Count the total number of sales records.
     *
     * @return int
     */
    public function totalSales()
    {
        try {
            // Use the count method to get the total number of sales records
            $count = $this->salesRepositoryInterface->count();

            // Perform additional validation or logic if needed
            if ($count < 0) {
                // Handle the case where the count is unexpected (less than 0)
                throw new \Exception('Invalid count value.');
            }

            // Return the count
            //return $count;
            return $this->respond($count, [], true, false, 'Total Sales successfully');
        } catch (\Exception $exception) {
            // Handle the exception (e.g., log, return a custom response, or rethrow)
            throw new \Exception('Error counting sales records: ' . $exception->getMessage());
        }
    }
}
