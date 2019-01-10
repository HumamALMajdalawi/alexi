<?php

namespace App\Http\Controllers\Api;

use App\Models\RateName;
use App\Models\RateNameSite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RateNameController extends Controller
{
    public $successStatus = 200;

    public function index()
    {
    
   
      $records = RateName::orderBy("id")->get();
        
        return $records;

    }


 public function show($id)
    {


         $record = RateName::whereId($id)->first();
        if ($record) {
            return response()->json(['success' => true, 'record' => $record], $this->successStatus);
        }
        return response()->json(['error' => 'something went wrong!'], 401);
       
    }


     public function store(Request $request)
    {
       
       $input = $request->all();
        $record = new RateName();
        foreach ($record->getFillable() as $fillable) {
            if (!empty($input[$fillable]))
                $record->{$fillable} = $input[$fillable];
        }
        if ($record->save()) {
          
            return response()->json(['success' => 'Rate Name created successfully.', 'rate_name' => $record], $this->successStatus);
        }
        return response()->json(['error' => 'something went wrong!'], 401);
    }

    
     public function update(Request $request, $id)
    {
        $input = $request->all();
        $record = RateName::find($id);
        foreach ($record->getFillable() as $fillable) {
            if (!empty($input[$fillable]))
                $record->{$fillable} = $input[$fillable];
        }
        if ($record->save()) {
           
           
            return response()->json(['success' => 'rate name updated successfully.', 'job' => $record], $this->successStatus);
        }
        return response()->json(['error' => 'something went wrong!'], 401);
    }


     public function destroy($id)
    {
        $record = RateName::find($id);
        if ($record) {
            if ($record->delete())
                return response()->json(['success' => 'deleted successfully.'], $this->successStatus);
        }
        return response()->json(['error' => 'Root Name not found.'], 401);
    }
   


}
