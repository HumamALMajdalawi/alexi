<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class TableColumnsController extends Controller
{


    public function index()
    {
        //return 'testttttttt'.$table_name;
    }


    public function show($table_name)
    {

        return response()->json(['data' => DB::getSchemaBuilder()->getColumnListing($table_name)]);

    }






}
