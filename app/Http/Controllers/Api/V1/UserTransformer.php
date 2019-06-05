<?php


namespace App\Http\Controllers\Api\V1;

use App\Model\UserModel;
use League\Fractal\TransformerAbstract;

class UserTransformer extends  TransformerAbstract
{
    public function transform(UserModel $userModel){
        return [
            'id'=>$userModel['id'],
            'username'=>$userModel['user_name'],
            'number'=>$userModel['number'],
        ];
    }


}