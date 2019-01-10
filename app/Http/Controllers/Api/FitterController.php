<?php

namespace App\Http\Controllers\Api;

use App\Models\Fitter;
use App\Models\FitterDates;
use App\Models\Job;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class FitterController extends Controller
{
    public $successStatus = 200;

    public function index(Request $request)
    {
        $date = $request->input('date');
        $fitters = Fitter::with("dates")->orderBy("created_at", "desc");
        if (!empty($date)) {
            $date = date('Y-m-d', strtotime($date));
            $ftrs = FitterDates::where('date', $date)->pluck('fitter_id')->toArray();
            $fitters = $fitters->whereNotIn('id', $ftrs);
        }
        return $fitters->get();
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $record = new Fitter();
        foreach ($record->getFillable() as $fillable) {
            if (!empty($input[$fillable]))
                $record->{$fillable} = $input[$fillable];
        }
        if ($record->save()) {
            if (!empty($input['events'])) {
                foreach ($input['events'] as $date) {
                    FitterDates::create(['fitter_id' => $record->id, 'date' => date('Y-m-d', strtotime($date['start']))]);
                }
            }
            return response()->json(['success' => 'job created successfully.', 'job' => $record], $this->successStatus);
        }
        return response()->json(['error' => 'something went wrong!'], 401);
    }

    public function show($id)
    {
        $record = Fitter::with('dates')->whereId($id)->first();
        if ($record) {
            return response()->json(['success' => true, 'record' => $record], $this->successStatus);
        }
        return response()->json(['error' => 'something went wrong!'], 401);
    }

    public function jobs($id)
    {
        $jobs = Job::where('assigned_to', $id)->get();
        if ($jobs) {
            return response()->json(['success' => true, 'records' => $jobs], $this->successStatus);
        }
        return response()->json(['error' => 'something went wrong!'], 401);
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $record = Fitter::find($id);
        if ($record) {
            foreach ($record->getFillable() as $fillable) {
                if (!empty($input[$fillable]))
                    $record->{$fillable} = $input[$fillable];
            }
            if ($record->save()) {
                FitterDates::where('fitter_id', $record->id)->delete();
                if (!empty($input['events'])) {
                    foreach ($input['events'] as $date) {
                        FitterDates::create(['fitter_id' => $record->id, 'date' => date('Y-m-d', strtotime($date['start'] . ' +1 day'))]);
                    }
                }
                return response()->json(['success' => 'Created successfully.', 'job' => $record], $this->successStatus);
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

}
