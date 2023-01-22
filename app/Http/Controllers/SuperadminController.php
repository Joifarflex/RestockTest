<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SuperadminController extends Controller
{
    public function superadmin(){
        return view('superadmin');
    }

    public function index(Request $request){
        $superadmin = User::all();
        if($request->ajax()){
            return DataTables::of($superadmin)
            ->addIndexColumn()
            ->addColumn('action', function($data) {
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$data->id.'" class="btn btn-primary btn-sm updateAdmin"><i class="fa fa-edit"> Edit </i></a>';
                $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$data->id.'" class="btn btn-danger btn-sm deleteAdmin"> <i class="fa fa-edit"> Delete </i></a>';
                return $btn;

            })
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('superadmin', compact('superadmin'));
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

            $data = new User();
            $data -> username = $request->input('username');
            $data -> email = $request->input('email');
            $data -> role = $request->input('role');
            $data -> password = Hash::make($request->input('password'));
            $data -> save();

            return response()->json(['status' => 200, 'message' => 'data telah ditambahkan']);
        }
    }
    
    public function edit($id)
    {
        $superadmin = User::where('id', $id)->first();

        if($superadmin)
        {
            return response()->json(['status' => 200, 'superadmin' => $superadmin]);
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
        ]);

        if($validator->fails())
        {
            return response()->json(['status' => 400, 'errors' => $validator->errors()]);
        }
        else
        {
            $superadmin = User::find($id);

            if ($superadmin)
            {
                $superadmin -> username = $request->input('username');
                $superadmin -> email = $request->input('email');
                $superadmin -> update();

                return response()->json(['status' => 200, 'messages' => 'data telah diperbaharui']);
            }
            else
            {
                return response()->json(['status' => 404, 'messages' => 'Ada kesalahan dalam penyimpanan']);
            }
        }
    }

    public function destroy($id)
    {
        User::find($id)->delete();
      
        return Response()->json(['success'=>'data deleted successfully.']);
    }
}
