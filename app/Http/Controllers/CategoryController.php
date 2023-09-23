<?php

namespace App\Http\Controllers;

use App\Models\Category;
use DebugBar\DebugBar;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        return view('admin.storeCategory');
    }
    public function loadCategory()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    // Phương thức để lưu thể loại mới
    public function storeCategory(Request $request)
    {
        // Validate dữ liệu từ biểu mẫu
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|integer',
        ]);

        // Tạo một bản ghi mới trong CSDL
        $category = new Category();
        $category->name = $request->input('name');
        $category->parent_id = $request->input('parent_id');
        $category->save();

        // Trả về kết quả trong JSON để xử lý bên phía client
        return response()->json(['success' => true]);
    }

    // Phương thức để cập nhật thể loại
    public function updateCategory(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'parent_id' => 'nullable|numeric',
        ]);

        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Không tìm thấy thể loại.'], 404);
        }

        $category->update($validatedData);

        return response()->json(['message' => 'Thể loại đã được cập nhật thành công.']);
    }
    public function editCategory($id)
    {
        $category = Category::find($id);
        
        return response()->json($category);
    }
    // Phương thức để xóa thể loại
    public function deleteCategory($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Không tìm thấy thể loại.'], 404);
        }

        $category->delete();

        return response()->json(['message' => 'Thể loại đã được xóa thành công.']);
    }
}

