<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class OperasionalController extends Controller
{
    public function operasional(){
        return view('operasional');
    }

    public function index(Request $request){
        $operasional = User::where('role', '!=', 'SUPERADMIN')->get();
        if($request->ajax()){
            return DataTables::of($operasional)
            ->addIndexColumn()
            ->addColumn('action', function($data) {
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$data->id.'" class="btn btn-primary btn-sm updateUser"><i class="fa fa-edit"> Edit </i></a>';
                $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$data->id.'" class="btn btn-danger btn-sm deleteAdmin"> <i class="fa fa-edit"> Delete </i></a>';
                return $btn;

            })
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('operasional', compact('operasional'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'email' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['status'=>400, 'errors'=>$validator->errors()]);
        }
        else{

            if(request()->hasfile('image')){
                $imageName = time().'.'.request()->image->getClientOriginalExtension();
                request()->image->move(public_path('storage'), $imageName);
            }

            $data = new User();
            $data -> username = $request->input('username');
            $data -> email = $request->input('email');
            $data -> role = "USER";
            $data -> password = Hash::make($request->input('password'));
            $data -> image = $imageName ?? NULL;
            $data -> save();

            return response()->json(['status' => 200, 'message' => 'user telah ditambahkan']);
        }
    }
    
    public function edit($id)
    {
        $operasional = User::where('id', $id)->first();

        if($operasional)
        {
            return response()->json(['status' => 200, 'operasional' => $operasional]);
        }
        else
        {
            return response()->json(['status' => 404, 'messages' => 'Tidak ada data ditemukan']);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'email' => 'required',
        ]);

        if($validator->fails())
        {
            return response()->json(['status' => 400, 'errors' => $validator->errors()]);
        }
        else
        {
            $operasional = User::find($id);

            if ($operasional)
            {
                if(request()->hasfile('image')){
                    $imageName = time().'.'.request()->image->getClientOriginalExtension();
                    request()->image->move(public_path('storage'), $imageName);
                }
                
                $operasional -> username = $request->input('username');
                $operasional -> email = $request->input('email');
                $operasional -> image = $imageName ?? NULL;
                $operasional -> update();

                return response()->json(['status' => 200, 'messages' => 'User telah diperbaharui']);
            }
            else
            {
                return response()->json(['status' => 404, 'messages' => 'Ada kesalahan dalam penyimpanan']);
            }
        }
    }
}
