<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    public function index(Request $request)
    {
        //if request has per_page then ok otherwise set static value 10;
        $paginate_perpage = $request->per_page ? $request->per_page : 10;
        $orderBy = $request->orderBy ? $request->orderBy : 'id';
        $orderByDir = $request->orderByDir ? $request->orderByDir : 'desc';
        return Customer::orderBy($orderBy,$orderByDir)->paginate($paginate_perpage);
    }



    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|max:30',
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


    public function edit(Customer $customer){
        return $customer;
    }

    public function update(Request $request, Customer $customer)
    {
        $this->validate($request,[
            'name' => 'required|max:30',
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

    //for search
    public function search($query_field,$query, Request $request){
        //if request has per_page then ok otherwise set static value 10;
        $paginate_perpage = $request->per_page ? $request->per_page : 10;
        $orderBy = $request->orderBy ? $request->orderBy : 'id';
        $orderByDir = $request->orderByDir ? $request->orderByDir : 'desc';
        return Customer::where($query_field,'LIKE',"%$query%")->orderBy($orderBy,$orderByDir)->paginate($paginate_perpage);
    }
}
