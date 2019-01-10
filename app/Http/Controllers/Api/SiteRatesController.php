<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SiteRates;
use App\Models\DeveloperSite;
use App\Models\CompanyRates;
use Illuminate\Http\Request;

class SiteRatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prices = DeveloperSite::all()->each->rates;

        return response()->json(['prices'=>$prices]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sites = DeveloperSite::all();
        $json_rates = CompanyRates::all();
        return response()->json(['sites' => $sites, 'prices' => $json_rates]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,['site_id'=>'required|integer','type'=>'required']);
       $siteRate =  SiteRates::create($request->all());
       return response()->json(['success'=>true,'siteRate'=>$siteRate],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SiteRates $siteRates
     * @return \Illuminate\Http\Response
     */
   public function show($id)
    {


         $record = SiteRates::whereId($id)->first();
        if ($record) {
            return response()->json(['success' => true, 'record' => $record]);
        }
        return response()->json(['error' => 'something went wrong!'], 401);
       
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SiteRates $siteRates
     * @return \Illuminate\Http\Response
     */
    public function edit(SiteRates $siteRates)
    {
        $sites = DeveloperSite::all();
        $json_rates = CompanyRates::all();
        return response()->json(['SiteRate'=>$siteRates,'sites' => $sites, 'prices' => $json_rates]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\SiteRates $siteRates
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $siteRates)
    {
        //$this->validate($request,[]);
             //   return response()->json(['success'=>$request->all(),$siteRates],200);

        $siteRate =SiteRates::find($siteRates)->update($request->all()) ;
        return response()->json(['success'=>true,'siteRate'=>SiteRates::find($siteRates)],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SiteRates $siteRates
     * @return \Illuminate\Http\Response
     */
    public function destroy( $siteRates)
    {
        //
        if(SiteRates::find($siteRates)->delete()){
            return response()->json(['success'=>true],200);
        }
        return response()->json(['success'=>false],401);
    }

    public function getSiteName($site_id){
        $site = DeveloperSite::find($site_id);
        return response()->json(['site'=>$site]);
    }
}
