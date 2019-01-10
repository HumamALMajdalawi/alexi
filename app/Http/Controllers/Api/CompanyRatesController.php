<?php

namespace App\Http\Controllers\Api;

use App\Models\CompanyRates;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CompanyRatesController extends Controller
{
    public $successStatus = 200;

    public function index()
    {
    
    $prices = CompanyRates::all();
    return response()->json($prices);


    }


 public function show($id)
    {


         $record = CompanyRates::whereId($id)->first();
        if ($record) {
            return response()->json(['success' => true, 'record' => $record], $this->successStatus);
        }
        return response()->json(['error' => 'something went wrong!'], 401);
       
    }


     public function store(Request $request)
    {
       
       $input = $request->all();
        $record = new CompanyRates();
        foreach ($record->getFillable() as $fillable) {
            if (!empty($input[$fillable]))
                $record->{$fillable} = $input[$fillable];
        }
        if ($record->save()) {
          
            return response()->json(['success' => 'Company rates created successfully.', 'rate_name' => $record], $this->successStatus);
        }
        return response()->json(['error' => 'something went wrong!'], 401);
    }

    
     public function update(Request $request, $id)
    {
        $input = $request->all();
        $record = CompanyRates::find($id);
        foreach ($record->getFillable() as $fillable) {
            if (!empty($input[$fillable]))
                $record->{$fillable} = $input[$fillable];
        }
        if ($record->save()) {
           
           
            return response()->json(['success' => 'Company rates updated successfully.', 'job' => $record], $this->successStatus);
        }
        return response()->json(['error' => 'something went wrong!'], 401);
    }


     public function destroy($id)
    {
        $record = CompanyRates::find($id);
        if ($record) {
            if ($record->delete())
                return response()->json(['success' => 'deleted successfully.'], $this->successStatus);
        }
        return response()->json(['error' => 'Root Name not found.'], 401);
    }
   


}
