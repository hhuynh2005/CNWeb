<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Hiển thị danh sách sản phẩm với phân trang
     */
    public function index()
    {
        $products = Product::with('store')->paginate(5);
        return view('products.index', compact('products'));
    }

    /**
     * Hiển thị form tạo phòng mới
     */
    public function create()
    {
        $stores = Store::all();
        return view('products.create', compact('stores'));
    }

    /**
     * Lưu phòng mới vào database
     */
    public function store(Request $request)
    {
        $request->validate([
            // Tên sản phẩm: bắt buộc, là chuỗi
            'name' => 'required|string',

            // Mô tả: không bắt buộc (nullable)
            'description' => 'nullable|string',

            // Giá: bắt buộc, là số, lớn hơn 0
            'price' => 'required|numeric|min:0.01',

            // Cửa hàng: bắt buộc, phải tồn tại trong bảng stores
            'store_id' => 'required|exists:stores,id',
        ], [
            // Custom error messages (tiếng Việt)
            'name.required' => 'Vui lòng nhập tên sản phẩm',
            'name.string' => 'Tên sản phẩm phải là chuỗi ký tự',

            'description.string' => 'Mô tả phải là chuỗi ký tự',
            'store_id.required' => 'Vui lòng chọn cửa hàng',
            'store_id.exists' => 'Cửa hàng không tồn tại',
            'price.required' => 'Vui lòng nhập giá sản phẩm',
            'price.numeric' => 'Giá phải là số',
            'price.min' => 'Giá phải lớn hơn 0',
        ]);

        Product::create($request->all());

        return redirect()->route('products.index')
            ->with('success', 'Them san pham thanh cong');
    }

    /**
     * Hiển thị thông tin chi tiết phòng
     */
    public function show($id)
    {
        $Product = Product::with('Product')->findOrFail($id);
        return view('products.show', compact('Product'));
    }

    /**
     * Hiển thị form chỉnh sửa phòng
     */
    public function edit($id)
    {
        // lấy số ít tránh trùng
        $product = Product::findOrFail($id);
        $stores = Store::all();
        return view('products.edit', compact('product', 'stores'));
    }

    /**
     * Cập nhật thông tin phòng
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            // Tên sản phẩm: bắt buộc, là chuỗi
            'name' => 'required|string',

            // Mô tả: không bắt buộc (nullable)
            'description' => 'nullable|string',

            // Giá: bắt buộc, là số, lớn hơn 0
            'price' => 'required|numeric|min:0.01',

            // Cửa hàng: bắt buộc, phải tồn tại trong bảng stores
            'store_id' => 'required|exists:stores,id',
        ], [
            // Custom error messages (tiếng Việt)
            'name.required' => 'Vui lòng nhập tên sản phẩm',
            'name.string' => 'Tên sản phẩm phải là chuỗi ký tự',

            'description.string' => 'Mô tả phải là chuỗi ký tự',

            'price.required' => 'Vui lòng nhập giá sản phẩm',
            'price.numeric' => 'Giá phải là số',
            'price.min' => 'Giá phải lớn hơn 0',
        ]);


        $product = Product::findOrFail($id);
        $product->update($request->all());

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully!');
    }

    /**
     * Xóa phòng
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Xoas thanh cong san pham');
    }
}
