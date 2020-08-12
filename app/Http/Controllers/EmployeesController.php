<?php

namespace App\Http\Controllers;

use DB;
use App\Employee;
use Illuminate\Http\Request;
use App\Http\Requests;
// use Illuminate\Http\File;


use Illuminate\Support\Facades\Storage;
use App\Http\Requests\EmployeesRequest;
use Illuminate\Support\Facades\Hash;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
        // $this->middleware('auth:admin')->except(['getData', 'index', 'show']);
    }

    public function index()
    {
        return view('index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $employee = Employee::limit(20)->get();
        $employee = Employee::oldest('name')->get();

        return response()->json($employee);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeesRequest $request)
    {
        $employee = new Employee;

        $employee->userId = Employee::generateEmployeeNumber();
        $employee->name =  ucwords($request->name);
        $employee->email = $request->email;
        $employee->phone_number = $request->phone_number;
        $employee->idNumber = $request->idNumber;
        $employee->dateOfBirth = $request->dateOfBirth;
        $employee->active = $request->active;
        $employee->roles = $request->roles;
        $employee->gender = $request->gender;
        $employee->password = Hash::make(Employee::generateEmployeePassword());
        $employee->created_by = auth()->id();
        $employee->updated_by = auth()->id();

        //TODO ===== prevent storing images if data was not entered in database
        $employee->save();

        return response()->json(['success' => "User added successfully.", 'addedUser' => $employee]);

        return response()->json(['errors' => "Failed to add user..Try again!!!!"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show($employee)
    {

        // return view('index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeesRequest $request)
    {
        $employee = Employee::findOrFail($request->id);

        // $employee->userId = Employee::generateEmployeeNumber();
        $employee->name =  ucwords($request->name);
        $employee->email = $request->email;
        $employee->phone_number = $request->phone_number;
        $employee->idNumber = $request->idNumber;
        $employee->dateOfBirth = $request->dateOfBirth;
        $employee->active = $request->active;
        $employee->roles = $request->roles;
        $employee->gender = $request->gender;
        // $employee->password = Hash::make(Employee::generateEmployeePassword());
        // $employee->created_by = auth()->id();
        $employee->updated_by = auth()->id();

        //TODO ===== prevent storing images if data was not entered in database
        $employee->save();

        return response()->json(['success' => "User updated successfully.", 'updatedUser' => $employee]);

        return response()->json(['errors' => "Failed to update..Try again!!!!"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    /* Request $request */
    public function destroy($user)
    {
        // return "hee";
        $execute = Employee::destroy(explode(",", $user));

        if ($execute) {
            return response()->json(['success' => "Deleted successfully!!!!!"]);
        }

        return response()->json(['error' => "Error!!! Failed to delete try again"]);
        // $request = Product::destroy(collect($request));

        // if ($request) {
        //     return response()->json(['success' => "Deleted successfully!!!!!"]);
        // }

        // return response()->json(['error' => "Error!!! Failed to delete try again"]);
    }
}