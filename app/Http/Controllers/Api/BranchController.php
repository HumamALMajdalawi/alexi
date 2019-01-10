<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Support\Facades\Auth;

class BranchController extends Controller
{
    public $successStatus = 200;

    public function index(Request $request)
    {
        return $Branch = Branch::orderBy("created_at", "desc")->paginate(10);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $input['created_by'] = Auth::id();
        $record = new Branch();
        foreach ($record->getFillable() as $fillable) {
            if (!empty($input[$fillable]))
                $record->{$fillable} = $input[$fillable];
        }
        if ($record->save()) {
            return response()->json(['success' => 'branch stored successfully.', 'branch' => $record], $this->successStatus);
        }
        return response()->json(['error' => 'something went wrong!'], 401);
    }

    public function numbers()
    {
        $staff = User::where('role_id', 4)->count();
        $branches = Branch::count();
        return response()->json(['staff' => $staff, 'branches' => $branches], $this->successStatus);
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $record = Branch::find($id);
        if ($record) {
            foreach ($record->getFillable() as $fillable) {
                if (!empty($input[$fillable]))
                    $record->{$fillable} = $input[$fillable];
            }
            if ($record->save()) {
                return response()->json(['success' => 'branch updated successfully.', 'branch' => $record], $this->successStatus);
            }
        }
        return response()->json(['error' => 'something went wrong!'], 401);
    }


    public function destroy($id)
    {
        $record = Branch::find($id);
        if ($record) {
            if ($record->delete())
                return response()->json(['success' => 'branch deleted successfully.'], $this->successStatus);
        }
        return response()->json(['error' => 'branch not found.'], 401);
    }


}
