<?php

namespace App\Http\Controllers\Api;

use App\Models\Developer;
use App\Models\Site;
use App\Models\Timeline;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Sales;

class SalesSheetController extends Controller
{
    public $successStatus = 200;
    private $sites;
    private $developers;

    public function __construct()
    {
        $this->sites = Site::all()->keyBy('id');
        $this->developers = Developer::all()->keyBy('id');
    }

    public function index(Request $request)
    {
        $records = Sales::orderBy("created_at", "desc")->get();
        foreach ($records as $record) {
            $record->site = isset($this->sites[$record->site]) ? $this->sites[$record->site]->name : $record->site;
            $record->developer = isset($this->developers[$record->developer]) ? $this->developers[$record->developer]->name : $record->developer;
        }
        return $records;
    }

    public function show($id)
    {
        $record = Sales::with('timeline')->whereId($id)->first();
        if ($record) {
            return response()->json(['success' => true, 'record' => $record], $this->successStatus);
        }
        return response()->json(['error' => 'something went wrong!'], 401);
        //return $sale = Sales::whereID($id)->first();
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $record = new Sales();
        foreach ($record->getFillable() as $fillable) {
            if (!empty($input[$fillable]))
                $record->{$fillable} = $input[$fillable];
        }

        if ($record->save()) {
            Timeline::create(['date' => $record->created_at, 'title' => 'New sheet has created', 'type' => 'sheet', 'sales_id' => $record->id]);
            return response()->json(['success' => 'user stored successfully.', 'sales' => $record], $this->successStatus);
        }
        return response()->json(['error' => 'something went wrong!'], 401);
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $record = Sales::find($id);
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
        $record = Sales::find($id);
        if ($record) {
            if ($record->delete())
                return response()->json(['success' => 'user deleted successfully.'], $this->successStatus);
        }
        return response()->json(['error' => 'user not found.'], 401);
    }


}
