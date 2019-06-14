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
        return view('View', compact('tags', 'categories'));

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

        return response()->download(realpath(base_path('public/uploads')) . $tag->pic, 'Tagdown.png');
    }


    public function DeleteOne(Request $request)
    {

        try {

            DB::table('tag')->where('id', $request->id)->update(['is_delete' => 1]);
        } catch (Exception $e) {
            $this->msg($e->getCode(), $e->getMessage());
        }
        $this->msg(200, 'delete success');
    }


    public function UpdateOne(Request $request)
    {
        try {
            if ($request->id != null) {
                $tag = TagModel::findOrFail($request->id);
                if ($tag && ($tag->is_delete == 0)) {
                    if (($request->tag_name) != null) {
                        $tag->tag_name = $request->tag_name;
                    } else {
                        return back()->with('failed', 'tag_name is null');
                    }


                    if (($request->category_id) != null) {
                        $tag->category_id = $request->category_id;
                    } else {
                        return back()->with('failed', 'category_id is null');
                    }


                    if (($request->tag_specs) != null) {
                        $tag->tag_specs = $request->tag_specs;
                    } else {
                        return back()->with('failed', 'tag_specs is null');
                    }


                    if (($request->pic) != null) {
                        $tag->pic = $request->pic;
                    } else {
                        return back()->with('failed', 'picture is null');
                    }


                    if (($request->update_time) != null) {
                        $tag->update_time = $request->update_time;
                    }

                    $file = $request->file('pic');
                    //判断文件是否上传成功

                    if ($file->isValid()) {
                        //限制文件后缀
                        $fileTypes = array('png', 'jpg');
                        //原文件名
                        $originalName = $file->getClientOriginalName();
                        //扩展名
                        $ext = $file->getClientOriginalExtension();
                        $isInFileType = in_array($ext, $fileTypes);
                        //判断文件后缀
                        if ($isInFileType) {
                            $type = $file->getClientMimeType();
                            //临时绝对路径
                            $realPath = $file->getRealPath();
                            $filename = uniqid() . '.' . $ext;
                            $bool = Storage::disk('uploads')->put($filename, file_get_contents($realPath));
                            //判断是否上传成功
                            if ($bool) {
                                $tag->pic = "/" . $filename;
                            } else {
                                echo 'fail';
                            }
                        } else {
                            return back()->with('failed', 'File format is not correct');
                        }

                    } else {
                        return back()->with('failed', 'picture is null');
                    }


                    $tag->save();
                    return back()->with('success', '更新成功');
                } else {
                    return back()->with('failed', '更新失败');
                }
            } else {
                $tag = new TagModel();

                if (($request->tag_name) == null) {
                    return back()->with('failed', 'tag_name is null');
                } else {
                    $tag->tag_name = $request->tag_name;
                }


                if (($request->category_id) == null) {

                    return back()->with('failed', 'category_id is null');
                } else {
                    $tag->category_id = $request->category_id;
                }


                if (($request->tag_specs) == null) {
                    return back()->with('failed', 'tag_specs is null');
                } else {
                    $tag->tag_specs = $request->tag_specs;
                }


                if (($request->pic) == null) {
                    return back()->with('failed', 'picture is null');
                } else {
                    $tag->pic = $request->pic;
                }

                $file = $request->file('pic');
                //判断文件是否上传成功

                if ($file->isValid()) {
                    //限制文件后缀
                    $fileTypes = array('png', 'jpg');
                    //原文件名
                    $originalName = $file->getClientOriginalName();
                    //扩展名
                    $ext = $file->getClientOriginalExtension();
                    $isInFileType = in_array($ext, $fileTypes);
                    //判断文件后缀
                    if ($isInFileType) {
                        $type = $file->getClientMimeType();
                        //临时绝对路径
                        $realPath = $file->getRealPath();
                        $filename = uniqid() . '.' . $ext;
                        $bool = Storage::disk('uploads')->put($filename, file_get_contents($realPath));
                        //判断是否上传成功
                        if ($bool) {
                            $tag->pic = "/" . $filename;
                        } else {
                            echo 'fail';
                        }
                    } else {
                        return back()->with('failed', 'File format is not correct');
                    }

                } else {
                    return back()->with('failed', 'picture is null');
                }


                $tag->save();
                return back()->with('success', '添加成功');
            }

        } catch (\Exception $exception) {
            echo $exception->getMessage();
//            $this->msg(1000, "error not found");
        }
    }

//    public function check($request, $tag)
//    {
//
//
//        $file = $request->file('pic');
//        //判断文件是否上传成功
//
//        if ($file->isValid()) {
//            //限制文件后缀
//            $fileTypes = array('png', 'jpg');
//            //原文件名
//            $originalName = $file->getClientOriginalName();
//            //扩展名
//            $ext = $file->getClientOriginalExtension();
//            $isInFileType = in_array($ext, $fileTypes);
//            //判断文件后缀
//            if ($isInFileType) {
//                $type = $file->getClientMimeType();
//                //临时绝对路径
//                $realPath = $file->getRealPath();
//                $filename = uniqid() . '.' . $ext;
//                $bool = Storage::disk('uploads')->put($filename, file_get_contents($realPath));
//                //判断是否上传成功
//                if ($bool) {
//                    $tag->pic = "/" . $filename;
//                } else {
//                    echo 'fail';
//                }
//            }
//
//        } else {
//            return back()->with('failed', 'picture is null');
//        }
//
//
//        return $tag;
//    }


}