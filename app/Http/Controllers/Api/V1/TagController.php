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


    public function manageTag()
    {
        $tags = TagModel::where('is_delete', '=', 0)
            ->get();
        $allTags = TagModel::pluck('tag_name','id')->all();
        return view('View',compact('tags','allTags'));
    }

    public function findAll()
    {
//        $tag = TagModel::all();
//        $tags = TagModel::paginate(25);


        $tags = TagModel::where('is_delete', '=', 0)->get();
        $allTags = TagModel::pluck('tag_name','id')->all();
        return view('View',compact('tags','allTags'));
//
//        return $this->response->paginator($tags, new TagTransformer);
    }


    public function findOne($id)
    {
        $tag = TagModel::all();
        $tags = $tag->toArray();
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
                    if (($request->category_id) != null) {
                        $tag->category_id = $request->category_id;
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
                    if (($request->add_time) != null) {
                        $tag->add_time = $request->add_time;
                    }

                    $tag->save();
                    $this->msg(200, 'success update one');
                }
            } else {
                $tag = new TagModel();
                $tag->tag_name = $request->tag_name;
                if (($request->category_id) != null) {
                    $tag->category_id = $request->category_id;
                }
                $tag->tag_specs = $request->tag_specs;
                $tag->add_time = $request->add_time;
                $tag->pic = $request->pic;
                $tag->save();
                $this->msg(200, 'success add one');
            }


        } catch (\Exception $exception) {
//          $a= $exception->getMessage();
            $this->msg(1000, "此用户不存在");
        }
    }

    public function uploadImg(Request $request){

        $tag_pic = $request->pic('img');
        if ($tag_pic) {

            //获取文件的原文件名 包括扩展名
            $yuanname= $tag_pic->getClientOriginalName();

            //获取文件的扩展名
            $tag=$tag_pic->getClientOriginalExtension();

            //获取文件的类型
            $type=$tag_pic->getClientMimeType();

            //获取文件的绝对路径，但是获取到的在本地不能打开
            $path=$tag_pic->getRealPath();

            //要保存的文件名 时间+扩展名
            $filename=date('Y-m-d') . '/' . uniqid() .'.'.$tag;
            //保存文件          配置文件存放文件的名字  ，文件名，路径
            $bool= Storage::disk('uploadimg')->put($filename,file_get_contents($path));
            //return back();
            return json_encode(['status'=>1,'filepath'=>$filename]);
        }else{
            $idCardFrontImg = '';
            return json_encode($idCardFrontImg);
        }
    }




}