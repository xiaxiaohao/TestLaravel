<?php


namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseController;
use App\Model\ApiModel;



class UserController extends BaseController
{


    public function FindAll()
    {
        return ApiModel::all();
    }

    public function FindOne($id)
    {
        return ApiModel::findOrFail($id);

        return $this->response->array($user->toArray());
    }
}