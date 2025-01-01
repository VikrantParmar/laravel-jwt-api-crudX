<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Responses\Api\ApiResponse;
use Symfony\Component\HttpFoundation\Response;
class CategoryController extends Controller
{
    public function __construct()
    {
        // Middleware can be applied here if needed
    }
    // Display a listing of categories
    public function index()
    {
        $data = Category::all();
        return ApiResponse::success([
            'list' => $data
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
        if(!$record){
            return ApiResponse::error(__('messages.record_not_found'), [], Response::HTTP_NOT_FOUND);
        }
        return ApiResponse::success($record, __('messages.record_found'));

    }
    // Update the specified record
    public function update(CategoryRequest $request, $id)
    {

        $record = Category::findOrFail($id);
        if(!$record){
            return ApiResponse::error(__('messages.record_not_found'), [], Response::HTTP_NOT_FOUND);
        }
        $record->update($request->validated());
        return ApiResponse::success($record, __('messages.record_updated_success'));


    }
    // Soft delete the specified record
    public function destroy($id)
    {

        $record = Category::findOrFail($id);
        if(!$record){
            return ApiResponse::error(__('messages.record_not_found'), [], Response::HTTP_NOT_FOUND);
        }
        $record->delete();
        return ApiResponse::success([], __('messages.record_deleted_successfully'));

    }
}