<?php

namespace App\Http\Controllers\Api;

use App\Models\FitterRates;
use App\Models\Fitter;
use App\Models\FitterRatesSite;
use App\Models\RateName;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FitterRatesController extends Controller
{
    public $successStatus = 200;

//    private $fitters;

    public function index(Request $request)
    {

        //      $user_id =  Auth::user()->id;
        //     $records = FitterRates::orderBy("id")->where('fitter_user_id', $user_id)->get();
//  $user_id =  $request->user_id;
// $records = FitterRates::orderBy("id")->where('fitter_user_id', $user_id)->get();
//
//        return $records;
        $prices = Fitter::all()->each->fitter_rate;
        return response()->json(['prices'=>$prices]);

    }


    public function show($id)
    {


        $record = FitterRates::whereId($id)->first();
        if ($record) {
            return response()->json(['success' => true, 'record' => $record], $this->successStatus);
        }
        return response()->json(['error' => 'something went wrong!'], 401);

    }


    public function store(Request $request)
    {
        $this->validate($request,['type'=>'required','fitter_id'=>'required|integer']);
        $record = FitterRates::create($request->all());
        if($record)
            return response()->json(['success' => 'Fitter Rates successfully.', 'Fitter Rates' => $record], $this->successStatus);
        else
        return response()->json(['error' => 'something went wrong!'], 401);
    }


    public function update(Request $request, $id)
    {
        $record = FitterRates::find($id)->update($request->all());

        if ($record) {
            return response()->json(['success' => 'rate name updated successfully.', 'job' => $record], $this->successStatus);
        }
        return response()->json(['error' => 'something went wrong!'], 401);
    }


    public function destroy($id)
    {
        $record = FitterRates::find($id);
        if ($record) {
            if ($record->delete())
                return response()->json(['success' => 'deleted successfully.'], $this->successStatus);
        }
        return response()->json(['error' => 'Root Name not found.'], 401);
    }


}
