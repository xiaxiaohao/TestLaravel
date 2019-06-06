<?php


namespace App\Http\Controllers\Api\V1;


use App\Exceptions\UserException;
use App\Http\Controllers\Controller;
use App\Model\UserModel;

use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class UserController extends Controller
{
    use Helpers;

    protected function msg($errcode = 0, $msg = '', $data = [])
    {
        header('Content-Type:application/json; charset=utf-8');
        $r = [
            'errcode' => $errcode,
            'msg' => $msg,
            'data' => $data
        ];
        exit(json_encode($r));
    }

    protected function success($msg = '', $data = [])
    {
        if (is_string($msg)) {
            $this->msg(0, $msg, $data);
        } else {
            $this->msg(0, '', $msg);
        }
    }

    protected function error($msg = '', $errcode = -1)
    {
        $this->msg($errcode, $msg);
    }


    public function findAll()
    {
//        return UserModel::all();
//     定制化响应

        $user = UserModel::all();
//        响应一个数组
//        return $this->response->array($user->toArray());
//        响应一个元素集合
//        return $this->response->collection($user,new UserTransformer());
//        分页响应
        $users = UserModel::paginate(25);

        return $this->response->paginator($users, new UserTransformer);
    }


    public function findOne($id)
    {

//        return ApiModel::findOrFail($id);
        $users = UserModel::all();
        $users = $users->toArray();

//      定制化响应
        if ($id > count($users)) {
//            throw  new NotFoundHttpException("asdadsa");
            throw  new UserException(401);

//            return $this->response->noContent();

        }

        $user = UserModel::findOrFail($id);

        return $this->response->item($user, new UserTransformer())->withHeader('X-Foo', 'Bar')->addMeta('ddd', 'zzk');

    }


    public function DeleteOne(Request $request)
    {
        try {

            $user = UserModel::findOrFail($request->id);
            if ($user) {
                UserModel::deleted($request->id);
                $this->msg(200, "success");
            }

        } catch (\Exception $exception) {
            $a = $exception->getMessage();
            $this->msg(1000, $a);
        }
    }

    public function UpdateOne(Request $request)
    {
        try {

            if ($request->id != null) {
                $user = UserModel::findOrFail($request->id);
                if ($user) {
                    if (($request->userName) != null) {
                        $user->user_name = $request->userName;
                    }
                    if (($request->password) != null) {
                        $user->password = $request->password;
                    }
                    if (($request->number) != null) {
                        $user->number = $request->number;
                    }
                    $user->save();
                    $this->msg(200, 'success update one');
                }
            } else {
                $user = new UserModel();
                $user->user_name = $request->userName;
                if (($request->password) != null) {
                    $user->password = $request->password;
                }
                $user->number = $request->number;


                $user->save();
                $this->msg(200, 'success add one');
            }


        } catch (\Exception $exception) {
//            $a= $exception->getMessage();
            $this->msg(1000, "此用户不存在");
        }
    }

}