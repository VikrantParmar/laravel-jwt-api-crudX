<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use App\Models\Category;
use App\Helpers\FileUploadHelper;
use Illuminate\Http\Request;
use App\Http\Responses\Api\ApiResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;
use App\Services\FileUploadService;

class BlogController extends ApiController
{
    protected $fileUploadService;
    public function __construct(FileUploadService $fileUploadService)
    {
        parent::__construct();
        // Middleware can be applied here if needed
        $this->fileUploadService = $fileUploadService;
    }

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
        $query = Blog::with('category');

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
                if (in_array($sortField, ['title', 'created_at', 'id']) && in_array(strtolower($sortOrder), ['asc', 'desc'])) {
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
    public function store(BlogRequest $request)
    {
        $validated = $request->validated();

        $imageData = null;
        if ($request->hasFile('image')) {
            $imageData = $this->fileUploadService->handleImageUpload($request,'image', 'blog');
            #$imageName = $this->handleImageUpload($request);
        }
        $slug = $this->generateUniqueSlug($validated['title']);
        $recordAdd = Blog::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'category_id' => $validated['category_id'],
            'slug' => $slug,
            'image' => $imageData ? $imageData['file_path'] : null,
        ]);

        return ApiResponse::success([], __('messages.record_created_success'));
    }

    // Display the specified record
    public function show($id)
    {
        try {
            $record =  Blog::with('category')->findOrFail($id);
            if(!$record){
                return ApiResponse::error(__('messages.record_not_found'), [], Response::HTTP_NOT_FOUND);
            }
            return ApiResponse::success($record, __('messages.record_found'));
        }
        catch (\Exception $e) {
            \Log::error('Error : ' . $e->getMessage());// You can also choose to return an error response here
            return ApiResponse::error(__('messages.something_went_wrong')  , [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    // Update the specified record
    public function update(BlogRequest $request, $id)
    {
        try {
            $record =  Blog::findOrFail($id);
            if(!$record){
                return ApiResponse::error(__('messages.record_not_found'), [], Response::HTTP_NOT_FOUND);
            }
            $validated = $request->validated();
            // Handle image upload if present
            if ($request->hasFile('image')) {
                $imageData = $this->fileUploadService->handleImageUpdate($request,'image',$record , 'blog');
                $validated['image'] = $imageData ? $imageData['file_path'] : null;
            }
            $slug = $this->generateUniqueSlug($validated['title']);
            $record->update([
                'title' => $validated['title'],
                'content' => $validated['content'],
                'category_id' => $validated['category_id'],
                'slug' => $slug,
                'image' => $validated['image'] ?? $record->image,
            ]);
            return ApiResponse::success($record, __('messages.record_updated_success'));
        } catch (\Exception $e) {
            dd($e);
            \Log::error('Error : ' . $e->getMessage());
            return ApiResponse::error(__('messages.something_went_wrong')  , [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
    // Soft delete the specified record
    public function destroy($id)
    {
        try {
            $record = Blog::findOrFail($id);
            if(!$record){
                return ApiResponse::error(__('messages.record_not_found'), [], Response::HTTP_NOT_FOUND);
            }
            $record->delete();
            return ApiResponse::success([], __('messages.record_deleted_successfully'));
        } catch (\Exception $e) {
            \Log::error('Error : ' . $e->getMessage());
            // You can also choose to return an error response here
            return ApiResponse::error(__('messages.something_went_wrong')  , [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $slugCount = Blog::where('slug', 'like', $slug.'%')->count();
        if ($slugCount > 0) {
            $slug = $slug . '-' . ($slugCount + 1);
        }
        return $slug;
    }
}