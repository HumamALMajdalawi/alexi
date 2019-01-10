<?php
namespace App\Repositories\Contracts;
 
interface RepositoryInterface 
{
    public function validator(array $array, $method = null);

    public function dynamicQuery($model_query, $data);

    public function all(array $data = [], $eager_load = [], $columns = array('*'));

    public function exists(array $data = []);

    public function paginate(array $data = [], $eager_load = [], $per_page = null, $columns = array('*'));

    public function create(array $data);

    public function update(array $data, $id);

    public function delete($id);

    public function find($id, $eager_load, $columns = array('*'));

    public function findBy($array, $eager_load = [], $columns = array('*'));

    public function responseJSON($message, $http_code = null);

    public function success($message = 'Success');

    public function errorSave($message = 'Error saving the data!');
   
    public function errorDelete($message = 'Error deleting the data!');
}