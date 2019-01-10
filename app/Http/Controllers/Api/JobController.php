<?php

namespace App\Http\Controllers\Api;

use App\Models\Developer;
use App\Models\Job;
use App\Models\JobSales;
use App\Models\Site;
use App\Models\Timeline;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    public $successStatus = 200;

    public function index(Request $request)
    {
        return $sales = Job::with("assigned")->with("createdBy")->orderBy("created_at", "desc")->get();
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $input['creator'] = Auth::id();
        $record = new Job();
        foreach ($record->getFillable() as $fillable) {
            if (!empty($input[$fillable]))
                $record->{$fillable} = $input[$fillable];
        }
        if ($record->save()) {
            if (!empty($input['sales_id'])) {
                $sales = $input['sales_id'];
                $jobSales = new JobSales();
                $jobSales->sales_id = $input['sales_id'];
                $jobSales->job_id = $record->id;
                $jobSales->save();
                Timeline::create(['date' => $jobSales->created_at, 'title' => 'Job ' . $input['title'] . ' Added', 'type' => 'job', 'sales_id' => $input['sales_id']]);
            }
            $record->assigned = $record->assigned;
            $record->createdBy = $record->createdBy;
            $name = $record->assigned ? $record->assigned->name : '';
            Timeline::create(['date' => $record->created_at, 'title' => 'Fitter ' . $name . ' assigned', 'type' => 'fitter', 'sales_id' => $input['sales_id']]);


            return response()->json(['success' => 'job created successfully.', 'job' => $record], $this->successStatus);
        }
        return response()->json(['error' => 'something went wrong!'], 401);
    }

    public function show($id)
    {
        $sites = Site::all()->keyBy('id');
        $developers = Developer::all()->keyBy('id');
        $record = Job::with('sales')->whereId($id)->first();
        if ($record) {
            $record->assignedTo = $record->assigned;
            $record->createdBy = $record->createdBy;
            foreach ($record->sales as $sale) {
                $sale->site = isset($sites[$sale->site]) ? $sites[$sale->site]->name : $sale->site;
                $sale->developer = isset($developers[$sale->developer]) ? $developers[$sale->developer]->name : $sale->developer;
            }
            $record->date = date('Y-m-d', strtotime($record->date));
            return response()->json(['success' => true, 'job' => $record], $this->successStatus);
        }
        return response()->json(['error' => 'something went wrong!'], 401);
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $input['creator'] = Auth::id();
        $record = Job::find($id);
        foreach ($record->getFillable() as $fillable) {
            if (!empty($input[$fillable]))
                $record->{$fillable} = $input[$fillable];
        }

        if ($record->save()) {
            if (!empty($input['sales_id'])) {
                $sales = $input['sales_id'];
                if (is_array($sales))
                    foreach ($sales as $sale) {
                        JobSales::create(['sales_id' => $sale, 'job_id' => $record->id]);
                    }
                else {
                    $jobSales = new JobSales();
                    $jobSales->sales_id = $input['sales_id'];
                    $jobSales->job_id = $record->id;
                    $jobSales->save();
                }
                $record->assignedTo = $record->assignedTo;
                $record->createdBy = $record->createdBy;
                $name = $record->assigned ? $record->assigned->name : '';
                Timeline::create(['date' => $record->created_at, 'title' => 'Fitter ' . $name . ' assigned', 'type' => 'fitter', 'sales_id' => $input['sales_id']]);
            }

            return response()->json(['success' => 'job created successfully.', 'job' => $record], $this->successStatus);
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
