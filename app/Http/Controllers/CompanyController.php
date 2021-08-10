<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Mail\MyMail;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use \Illuminate\Support\Facades\File;
use Intervention\Image\Image;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Mail;


class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function index(Request $request)
    {

        if (request()->ajax()) {
            return DataTables()->of(Company::select('*'))
                ->addColumn('action', 'company-action')
                ->addColumn('logo', 'logo')
                ->editColumn('created_at',function (Company $company){
                    return $company->created_at->diffforHumans();
                })
                ->rawColumns(['action', 'logo'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('company.index');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        request()->validate([
            'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $companyId = $request->id;

        $details = [
            'name' => $request->name,
            'email' => $request->email,
            'website' => $request->website,
        ];
        if ($logo = $request->file('logo')) {
            File::delete('img/' . $request->hidden_image);
            $destinationPath = 'img/'; // upload path
            $profileImage = date('YmdHis') . "." . $logo->getClientOriginalExtension();
            $logo->move($destinationPath, $profileImage);
            $details['logo'] = "$profileImage";
        }
        if (isset($companyId)){
        }else{
            $data=[
                'name' => $request->get('name'),
                'email' => $request->get('email'),
            ];
            $email = '0967620cc7-22016f@inbox.mailtrap.io';
            Mail::to($email)->send(new MyMail($data));
        }
        $company = Company::updateOrCreate([
            'id' => $companyId
        ], $details);
        return Response()->json($company);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Request $request)
    {
        $where = array('id' => $request->id);
        $company = Company::where($where)->first();

        return Response()->json($company);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector|string
     */
    public function destroy(Request $request)
    {
        $data = Company::where('id', $request->id)->first(['logo']);
        File::delete('img/' . $data->logo);
        $company = Company::where('id', $request->id)->delete();

        return Response()->json($company);
    }
}
