<?php

namespace App\Http\Controllers\Api;

use App\Models\Developer;
use App\Models\DeveloperSite;
use App\Models\Job;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DeveloperController extends Controller
{
    public $successStatus = 200;

    public function index(Request $request)
    {
        return $developers = Developer::with("sites")->orderBy("created_at", "desc")->get();
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $record = new Developer();
        foreach ($record->getFillable() as $fillable) {
            if (!empty($input[$fillable]))
                $record->{$fillable} = $input[$fillable];
        }
        if ($record->save()) {
            if (!empty($input['sites'])) {
                foreach ($input['sites'] as $site) {
                    DeveloperSite::create(['developer_id' => $record->id, 'site_name' => $site['name']]);
                }
            }
            return response()->json(['success' => 'job created successfully.', 'job' => $record], $this->successStatus);
        }
        return response()->json(['error' => 'something went wrong!'], 401);
    }

    public function show($id)
    {
        $record = Developer::with('sites')->whereId($id)->first();
        if ($record) {
            $record->date = date('Y-m-d', strtotime($record->date));
            return response()->json(['success' => true, 'record' => $record], $this->successStatus);
        }
        return response()->json(['error' => 'something went wrong!'], 401);
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $record = Developer::find($id);
        foreach ($record->getFillable() as $fillable) {
            if (!empty($input[$fillable]))
                $record->{$fillable} = $input[$fillable];
        }
        if ($record->save()) {
            DeveloperSite::where('developer_id', $id)->delete();
            if (!empty($input['sites'])) {
                foreach ($input['sites'] as $site) {
                    DeveloperSite::create(['developer_id' => $record->id, 'site_name' => $site['site_name']]);
                }
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

    public function site(Request $request, $id)
    {
        $input = $request->input();
        $record = Developer::find($id);
        if ($input && $record) {
            $site = DeveloperSite::create(['developer_id' => $id, 'site_name' => $input['site_name']]);
            return response()->json(['success' => true, 'site' => $site], $this->successStatus);
        }
        return response()->json(['success' => false], 401);
    }

    public function deleteSite($id)
    {
        $record = DeveloperSite::find($id);
        if ($record) {
            if ($record->delete())
                return response()->json(['success' => 'deleted successfully.'], $this->successStatus);
        }
        return response()->json(['error' => 'user not found.'], 401);
    }

    public function updateSite(Request $request, $id)
    {
        $record = DeveloperSite::find($id);
        if ($record) {
            $record->site_name = $request->input('site_name');
            if ($record->save())
                return response()->json(['success' => true, 'site' => $record], $this->successStatus);
        }
        return response()->json(['error' => 'user not found.'], 401);
    }
}
