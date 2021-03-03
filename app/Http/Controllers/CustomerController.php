<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    public function index()
    {
        return Customer::all();
    }


    public function create()
    {
        return view('backend.customers.create');
    }


    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|max:30|unique:customers',
            'email' => 'required|email|unique:customers',
            'phone' => 'required|unique:customers',
        ]);

        $customer = new Customer;
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->save();
        return $customer;
    }


    public function show(Customer $customer)
    {
        //
    }


    public function edit($id)
    {
        return Customer::findOrFail($id);
    }


    public function update(Request $request, Customer $customer)
    {
        $this->validate($request,[
            'name' => 'required|max:30|unique:customers,name,'.$customer->id,
            'email' => 'required|email|unique:customers,email,'.$customer->id,
            'phone' => 'required|unique:customers,phone,'.$customer->id,
        ]);

        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->save();
        return $customer;
    }


    public function destroy(Customer $customer)
    {
        //
    }
}
