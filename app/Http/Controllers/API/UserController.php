<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
        //$this->authorize('isClientAdmin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::latest()->paginate(5);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate fields
        $this->validate($request, [
            'username' => 'required|string|unique:users|max:191',
            'name' => 'required|string|max:191',
            'email' => 'email|string|required|unique:users|max:191',
            'role' => 'required',
            'mobile' => 'required',
            'parent_id' => 'required'
        ]);

         return User::create([
            'name'=>$request['name'],
            'email'=>$request['email'],
            'mobile'=>$request['mobile'],
            'username'=>$request['username'],
            'password'=> Hash::make($request['password']),
            'role'=>$request['role'],
            'parent_id'=>$request['parent_id'],
         ]);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $this->validate($request, [
            //'username' => 'required|string|max:191|unique:users,username,'.$user->username,
            'name' => 'required|string|max:191',
            'email' => 'email|string|required|max:191|unique:users,email,'.$user->id,
            'mobile' => 'required',
            'password'=>'sometimes|min:6'
        ]);

        $user->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return ['message'=>'user deleted'];
    }

    public function profile()
    {
        return auth('api')->user();
    }

    public function updateProfile(Request $request){
        $user = auth('api')->user();

        $this->validate($request, [
            //'username' => 'required|string|max:191|unique:users,username,'.$user->username,
            'name' => 'required|string|max:191',
            'email' => 'email|string|required|max:191|unique:users,email,'.$user->id,
            'mobile' => 'required',
            'password'=>'sometimes|min:6'
        ]);

        if(!empty($request['password'])){
            $request->merge(['password'=>Hash::make($request['password'])]);
        }

        $user->update($request->all());

        return ['message'=>'user get'];
    }

    public function search(){
        if ($search = \Request::get('q')) {
            $users = User::where(function($query) use ($search){
                $query->where('name','LIKE',"%$search%")
                        ->orWhere('email','LIKE',"%$search%")
                        ->orWhere('mobile','LIKE',"%$search%");
            })->paginate(5);
        }else{
            $users = User::latest()->paginate(5);
        }
        return $users;
    }

    public function GetparentUserList(){
        $pid = \Request::get('pid');
        $users = '';
        if ($pid) {
            if($pid == 4){
                $role_id = 3;
            } else if($pid == 6){
                $role_id = 5;
            }
            $users = User::where('role','=', $role_id)->get();
        }
        return $users;
    }
}
