<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Ads;

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
        return Ads::latest()->paginate(5);
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
            'ads_id'=>$adid
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
