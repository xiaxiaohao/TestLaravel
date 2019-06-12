<?php


namespace App\Http\Controllers\Api\V1;

use App\Exceptions\TagException;
use App\Http\Controllers\Controller;

use App\Model\TagModel;
use App\Model\Category;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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

        $tags = TagModel::where('is_delete', '=', 0)->get();
        $categories = Category::all();
        return view('View',compact('tags','categories'));

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

    public function Download(Request $request)
    {
        $tag = TagModel::findOrFail($request->id);

        return response()->download(realpath(base_path('public/uploads')).$tag->pic,'Tagdown.png');
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
                if ($tag && ($tag->is_delete == 0)) {
                    $tag = $this->check($request,$tag);
                    $tag->save();
                    $this->msg(200, 'success update one');
                }
                else{
                    $this->msg(404, 'tag not found');
                }
            } else {
                $tag = new TagModel();
                $tag = $this->check($request,$tag);
                $tag->save();
                $this->msg(200, 'success add one');
            }

        } catch (\Exception $exception) {
          echo $exception->getMessage();
//            $this->msg(1000, "error not found");
        }
    }

    public function check($request,$tag){

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



            $file = $request->file('pic');
            //判断文件是否上传成功
            if ($file->isValid()){
                //原文件名
                $originalName = $file->getClientOriginalName();
                //扩展名
                $ext = $file->getClientOriginalExtension();
                //MimeType
                $type = $file->getClientMimeType();
                //临时绝对路径
                $realPath = $file->getRealPath();
                $filename = uniqid().'.'.$ext;
                $bool = Storage::disk('uploads')->put($filename,file_get_contents($realPath));
                //判断是否上传成功
                if($bool){
                    $tag->pic = "/".$filename;
                }else{
                    echo 'fail';
                }
            }

        return $tag;
    }




}