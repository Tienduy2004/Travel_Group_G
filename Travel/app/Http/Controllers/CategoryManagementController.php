<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryManagementController extends Controller
{
    public function index(Request $request)
    {
        
        $categories = Category::all();

        return view('admin.category.categories_index', compact('categories'));
    }



    public function create()
    {
        return view('admin.category.category_create');
    }

    public function store(Request $request)
    {
        // Xác thực và kiểm tra trùng lặp với thông báo lỗi tùy chỉnh
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ], [
            'name.unique' => 'Danh mục đã tồn tại!!', // Thông báo lỗi tùy chỉnh
            'name.required' => 'Vui lòng nhập tên danh mục!',
            'name.max' => 'Tên danh mục không được vượt quá 255 ký tự.',
        ]);

        // Tạo mới danh mục
        Category::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.category.index')->with('success', 'Danh mục đã được thêm thành công');
    }



    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category.category_edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        // Xác thực và cập nhật danh mục
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::findOrFail($id);
        $category->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.category.index')->with('success', 'Danh mục đã được cập nhật thành công');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.category.index')->with('success', 'Danh mục đã được xóa thành công');
    }

}
