<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Leads;

class LeadsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Leads::latest()->paginate(5);
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
            'name' => 'required|string|max:191',
            'email' => 'required|string|max:191',
            'mobile' => 'required|string|max:191',
            'ads_id' => 'required',
        ]);

         return Leads::create([
            'name'=>$request['name'],
            'email'=>$request['email'],
            'mobile'=>$request['mobile'],
            'ads_id'=>$request['ads_id'],
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
        $lead = Leads::findOrFail($id);

        $this->validate($request, [
            //'username' => 'required|string|max:191|unique:users,username,'.$user->username,
            'name' => 'required|string|max:191',
            'email' => 'email|string|required|max:191|unique:users,email,'.$lead->id,
            'mobile' => 'required',
            'password'=>'sometimes|min:6'
        ]);

        $lead->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lead = Leads::findOrFail($id);
        $lead->delete();
    }

    public function search(){
        if ($search = \Request::get('q')) {
            $leads = Leads::where(function($query) use ($search){
                $query->where('name','LIKE',"%$search%")
                        ->orWhere('email','LIKE',"%$search%")
                        ->orWhere('mobile','LIKE',"%$search%");
            })->paginate(5);
        }else{
            $leads = Leads::latest()->paginate(5);
        }
        return $leads;
    }

}
