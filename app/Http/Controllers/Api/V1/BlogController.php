<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use App\Models\Category;
use App\Helpers\FileUploadHelper;
use Illuminate\Http\Request;
use App\Http\Responses\Api\ApiResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;
use App\Services\FileUploadService;

class BlogController extends Controller
{
    protected $fileUploadService;
    public function __construct(FileUploadService $fileUploadService)
    {
        // Middleware can be applied here if needed
        $this->fileUploadService = $fileUploadService;
    }

    // Display a listing of categories
    public function index()
    {
        $data = Blog::with('category')->get();
        return ApiResponse::success([
            'list' => $data
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

    /* private function handleImageUpload(Request $request)
     {
         if ($request->hasFile('image')) {
             $image = $request->file('image');
             $uploadResult = FileUploadHelper::uploadSingleFile($image, 'blog', '');
             if ($uploadResult === null) {
                 throw new \Exception(__('messages.file_upload_failed'));
             }
             return $uploadResult['file_path'];
         }
         return null;
     }

     private function handleImageUpdate(Request $request, Blog $record)
     {
         $imageName = $record->image;

         if ($request->hasFile('image')) {
             $image = $request->file('image');
             $uploadResult = FileUploadHelper::uploadSingleFile($image, 'blog', '');
             if ($uploadResult === null) {
                 throw new \Exception(__('messages.file_upload_failed'));
             }
             if ($record->image) {
                 Storage::disk('image')->delete($record->image);
             }
             $imageName = $uploadResult['file_path'];
         }
         return $imageName;
     }*/
}