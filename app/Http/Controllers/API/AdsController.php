<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Ads;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Leads;

class AdsController extends Controller
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
        $userid = Auth::user()->id;

        if(Auth::user()->role == 6){
            $parentid = User::where('id','=', $userid)->pluck('parent_id');
        } else {
            $parentid = $userid;
        }

        $leads = Ads::where('users.parent_id','=', $parentid)
            ->join('users', 'users.id', '=', 'ads.created_by')
            ->select('ads.id','ads.ads_id','ads.media','ads.budeget', 'ads.ads_type','ads.start_at','ads.end_at')
            ->paginate(5);

        /*$newary = array();
        foreach($leads as $key=>$val){
            $totleads = Leads::where('ads_id','=',$val['id'])->count();
            $date = date('Y-m-d');
            if($val['end_at'] > $date)
                $sts = 'live';
            else
                $sts = 'ended';

            $newary['id'] = $val['id'];
            $newary['ads_id'] = $val['ads_id'];
            $newary['media'] = $val['media'];
            $newary['budeget'] = number_format($val['budeget']);
            $newary['ads_type'] = $val['ads_type'];
            $newary['start_at'] = $val['start_at'];
            $newary['end_at'] = $val['end_at'];
            $newary['leads'] = $totleads;
            $newary['cpl'] = number_format($val['budeget']/$totleads,2) ;
            $newary['status'] = $sts;
        }*/

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
        //validate fields
        $this->validate($request, [
            'media' => 'required',
            'url' => 'required',
            'ads_type' => 'required',
            'budeget' => 'required',
            'start_at' => 'required',
            'end_at' => 'required'
        ]);

        $adid = 'A'.sprintf("%06d", mt_rand(1, 999999));

        return Ads::create([
            'media'=>$request['media'],
            'url'=>$request['url'],
            'ads_type'=>$request['ads_type'],
            'budeget'=>$request['budeget'],
            'start_at'=>date('Y-m-d', strtotime($request['start_at'])),
            'end_at'=>date('Y-m-d', strtotime($request['end_at'])),
            'ads_id'=>$adid,
            'created_by'=>Auth::user()->id,
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

    public function search(){
        if ($search = \Request::get('q')) {
            $users = Ads::where(function($query) use ($search){
                $query->where('media','LIKE',"%$search%")
                        ->orWhere('ads_id','LIKE',"%$search%")
                        ->orWhere('budeget','LIKE',"%$search%");
            })->paginate(5);
        }else{
            $users = Ads::latest()->paginate(5);
        }
        return $users;
    }

    public function getAdsList(){
        return Ads::all();
    }
}
