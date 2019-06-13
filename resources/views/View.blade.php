<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>标签列表</title>
    <link href="/css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="/css/custom.css" rel="stylesheet">
    <link href="/css/animate.css" rel="stylesheet">
    <link href="/css/style.css?v=4.1.0" rel="stylesheet">
</head>

<body class="gray-bg">

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-6">

            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>表格</h5>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    @if ($message = Session::get('failed'))
                        <div class="alert alert-error alert-danger">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                </div>

                <div class="ibox-content">

                    <table class="table">
                        <thead>
                        <tr>
                            <th>id</th>
                            <th>标签名</th>
                            <th>分类路径</th>
                            <th>标签规格</th>
                            <th>图片</th>
                            <th>新增时间</th>
                            <th>更新时间</th>
                            <th>标签操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <button class="btn btn-primary">新增标签</button>

                        @foreach($tags as $tag)
                            <tr>
                                <td>{{ $tag->id }}</td>
                                <td>{{ $tag->tag_name }}</td>
                                <td>
                            @php include_once ('../resources/views/Recursion.php');
                                 $aa = new Recursion();
                                 $id = null;
                                 $link = null;
                                 $categories = $categories;
                                 if($tag->category_id != 0){
                                    $id = $tag->category_id;
                                    $link = $aa ->Montage($link,$id,$categories);
                                 }
                                 echo $link;
                            @endphp

                                </td>
                                <td>{{ $tag->tag_specs }}</td>
                                <td>{{ $tag->pic }}</td>
                                <td>{{ $tag->add_time }}</td>
                                <td>{{ $tag->update_time }}</td>
                                <td>
                                    <button class="btn btn-info" id="{{$tag->id}}">下载标签</button>
                                    <button class="btn btn-warning" id="{{$tag->id}}">删除标签</button>
                                <td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- 全局js -->
<script src="/js/jquery.min.js?v=2.1.4"></script>
<script src="/js/bootstrap.min.js?v=3.3.6"></script>

<!-- Peity -->
<script src="/js/jquery.peity.min.js"></script>

<!-- iCheck -->
<script src="/js/icheck.min.js"></script>

<!-- Peity -->
<script src="/js/peity-demo.js"></script>

<script src="/js/help.js"></script>

<script>



</script>
</body>
</html>