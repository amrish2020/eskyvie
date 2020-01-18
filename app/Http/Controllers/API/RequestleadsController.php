<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Requestleads;
use App\Leads;

use Illuminate\Support\Facades\Auth;

class RequestleadsController extends Controller
{
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
        $userid = Auth::user()->id;
        $leads = Requestleads::where('users.parent_id','=', $userid)
            ->join('users', 'users.parent_id', '=', 'requestleads.request_by')
            ->select('requestleads.id','requestleads.req_lead', 'requestleads.status', 'requestleads.created_at', 'users.name', 'users.staff_id')
            ->paginate(5);
        return json_encode($leads);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'staff_id' => 'required',
        ]);

        $staff_id = $request->staff_id;

        $leads_id = Leads::where('status','=', 'unassign')->select('id')->orderBy('id', 'desc')->pluck('id')->first();

        $open_leads = Leads::where('status','=', 'open')->where('assign_to','=', $staff_id)->count();

        if($open_leads == 0){
            $ary = array(
                'assign_to' => $staff_id,
                'assign_by' => Auth::user()->id,
                'assign_date' => date('Y-m-d h:i:s'),
                'status' => 'open',
            );
            $affectedRows = Leads::where('id', '=', $leads_id)->update($ary);
            return ['msg' => $affectedRows];
        } else {
            return ['msg' => 'fail'];
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function postRequestForLeads(Request $request){
        $ary = array(
            'req_lead' => $request->req_lead,
            'request_by' => Auth::user()->id,
            'status' => 'open',
            'created_at'=> date('Y-m-d h:i:s'),
            'updated_at' => date('Y-m-d h:i:s')
        );
        $affectedRows = Requestleads::insert($ary);
        return ['msg' => $affectedRows];
    }
}
