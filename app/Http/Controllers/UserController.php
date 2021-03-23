<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Redirect;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $data = User::whereRole('user')->get();
        if ($data){
            if ($request->ajax()) {
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<a href="' . route("users.edit", $row->id) . '" class="edit btn btn-primary btn-sm">Edit</a>';
                        $btn = $btn.'<a href="' . route("users.destroy", $row->id) . '" class="edit btn btn-danger btn-sm">Delete</a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            return view('users.list',compact('data'));
        }
        return redirect(route('home'))->with('error', 'Record not found.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(UserRequest $request)
    {
        try {

            DB::beginTransaction();
            //upload profile pic
            $path = "profiles/default.png";
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'role' => 'user',
                'password' => !empty($request->password) ? bcrypt($request->password) : "",
                'org_password' => !empty($request->password) ? $request->password : "",
                'profile_photo_path' => empty($path) ? 'defaul.png' : $path,
                'phone' => !empty($request->phone) ? $request->phone : "",
                'address' => !empty($request->address) ? $request->address : "",
                'gender' => !empty($request->gendr) ? $request->gendr : "",
            ];
            User::Create($data);
            DB::commit();
            return redirect(route('users.index'))->with('success', 'Record has been updated.');
        } catch ( \Exception $e) {
            DB::rollBack();
            return Redirect::back()->withErrors(['error', 'Sorry Record not inserted.']);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $data = User::find($id);
            if ($data) {
                return view('users.edit',compact('data'));
            } else {
                return Redirect::back()->withErrors(['error', 'Sorry Record not inserted.']);
            }
        } catch ( \Exception $e) {
            DB::rollBack();
            return Redirect::back()->withErrors(['error', 'Sorry Record not inserted.']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required',
        ]);

        if(!empty($request->passord)){
            $validated = $request->validate([
                'password_confirmation' => 'required|same:Password',
            ]);
        }
        try {
            //dd($request);
            DB::beginTransaction();
            $user = User::find($id);
            if ($user){
                $data = [
                    'name' => $request->name,
                    'password' => !empty($request->password) ? bcrypt($request->password) : $user->password,
                    'org_password' => !empty($request->password) ? $request->password : $user->password,
                    'phone' => !empty($request->phone) ? $request->phone : $user->phone,
                    'address' => !empty($request->address) ? $request->address : $user->address,
                    'gender' => !empty($request->gendr) ? $request->gendr : $user->gendr,
                ];

                $user->update($data);
                DB::commit();
                return redirect(route('users.index'))->with('success', 'Record has been updated.');
            }
            return Redirect::back()->withErrors(['error', 'Sorry Record not inserted.']);
        } catch ( \Exception $e) {
            DB::rollBack();
            return Redirect::back()->withErrors(['error', 'Sorry Record not inserted.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $data_exist = User::find($id);
            if ($data_exist) {
                $data_exist->delete();
                return redirect(route('users.index'))->with('success', 'Record has been deleted.');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->withErrors(['error', 'Sorry Record not inserted.']);
        }
    }
}
