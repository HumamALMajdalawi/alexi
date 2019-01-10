<?php 
namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\RepositoryInterface;
use URL;
use Session;
use \Crypt;
use File;

//HELPER
use App\Helpers\SettingHelper;

//MODEL
use App\Models\Notification;

/**
 * Class BaseRepository
 */
abstract class BaseRepository implements RepositoryInterface {

    /**
     * Validator
     *
     * @param array $array
     */
    abstract public function validator(array $array, $method = null);

    /**
     * Dynamic query
     *
     * @param $model
     */
    abstract public function dynamicQuery($model_query, $data);

    /**
     * @param array $columns
     * @return mixed
     */
    public function all(array $data = [], $eager_load = [], $columns = array('*')) {
        $model_query = $this->model::query();
        $model_query->select($columns);
        
        return $this->dynamicQuery($model_query, $data)->with($eager_load)->get();
    }

    public function exists(array $data = []) {
        $model_query = $this->model::query();
        
        return $this->dynamicQuery($model_query, $data)->exists();
    }

    /**
     * @param array $columns
     * @return mixed
     */
    public function paginate(array $data = [], $eager_load = [], $per_page = null, $columns = array('*')) 
    {
        $model_query = $this->model::query();
        $model_query->select($columns);
        
        return $this->dynamicQuery($model_query, $data)->with($eager_load)->paginate(!empty($per_page) ? $per_page:SettingHelper::getPerPage());
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data) {
        return $this->model->create($data);
    }

    /**
     * @param array $data
     * @param $id
     * @param string $attribute
     * @return mixed
     */
    public function update(array $data, $id, $attribute = "id") {
        return ($this->model->where($attribute, $id)->first())->update($data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id) {
        $this->validator(['id' => $id], "delete")->validate();

        $result = $this->model->destroy($id);

        if(!$result){
            return $this->errorDelete();
        }
        Session::flash('success', 'Delete success');
        return $this->success();
    }

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $eager_load = [], $columns = array('*')) {
        return $this->model->select($columns)->with($eager_load)->find($id);
    }

    /**
     * @param $attribute
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($array, $eager_load = [], $columns = array('*')) {
        return $this->model->select($columns)->where($array)->with($eager_load)->first();
    }

    /**
     * Response
     * This method return the final response output
     *
     * @param $message
     * @return mixed
     */
    public function responseJSON($message, $http_code = 200) {
        return response()->json(array('message' => $message), $http_code);
    }

    /**
     * Response Success
     *
     * @param $message
     * @return mixed
     */
    public function success($message = 'Success') 
    {
        return $this->responseJSON($message);
    }

    /**
     * Generates a response with code 1 and a given message.
     *
     * @param $message
     * @return mixed
     */
    public function errorEmptyData($message = 'Empty to save data') 
    {
        return $this->responseJSON($message, 422);
    }

    /**
     * Generates a response with code 1 and a given message.
     *
     * @param $message
     * @return mixed
     */
    public function errorSave($message = 'Error saving the data!') 
    {
        return $this->responseJSON($message, 500);
    }

    /**
     * Generates a response with code 1 and a given message.
     *
     * @param $message
     * @return mixed
     */
    public function errorDelete($message = 'Error deleting the data!') 
    {
        return $this->responseJSON($message, 500);
    }

        /**
     * Generates a response with code 1 and a given message.
     *
     * @param $message
     * @return mixed
     */
    public function errorUpdate($message = 'Error updating the data!') 
    {
        return $this->responseJSON($message, 500);
    }

    /**
     * Generates a response with code 1 and a given message.
     *
     * @param $message
     * @return mixed
     */
    public function errorDynamic($message = 'Error') 
    {
        return $this->responseJSON($message, 500);
    }

    public function saveFile($file_upload, $parent_folder, $id) 
    {
        if ($parent_folder === 'investor-id') 
        {
            $child_folder =  "UserId" . '-' . $id;
        }
        else if ($parent_folder === 'investor-signature') 
        {
            $child_folder =  "UserId" . '-' . $id;
        }
        else
        {
            $child_folder =  "Unknown" . '-' . $id;
        }

        $destination = public_path() . '/uploads/'.$parent_folder.'/' . $child_folder;

        foreach ($file_upload as $key => $value) 
        {   
            if(is_uploaded_file($value)){
                $originalName = $value->getClientOriginalName();
                $ext = pathinfo($originalName, PATHINFO_EXTENSION);
                $datetime = date('YmdHis');

                $filename = $datetime.mt_rand(1000,9999).'.'.$ext;

                while(file_exists($destination . '/' . $filename)) {
                    $filename = $datetime.mt_rand(1000,9999).'.'.$ext;
                }
                
                //Move the file to the directory
                $value->move($destination, $filename);

                if($parent_folder === 'training-material'){
                    $count = explode('-', $key);

                    if(empty($count[1]))
                    {
                        $count[1] = 1;
                    }

                    $image_names[$count[1]]['image_name'] = $filename;
                }
                else{
                    $image_names[] = $filename;
                }
            }
            else{
               
                $value = json_decode($value,true);
                $base64_encrypted = Crypt::encrypt($value['image']);
                $datetime = date('YmdHis');
                if(!File::exists($destination)) {
                    File::makeDirectory($destination,0777,true);
                }

                $filename = $datetime.mt_rand(1000,9999);

                while(file_exists($destination . '/' . $filename)) {
                    $filename = $datetime.mt_rand(1000,9999);
                }

                File::put($destination.'/'.$filename.'.txt',$base64_encrypted);
                
                $image_names[$key]['name'] = $filename;
                $image_names[$key]['type_id'] = $value['type_id'];
            }
        }

        return $image_names;
    }    

    //Remove attributes that not suppose to be in the request
    public function unset($allowedFields,$data)
    {
        $found = false;

        if(!empty($allowedFields)){
            if(!empty($data)){
                foreach ($data as $dataKey => $dataValue) {
                    $found = false;

                    foreach ($allowedFields as $allowedFieldsKey => $allowedFieldsValue) {
                        if($dataKey==$allowedFieldsValue){
                            $found = true;                        
                        }
                    }

                    if(!$found){
                        unset($data[$dataKey]);
                    }
                }
            }
        }

        return $data;
    }

    public static function NullToEmpty($params) {
        
      //$params = $params->toArray();
        //$object = new stdClass();
        
        foreach ($params as $key => $value) {
          //if($key == 'contact_numbers'){
            //dd($value);
            ////SINGLE DATA////
            if (is_null($value)) {
                $params[$key] = '';
            }

            ////SINGLE DATA WITH OBJECT////
            if (is_object($value)) {
              
                foreach ($value->toArray() as $k => $v) {
                    //dd($k);
                    if (is_null($v)) {
                        $value[$k] = '';
                    }
                    
                   
                /////COLLECTION DATA/////
                    if (is_array($v)) {
                        self::NullToEmpty($v);//rolling loop
                    } 
                }
            }

            /////COLLECTION DATA/////
            if (is_array($value)) {
                $params[$key] = self::NullToEmpty($value);//rolling loop
            }
            //}
        }
            

        return $params;
    }

    public static function getWalletId($user) {
        $wallet_id = $user['wallet']['id'];
        if($user['role_id']==8){//if staff wallet will go to referral(retailer)
            $wallet_id = $user['parent_referral']['wallet']['id'];
        }   

        return $wallet_id;
    }

    
}