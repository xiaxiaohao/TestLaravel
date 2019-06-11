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
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tags as $tag)
                        <tr>
                            <td>{{ $tag->id }}</td>
                            <td>{{ $tag->tag_name }}</td>
                            <td>{{ $tag->category_id }}</td>
                            <td>{{ $tag->tag_specs }}</td>
                            <td>{{ $tag->pic }}</td>
                            <td>{{ $tag->add_time }}</td>
                            <td>{{ $tag->update_time }}</td>
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

<script>

</script>
</body>
</html>