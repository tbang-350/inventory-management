<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Unit;
use App\Models\Category;
use Auth;
use Illuminate\Support\Carbon;
use Image;

class ProductController extends Controller
{
    
    public function ProductAll(){

        $products = Product::latest()->get();

        return view('backend.product.product_all',compact('products'));

    } // End Method


    public function ProductAdd()
    {
        $supplier = Supplier::all();
        $unit = Unit::all();
        $category = Category::all();

        return view('backend.product.product_add',compact('supplier', 'unit', 'category'));

    } // End Method


    public function ProductStore(Request $request){

        $image = $request->file('product_image');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

        Image::make($image)->resize(200, 200)->save('upload/products/' . $name_gen);
        $save_url = 'upload/products/' . $name_gen;

        Product::insert([

            'name' => $request->name,
            'supplier_id' => $request->supplier_id,
            'unit_id' => $request->unit_id,
            'category_id' => $request->category_id,
            'quantity' => '0',
            'product_image' => $save_url,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Product Added Successfully',
            'alert-type' => 'success',
        );

        return redirect()->route('product.all')->with($notification);

    } // End Method


    public function ProductEdit($id){

        $supplier = Supplier::all();
        $unit = Unit::all();
        $category = Category::all();

        $product = Product::findOrFail($id);

        return view('backend.product.product_edit', compact('supplier', 'unit', 'category','product'));

    } //End Method


    public function ProductUpdate(Request $request)
    {

        $product_id = $request->id;

        if ($request->file('product_image')) {

            $image = $request->file('product_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

            Image::make($image)->resize(200, 200)->save('upload/products/' . $name_gen);
            $save_url = 'upload/products/' . $name_gen;

            Product::findOrFail($product_id)->update([

                'name' => $request->name,
                'supplier_id' => $request->supplier_id,
                'unit_id' => $request->unit_id,
                'category_id' => $request->category_id,
                'quantity' => '0',
                'product_image' => $save_url,
                'updated_by' => Auth::user()->id,
                'updated_at' => Carbon::now(),

            ]);

            $notification = array(
                'message' => 'Product Updated with image Successfully',
                'alert-type' => 'success',
            );

            return redirect()->route('product.all')->with($notification);

        } else {
            
            Product::findOrFail($product_id)->update([

                'name' => $request->name,
                'supplier_id' => $request->supplier_id,
                'unit_id' => $request->unit_id,
                'category_id' => $request->category_id,
                'quantity' => '0',
                'created_by' => Auth::user()->id,
                'created_at' => Carbon::now(),

            ]);

            $notification = array(
                'message' => 'Product Updated Successfully',
                'alert-type' => 'success',
            );

            return redirect()->route('product.all')->with($notification);

        }

    } // End Method


    public function ProductDelete($id){

        $product = Product::findOrFail($id);
        $img = $product->product_image;
        unlink($img);

        Product::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Product Deleted Successfully',
            'alert-type' => 'success',
        );

        return redirect()->back()->with($notification);

    } // End Method

}
