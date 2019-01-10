<?php

namespace App\Http\Controllers\Api;

use App\Models\Action;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Role;
use App\Models\RoleAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class RoleController extends Controller
{
    public $successStatus = 200;


    public function index()
    {
        $roles = Role::select(['id', 'name'])->orderBy("created_at", "desc");
        if (Auth::user()->role_id == 3) {
//            $roles = $roles->where('id', 4);
        }
        $roles = $roles->get();
        $branches = Branch::select(['id as id', 'id as value', 'name as title'])->orderBy("created_at", "desc")->get();
        return response()->json(['roles' => $roles, 'branches' => $branches], $this->successStatus);

    }

    public function actions( $id)
    {
        $role = Role::find($id);

        $actionIds = [];

        if ($role) {
            $actionIds = RoleAction::where('role_id', $id)->pluck("action_id");
            if ($actionIds)
                $actionIds = $actionIds->toArray();
        }


        if ($role) {
            $actions = Action::getActionsMenu();
            foreach ($actions as $action) {
                if (!empty($action['children'])) {
                    foreach ($action['children'] as $child) {
                        if (isset($child['children']) && count($child['children']) == 0) {
                            if (in_array($child['id'], $actionIds)) {
                                $child['checked'] = true;
                            } else if ($child['text'] == 'view') {
                                if (in_array($action['id'], $actionIds)) {
                                    $child['checked'] = true;
                                }
                            }
                        } else {
                            foreach ($child['children'] as $c) {
                                if (in_array($c['id'], $actionIds)) {
                                    $c['checked'] = true;
                                } else if ($c['text'] == 'view') {
                                    if (in_array($child['id'], $actionIds)) {
                                        $c['checked'] = true;
                                    }
                                }
                            }
                        }
                    }
                }
            }
            return $actions;
        }
        return response()->json(['error' => 'something went wrong!'], 401);

    }

    public function save_actions(Request $request, $id)
    {
        $role = Role::find($id);
        if ($role) {
            RoleAction::where("role_id", $id)->delete();
            $menu = $request->input("items");
            foreach ($menu as $action) {
                if (isset($action['children'])) {
                    $children = $action['children'];
                    unset($action['children']);
                }

                if (!empty($children)) {
                    foreach ($children as $c) {
                        if (!empty($c['children'])) {
                            foreach ($c['children'] as $child) {
                                if (isset($child['checked']) && $child['checked']) {
                                    if ($child['text'] == 'view') {
                                        RoleAction::create(['action_id' => $action['id'], 'role_id' => $role->id]);
                                        RoleAction::create(['action_id' => $c['id'], 'role_id' => $role->id]);
                                    } else
                                        RoleAction::create(['action_id' => $child['id'], 'role_id' => $role->id]);
                                }
                            }
                        } else {
                            if (isset($c['checked']) && $c['checked']) {
                                if ($c['text'] == 'view') {
                                    RoleAction::create(['action_id' => $action['id'], 'role_id' => $role->id]);
                                } else
                                    RoleAction::create(['action_id' => $c['id'], 'role_id' => $role->id]);
                            }
                        }
                    }
                }
            }
        }
        return response()->json(['success' => 'role stored successfully.'], $this->successStatus);
    }


    public function menu()
    {
        $menu = [];
        $roles = [];
        $actions = [];
        $user = Auth::user();
        $role = $user->role_id;
        $ids = RoleAction::where('role_id', $role)->pluck('action_id');
        if ($ids) {
            $menu = Action::select(["icon", "id", "group_name as title", "link"])->with(['children' => function ($q) use ($ids) {
                $q->select(["id", "title", "link", "parent_id"]);
                $q->where('is_active', 1);
                $q->where('is_menu', 1);
                $q->whereIn('id', $ids->toArray());
            }])->where('is_active', 1)
                ->whereNull('parent_id')
                ->orderBy('menu_order', 'asc')
                ->whereIn('id', $ids->toArray())->get();
            $actions = Action::whereNotNull("route")
                ->where('is_menu', 0)
                ->where('is_active', 1)
                ->whereNotNull("parent_id")
                ->whereIn("id", $ids)
                ->pluck("route");

            if ($actions) {
                $actions = $actions->toArray();
            }
            if ($menu) {
                $menu = $menu->toArray();
                foreach ($menu as &$action) {
                    if (!empty($action['link']))
                        $roles[] = $action['link'];
                    if (empty($action['children']))
                        unset($action['children']);
                    else {
                        foreach ($action['children'] as $child) {
                            if (!empty($child['link']))
                                $roles[] = $child['link'];
                        }
                    }
                }
            }
        }
        return response()->json(['actions' => json_encode($actions), 'roles' => json_encode($roles), 'menu' => $menu], $this->successStatus);
    }

    public
    function store(Request $request)
    {
        $input = $request->input();
        $validator = Validator::make($input, [
            'name' => 'required',
            'description' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $record = new Role();
        foreach ($record->getFillable() as $fillable) {
            if (!empty($input[$fillable]))
                $record->{$fillable} = $input[$fillable];
        }
        if ($record->save()) {
            return response()->json(['success' => 'role stored successfully.', 'record' => $record], $this->successStatus);
        }
        return response()->json(['error' => 'something went wrong!'], 401);
    }

    public
    function update(Request $request, $id)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'description' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $record = Role::find($id);
        if ($record) {
            foreach ($record->getFillable() as $fillable) {
                if (!empty($input[$fillable]))
                    $record->{$fillable} = $input[$fillable];
            }
            if ($record->save()) {
                return response()->json(['success' => 'role updated successfully.', 'sales' => $record], $this->successStatus);
            }
        }
        return response()->json(['error' => 'something went wrong!'], 401);
    }

    public
    function destroy($id)
    {
        $record = Role::find($id);
        if ($record) {
            if ($record->delete())
                return response()->json(['success' => 'user deleted successfully.'], $this->successStatus);
        }
        return response()->json(['error' => 'user not found.'], 401);
    }


}
