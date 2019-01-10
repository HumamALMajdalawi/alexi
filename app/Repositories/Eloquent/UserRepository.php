<?php 
namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\RepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Support\Facades\DB;
use Validator;
use Session;
use Auth;
use Log;

//MODEL
use App\Models\User;
use App\Models\DealerApplication;

class UserRepository extends BaseRepository 
{
    protected $model;
    
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function validator(array $data, $method = null) 
    {
        $attributeNames = [
        ];

        $messages = [
        ];
        
        $rule = [];
       

        return Validator::make($data, $rule, $messages)->setAttributeNames($attributeNames);
    }

    public function dynamicQuery($model_query, $data)
    {
        //SEARCH BASE ON REQUEST (GET) VALUE
        if(!empty($data['id']) && $data['id'] != ''){
          $model_query->where('id',$data['id']);
        }

        if(!empty($data['name']) && $data['name'] != ''){
          $model_query->where('name',$data['name']);
        }


        if(!empty($data['email']) && $data['email'] != ''){
          $model_query->where('email', $data['email']);
        }

 
        return $model_query;
    }

    
}