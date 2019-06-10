<?php


namespace App\Http\Controllers\Api\V1;

use App\Exceptions\TagException;
use App\Http\Controllers\Controller;

use App\Model\TagModel;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\DB;

class TagController extends Controller
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
        $tag = TagModel::all();

        $tags = TagModel::paginate(25);

        return $this->response->paginator($tags, new TagTransformer);
    }


    public function findOne($id)
    {
        $tags = TagModel::all();
        $tags = $tags->toArray();
        if ($id > count($tags)) {
            throw  new TagException(401);

        }

        $tag = TagModel::findOrFail($id);

        return $this->response->item($tag, new TagTransformer())->withHeader('X-Foo', 'Bar')->addMeta('ddd', 'zzk');

    }


    public function DeleteOne(Request $request)
    {
        try {

            $tag = TagModel::findOrFail($request->id);
            if ($tag) {
                if(($tag->is_delete) == 0) {
                    DB::table('tag')->where('id', $request->id)->update(['is_delete' => 1]);
//                    $tag->delete();
                   $this->msg(200, "delete success");
                }else {
                    $this->msg(1000, "delete error");
                }
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
                $tag = TagModel::findOrFail($request->id);
                if ($tag) {
                    if (($request->tag_name) != null) {
                        $tag->tag_name = $request->tag_name;
                    }
                    if (($request->tag_category_id) != null) {
                        $tag->tag_category_id = $request->tag_category_id;
                    }
                    if (($request->tag_specs) != null) {
                        $tag->tag_specs = $request->tag_specs;
                    }
                    if (($request->pic) != null) {
                        $tag->pic = $request->pic;
                    }
                    if (($request->update_time) != null) {
                        $tag->update_time = $request->update_time;
                    }

                    $tag->save();
                    $this->msg(200, 'success update one');
                }
            } else {
                $tag = new TagModel();
                $tag->tag_name = $request->tag_name;
                if (($request->tag_category_id) != null) {
                    $tag->tag_category_id = $request->tag_category_id;
                }
                $tag->tag_specs = $request->tag_specs;
                $tag->add_time = $request->add_time;


                $tag->save();
                $this->msg(200, 'success add one');
            }


        } catch (\Exception $exception) {
//          $a= $exception->getMessage();
            $this->msg(1000, "此用户不存在");
        }
    }



}