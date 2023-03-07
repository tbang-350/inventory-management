<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Image;

class CustomerController extends Controller
{
    public function CustomerAll()
    {

        $customers = Customer::latest()->get();

        return view('backend.customer.customer_all', compact('customers'));

    } // End Method

    public function CustomerAdd()
    {

        return view('backend.customer.customer_add');

    } // End Method


    public function CustomerStore(Request $request)
    {

        $image = $request->file('customer_image');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

        Image::make($image)->resize(200, 200)->save('upload/customer/' . $name_gen);
        $save_url = 'upload/customer/' . $name_gen;

        Customer::insert([
            'name' => $request->name,
            'mobile_no' => $request->mobile_no,
            'address' => $request->address,
            'email' => $request->email,
            'customer_image' => $save_url,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Customer Added Successfully',
            'alert-type' => 'success',
        );

        return redirect()->route('customer.all')->with($notification);

    } // End Method


    public function CustomerEdit($id)
    {

        $customer = Customer::findOrFail($id);
        return view('backend.customer.customer_edit', compact('customer'));

    } // End Method


    public function CustomerUpdate(Request $request)
    {

        $customer_id = $request->id;

        if ($request->file('customer_image')) {

            $image = $request->file('customer_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

            Image::make($image)->resize(200, 200)->save('upload/customer/' . $name_gen);
            $save_url = 'upload/customer/' . $name_gen;

            Customer::findOrFail($customer_id)->update([
                'name' => $request->name,
                'mobile_no' => $request->mobile_no,
                'address' => $request->address,
                'email' => $request->email,
                'customer_image' => $save_url,
                'updated_by' => Auth::user()->id,
                'updated_at' => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Customer Updated with image Successfully',
                'alert-type' => 'success',
            );

            return redirect()->route('customer.all')->with($notification);

        } else {
            
            Customer::findOrFail($customer_id)->update([
                'name' => $request->name,
                'mobile_no' => $request->mobile_no,
                'address' => $request->address,
                'email' => $request->email,
                'updated_by' => Auth::user()->id,
                'updated_at' => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Customer Updated Successfully',
                'alert-type' => 'success',
            );

            return redirect()->route('customer.all')->with($notification);

        }

    }// End Method


    public function CustomerDelete($id){

        $customer = Customer::findOrFail($id);
        $img = $customer->customer_image;
        unlink($img);

        Customer::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Customer Deleted Successfully',
            'alert-type' => 'success',
        );

        return redirect()->back()->with($notification);

    } // End Method

}
