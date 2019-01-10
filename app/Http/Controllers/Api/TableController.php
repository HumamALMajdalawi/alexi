<?php

namespace App\Http\Controllers\Api;

use App\Models\DeveloperSite;
use App\Models\Timeline;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TableController extends Controller
{
    public $successStatus = 200;
    private $tableInput = '_table';
    private $per_page = 15;

    public function all(Request $request)
    {
        $table = $request->input($this->tableInput);
        if ($table) {
            if (Schema::hasTable($table)) {
                $records = DB::table($table)->get();
                if ($records) {
                    return response()->json(['success' => 'records fetched successfully.', 'table' => $table, 'records' => $records], $this->successStatus);
                }
            }
        }
        return response()->json(['error' => 'something went wrong!'], 401);
    }

    public function show(Request $request, $id)
    {
        $table = $request->input($this->tableInput);
        if ($table) {
            if (Schema::hasTable($table)) {
                $record = DB::table($table)->whereId($id)->first();
                if ($record) {
                    return response()->json(['success' => 'records fetched successfully.', 'table' => $table, 'record' => $record], $this->successStatus);
                }
            }
        }
        return response()->json(['error' => 'something went wrong!'], 401);
    }

    public function index(Request $request)
    {
        $table = $request->input($this->tableInput);
        if ($table) {
            if (Schema::hasTable($table)) {
                $records = DB::table($table)->paginate($this->per_page);
                if ($records) {
                    return response()->json(['success' => 'records fetched successfully.', 'table' => $table, 'records' => $records], $this->successStatus);
                }
            }
        }
        return response()->json(['error' => 'something went wrong!'], 401);
    }

    public function store(Request $request)
    {
        $table = $request->input($this->tableInput);
        $inputs = $request->input();
        if ($table) {
            if (Schema::hasTable($table)) {
                $columns = Schema::getColumnListing($table);
                if ($columns) {
                    if ($table == 'sales' && !empty($inputs['all']) && is_array($inputs['all'])) {
                        foreach ($inputs['all'][0] as $sale) {
                            // return $sale;
                            $record = [];
                            foreach ($columns as $column) {
                                if (!empty($sale[$column])) {
                                    $record[$column] = $sale[$column];
                                }
                            }
                            $recordId = DB::table($table)->insertGetId($record);
                            Timeline::create(['date' => date('Y-m-d h:i:s'), 'title' => 'Sales sheet created', 'type' => 'sheet', 'sales_id' => $recordId]);
                            Timeline::create(['date' => !empty($record['screed_date']) ? date('Y-m-d h:i:s', strtotime($record['screed_date'])) : date('Y-m-d h:i:s'), 'title' => 'Sales sheet screed', 'type' => 'sheet', 'sales_id' => $recordId]);
                        }
                    } else {
                        $record = [];

                        foreach ($columns as $column) {
                            if (!empty($inputs[$column])) {
                                $record[$column] = $inputs[$column];
                            }
                        }
                        $recordId = DB::table($table)->insertGetId($record);
                        Timeline::create(['date' => date('Y-m-d h:i:s'), 'title' => 'Sales sheet created', 'type' => 'sheet', 'sales_id' => $recordId]);
                        Timeline::create(['date' => !empty($record['screed_date']) ? date('Y-m-d h:i:s', strtotime($record['screed_date'])) : date('Y-m-d h:i:s'), 'title' => 'Sales sheet screed', 'type' => 'sheet', 'sales_id' => $recordId]);

                    }

                    if ($recordId) {
                        if (!empty($inputs['sites'])) {
                            foreach ($inputs['sites'] as $site) {
                                if (isset($site['checked']) && $site['checked'])
                                    DeveloperSite::create(['developer_id' => $recordId, 'site_id' => $site['id']]);
                            }
                        }
                        return response()->json(['success' => 'record created successfully.', 'table' => $table, 'record' => $record], $this->successStatus);
                    }
                }
            }
        }
        return response()->json(['error' => 'something went wrong!'], 401);
    }

    public function update(Request $request, $id)
    {
        $table = $request->input($this->tableInput);
        $inputs = $request->input();
        if ($table) {
            if (Schema::hasTable($table)) {
                $columns = Schema::getColumnListing($table);
                if ($columns) {
                    $oldRecord = DB::table($table)->find($id);
                    $record = [];
                    foreach ($columns as $column) {
                        if (!empty($inputs[$column])) {
                            $record[$column] = $inputs[$column];
                        }

                        if ($table == 'sales') {
                            if (!empty($inputs[$column])) {
                                if ($inputs[$column] !== $oldRecord->{$column}) {
                                    if(strpos($column, 'date') !== false)
                                        Timeline::create(['date' => date('Y-m-d h:i:s'), 'title' => ucfirst($column) . ' updated', 'type' => 'sheet', 'sales_id' => $id]);
                                }
                            }
                        }

                    }

                    if (!empty($record)) {
                        $response = DB::table($table)->whereId($id)->update($record);


                        if (!empty($inputs['sites'])) {
                            foreach ($inputs['sites'] as $site) {
                                if (isset($site['checked']) && $site['checked'])
                                    DeveloperSite::create(['developer_id' => $id, 'site_id' => $site['id']]);
                            }
                        }
                        return response()->json(['success' => 'record updated successfully.', 'record' => $record], $this->successStatus);

                    }
                }
            }
        }
        return response()->json(['error' => 'something went wrong!'], 401);
    }

    public function destroy(Request $request, $id)
    {
        $table = $request->input($this->tableInput);
        if ($table) {
            if (Schema::hasTable($table)) {
                if (DB::table($table)->delete($id)) {
                    return response()->json(['success' => 'record deleted successfully.'], $this->successStatus);
                }
            }
        }
        return response()->json(['error' => 'something went wrong!'], 401);
    }

    public function getTableColumns($table)
    {
        if ($table) {
            if (Schema::hasTable($table)) {
                $columns = Schema::getColumnListing($table);
                if ($columns)
                    return response()->json(['success' => 'records fetched successfully.', 'records' => $columns], $this->successStatus);
            }
        }
        return response()->json(['error' => 'something went wrong!'], 401);

    }
}
