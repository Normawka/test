<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Models\Company;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {

        if(request()->ajax()) {
                     return datatables()->eloquent(Employee::select('employees.*')->with('company'))
                ->addColumn('company', function (Employee $employee){
                    return $employee->company['name'];

                })

                ->addColumn('action', 'company-action')

                ->editColumn('created_at',function (Employee $employee){
                    return $employee->created_at->diffforHumans();
                })

                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);

        }
        return view('employees.index');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        $employeeId = $request->id;

        $employee   =   Employee::updateOrCreate(
            [
                'id' => $employeeId,

            ],
            [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'company_id' => $request->select,
                'email' => $request->email,
                'phone' => $request->phone,
            ])->with('company');

        return Response()->json($employee);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        return view('employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $where = array('id' => $request->id );

        $employee = Employee::where($where)->with('company')->first();

        return Response()->json($employee);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request\EmployeeRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(EmployeeRequest $request, Employee $employee)
    {
        $employee->update($request->validated());
        return redirect()->route('employees.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(EmployeeRequest $request)
    {

        $company = Employee::where('id',$request->id)->delete();

        return Response()->json($company);
    }
}
