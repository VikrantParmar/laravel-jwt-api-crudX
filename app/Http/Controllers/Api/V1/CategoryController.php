<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Responses\Api\ApiResponse;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
    }
    // Display a listing of categories
    public function index(Request $request)
    {
        // Get pagination parameters
        $page = $request->input('pageIndex', 1);
        $pageSize = $request->input('pageSize', 10);
        // Get sorting parameters
        $sorting = $request->input('sorting', []);
        $defaultSortField = 'id';
        $defaultSortOrder = 'desc';
        $filters = $request->input('filters', []);

        // Query with dynamic filters and sorting
        $query = Category::query();

        // Apply filters dynamically
        if (is_array($filters) && count($filters) > 0) {
            foreach ($filters as $field => $option) {
                if (!empty($option) && $option['value'] != '') {
                    // Apply the filter using LIKE
                    $query->where($option['id'], 'like', "%{$option['value']}%");
                }
            }
        }
        // Apply sorting dynamically
        if (is_array($sorting) && count($sorting) > 0) {
            foreach ($sorting as $sort) {
                $sortField = $sort['id'] ?? $defaultSortField;
                $sortOrder = $sort['desc'] == "true" ? 'desc' : 'asc';
                if (in_array($sortField, ['name', 'created_at', 'id']) && in_array(strtolower($sortOrder), ['asc', 'desc'])) {
                    $query->orderBy($sortField, $sortOrder);
                }
            }
        } else {
            // Default sorting
            $query->orderBy($defaultSortField, $defaultSortOrder);
        }

        // Paginate the result // 'pageIndex' as the page parameter name
        $data = $query->paginate($pageSize, ['*'], 'pageIndex', $page + 1);
        #dd($query->toSql(), $query->getBindings());
        // Return response with pagination metadata
        return ApiResponse::success([
            'list' => $data->items(),
            'pagination' => [
                'totalPages' => $data->lastPage(),
                'currentPage' => $data->currentPage(),
                'totalItems' => $data->total(),
            ]
        ]);
    }

    // Store a newly created record
    public function store(CategoryRequest $request)
    {
        Category::create($request->validated());
        return ApiResponse::success([], __('messages.record_created_success'));
    }

    // Display the specified record
    public function show($id)
    {
        $record = Category::findOrFail($id);
        if (!$record) {
            return ApiResponse::error(__('messages.record_not_found'), [], Response::HTTP_NOT_FOUND);
        }
        return ApiResponse::success($record, __('messages.record_found'));
    }
    // Update the specified record
    public function update(CategoryRequest $request, $id)
    {

        $record = Category::findOrFail($id);
        if (!$record) {
            return ApiResponse::error(__('messages.record_not_found'), [], Response::HTTP_NOT_FOUND);
        }
        $record->update($request->validated());
        return ApiResponse::success([], __('messages.record_updated_success'));
    }
    // Soft delete the specified record
    public function destroy($id)
    {

        $record = Category::findOrFail($id);
        if (!$record) {
            return ApiResponse::error(__('messages.record_not_found'), [], Response::HTTP_NOT_FOUND);
        }
        $record->delete();
        return ApiResponse::success([], __('messages.record_deleted_successfully'));
    }
}
