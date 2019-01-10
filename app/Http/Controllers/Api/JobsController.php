<?php

namespace App\Http\Controllers\Api;

use App\Models\FitterRates;
use App\Models\Job;
use App\Models\Sales;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class JobsController extends Controller
{
    public $successStatus = 200;

    public function index(Request $request)
    {
        return $sales = Job::orderBy("created_at", "desc")->paginate(10);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $record = new Job();
        foreach ($record->getFillable() as $fillable) {
            if (!empty($input[$fillable]))
                $record->{$fillable} = $input[$fillable];
        }
        if ($record->save()) {
            return response()->json(['success' => 'user stored successfully.', 'sales' => $record], $this->successStatus);
        }
        return response()->json(['error' => 'something went wrong!'], 401);
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $record = Job::find($id);
        if ($record) {
            foreach ($record->getFillable() as $fillable) {
                if (!empty($input[$fillable]))
                    $record->{$fillable} = $input[$fillable];
            }
            if ($record->save()) {
                return response()->json(['success' => 'user stored successfully.', 'sales' => $record], $this->successStatus);
            }
        }
        return response()->json(['error' => 'something went wrong!'], 401);
    }


    public function destroy($id)
    {
        $record = Job::find($id);
        if ($record) {
            if ($record->delete())
                return response()->json(['success' => 'user deleted successfully.'], $this->successStatus);
        }
        return response()->json(['error' => 'user not found.'], 401);
    }

    public function getRatePrice(Request $request)
    {
            $job_type = FitterRates::where('fitter_user_id', $request->fitter_id)->where('rate_name_id', $request->job_type)->get();
        //return response()->json([$job_type]);
        if (!empty($job_type)) {
            $sale_sheet = Sales::where('id', $request->sale_sheet_id)->first();
            $price = 0;
            $number = $sale_sheet->net_m2;
            foreach ($job_type as $j) {
                if ($j->is_condition) {
                    if (!empty($j->condition_2_operator)) {
                        if ($j->condition_1_operator == "=") {
                            if ($number == $j->condition_1_value  && $this->checks($j->condition_2_operator, $number, $j->condition_2_value)) {
                                $price = $number * $j->rate_price;
                                break;
                            }
                        } elseif ($j->condition_1_operator == ">") {
                         
                            if ($number > $j->condition_1_value  && $this->checks($j->condition_2_operator, $number, $j->condition_2_value)) {
                                $price = $number * $j->rate_price;
                                break;
                            }
                        } elseif ($j->condition_1_operator == "<" ) {
                            if ($number < $j->condition_1_value && $this->checks($j->condition_2_operator, $number, $j->condition_2_value)) {
                                $price = $number * $j->rate_price;
                                break;
                            }
                        }
                        elseif ($j->condition_1_operator == "<=" ) {
                           //return response(['dsadasd']);
                            if ($number <= $j->condition_1_value && $this->checks($j->condition_2_operator, $number, $j->condition_2_value)) {
                                $price = $number * $j->rate_price;
                                break;
                            }
                        }
                        elseif ($j->condition_1_operator == ">=" ) {
                           // return response(['dsadasd']);
                            if ($number >= $j->condition_1_value && $this->checks($j->condition_2_operator, $number, $j->condition_2_value)) {
                                $price = $number * $j->rate_price;
                                break;
                            }
                        }
                        
                    }
                    else{
                        if ($j->condition_1_operator == "=") {
                        if ($number == $j->condition_1_value) {
                            $price = $number * $j->rate_price;
                            break;
                        }
                    } elseif ($j->condition_1_operator == ">") {
                        if ($number > $j->condition_1_value) {
                            $price = $number * $j->rate_price;
                            break;
                        }
                    } elseif ($j->condition_1_operator == "<") {
                    //    return response(['dsadasd']);
                        if ($number < $j->condition_1_value) {
                            $price = $number * $j->rate_price;
                            break;
                        }
                    }

                    elseif ($j->condition_1_operator == "<=") {
                    //    return response(['dsadasd']);
                        if ($number <= $j->condition_1_value) {
                            $price = $number * $j->rate_price;
                            break;
                        }
                    }

                    elseif ($j->condition_1_operator == ">=") {
                    //    return response(['dsadasd']);
                        if ($number >= $j->condition_1_value) {
                            $price = $number * $j->rate_price;
                            break;
                        }
                    }
                    }
                } else {
                    $price = $number * $j->rate_price;
                    break;
                }
            }
            return response()->json(['success' => true, 'price' => $price]);
        } else
            return response()->json(['success' => false, 'error' => 'rate not found for this fitter.'], 401);
    }

    public function checks($op, $number, $value)
    {

        if ($op == "=" && $number == $value)
            return true;

        if ($op == ">" && $number > $value)
            return true;


        if ($op == "<" && $number < $value)
            return true;


        if ($op == "<=" && $number <= $value)
            return true;


        if ($op == ">=" && $number >= $value)
            return true;

            return false;
    }


}
