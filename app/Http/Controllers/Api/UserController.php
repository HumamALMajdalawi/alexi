<?php

namespace App\Http\Controllers\Api;

use App\Models\Branch;
use App\Models\Role;
use App\Models\Sales;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Helpers\SettingHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use UserRepo;

class UserController extends Controller
{
    public $successStatus = 200;

    private $roles = [];
    protected $repo;

    public function __construct(UserRepo  $repo)
    {
        $this->repo = $repo;
        $this->roles = Role::select("id", "name")->get()->keyBy("id");
        $this->branches = Branch::select("id", "name")->get()->keyBy("id");
    }

    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    //Display a list of users
    public function index(Request $request)
    {
        $type = $request->input('type');
        $users = User::orderBy("created_at", "desc");
        if (!empty($type)) {
            if ($type == 'admins') {
                $users = $users->where('role_id', 2);
            } else if ($type == 'branch') {
                $users = $users->where('role_id', 3);
            } else if ($type == 'staff') {
                $users = $users->where('role_id', 4);
            } else if ($type == 'fitters') {
                $users = $users->where('role_id', 5);
            }
        }
        // $user = Auth::user();
        // $branch_id = $user->branch_id ? $user->branch_id : 0;
        // $role_id = $user->role_id ? $user->role_id : 0;

        // //Branch Manager
        // if ($role_id == 3) {
        //     $users = $users->where("branch_id", $branch_id)->where('role_id', 4);
        // }
        $users = $users->get();
        $roles = $this->roles;
        $branches = $this->branches;
        $users = $users->map(function ($message) use ($roles, $branches) {
            $message->branch_id = isset($branches[$message->branch_id]) ? $branches[$message->branch_id]->name : '';
            $message->role_id = isset($roles[$message->role_id]) ? $roles[$message->role_id]->name : '';
            return $message;
        });
        return $this->paginate($users, 10);
    }

    public function filter()
    {
        $users = User::select("id", "name")->get()->keyBy("id")->toArray();
        $sales = Sales::select("id", "site as name")->get();
        return response()->json(['success' => true, 'sales' => $sales, 'users' => $users], $this->successStatus);

    }

    public function numbers()
    {
        $users = User::select('role_id', DB::raw('count(*) as total'))
            ->groupBy('role_id')
            ->get()->toArray();
        $allCount = User::count();
        return response()->json(['all' => $allCount, 'roles' => $users], $this->successStatus);
    }


    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    public function details($id)
    {
        $user = User::find($id);
        return response()->json(['success' => $user], $this->successStatus);
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required|string|between:4,60',
            'email' => 'required|email|unique:users',
            'password' => 'required|between:6,25',
            'role_id' => 'required|exists:roles,id',
            'branch_id' => 'required|exists:branches,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }

        $user = new User();
        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->password = bcrypt($input['password']);
        $user->role_id = $input['role_id'];
        $user->branch_id = $input['branch_id'];

        if ($user->save()) {
            $roles = $this->roles;
            $branches = $this->branches;
            $user->role_id = isset($roles[$user->role_id]) ? $roles[$user->role_id]->name : '';
            $user->branch_id = isset($branches[$user->branch_id]) ? $branches[$user->branch_id]->name : '';
            return response()->json(['success' => 'user stored successfully.', 'user' => $user], $this->successStatus);
        }
        return response()->json(['error' => 'something went wrong!'], 401);
    }

    /**
     * Update user name
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required|string|between:4,60',
            'email' => 'required|email',
            'role_id' => 'required|exists:roles,id',
//            'branch_id' => 'required|exists:branches,id'
        ]);

//        if (isset($input['role_id']) && $input['role_id'] == '4')
//            if (empty($input['branch_id']) || $input['branch_id'] == 0) {
//
//            }

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }


        $user = User::find($id);
        if (is_null($user)) {
            return response()->json(['error' => 'user not found.'], 401);
        }


        $user->name = $input['name'];
        $user->email = $input['email'];
        if (isset($input['password']))
            $user->password = bcrypt($input['password']);

        $user->role_id = $input['role_id'];
        $user->branch_id = $input['branch_id'];
        if ($user->save()) {
            $roles = $this->roles;
            $branches = $this->branches;
            $user->role_id = isset($roles[$user->role_id]) ? $roles[$user->role_id]->name : '';
            $user->branch_id = isset($branches[$user->branch_id]) ? $branches[$user->branch_id]->name : '';
            return response()->json(['success' => 'user updated successfully.', 'user' => $user], $this->successStatus);
        }
        return response()->json(['error' => 'user not found.'], 401);
    }


    /**
     * Remove specific user
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if (is_null($user)) {
            return response()->json(['error' => 'user not found.'], 401);
        }
        if ($user->delete())
            return response()->json(['success' => 'user deleted successfully.'], $this->successStatus);
        else
            return response()->json(['error' => 'user not found.'], 401);
    }

    public function profile(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            $input = $request->all();
            $validator = Validator::make($input, [
                'name' => 'required|string|between:4,60',
                'password' => 'same:password_confirmation',
                'telephone' => 'required',
            //    'email' => 'required|unique:users',
                   'email' => '',
                'dob' => 'required',
            ]);
            if ($validator->fails())
                return response()->json(['error' => $validator->errors()], 401);

            $user->name = $input['name'];
            $user->email = $input['email'];
            $user->telephone = $input['telephone'];
            $user->dob = $input['dob'];
            if (!empty($input['password']))
                $user->password = bcrypt($input['password']);
            if ($user->save()) {
                return response()->json(['success' => 'user updated successfully.', 'user' => $user], $this->successStatus);
            }
        }
        return response()->json(['error' => 'user not found.'], 401);
    }

    public function current()
    {
        $user = Auth::user();
        if ($user) {
            return response()->json(['success' => 'user logged.', 'user' => $user], $this->successStatus);
        }
        return response()->json(['error' => 'user not found.'], 401);
    }

    public function upload(Request $request)
    {
        $user = Auth::user();
        $image = $request->file('image');
        if ($image && $user) {

            $destinationPath = '/images/users/';
            if (!file_exists(public_path() . $destinationPath)) {
                mkdir(public_path() . $destinationPath, 0777, true);
            }
            $name = time() . uniqid() . '.png';
            $image->move(public_path() . $destinationPath, $name);
            $user->image = $destinationPath . $name;
            if ($user->save())
                return ['status' => 'success', 'path' => $destinationPath . $name];
        }
        return ['status' => 'error', 'msg' => trans('messages.error')];
    }
}
