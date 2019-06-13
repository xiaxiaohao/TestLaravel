<!DOCTYPE html>
<html>
<head>
    <title>标签管理</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" />
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link href="/css/treeview.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">标签添加</div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <h3>选择分类
                    </h3>
                    <ul id="tree1">
                        @foreach($categories as $category)
                            <li id="{{ $category->id }}">
                                {{ $category->title }}
                                @if(count($category->childs))
                                    @include('manageChild',['childs' => $category->childs])
                                @endif
                            </li>
                        @endforeach
                    </ul>

                </div>
                <div class="col-md-6">
                    <h3>Add New Tag</h3>
                    {!! Form::open(array('route'=>'add-tag','enctype'=>'multipart/form-data','method' => 'post')) !!}
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

                    <div class="form-group {{ $errors->has('tag_name') ? 'has-error' : '' }}">
                        {!! Form::label('tag_name:') !!}
                        {!! Form::text('tag_name', old('tag_name'), ['class'=>'form-control', 'placeholder'=>'Enter Name']) !!}
                        <span class="text-danger">{{ $errors->first('tag_name') }}</span>
                    </div>

                    <div  class="form-group {{ $errors->has('category_id') ? 'has-error' : '' }}">
                        {!! Form::label('Category id:') !!}
                        {!! Form::text('category_id', old('category_id'), ['id'=>'category_id','class'=>'form-control', 'placeholder'=>'Choose Category','readonly'=>'true']) !!}
                        <span class="text-danger">{{ $errors->first('category_id') }}</span>
                    </div>

                    <div class="form-group {{ $errors->has('tag_specs') ? 'has-error' : '' }}">
                        {!! Form::label('Tag_specs:') !!}
                        {!! Form::text('tag_specs', old('tag_specs'), ['class'=>'form-control', 'placeholder'=>'Enter Tag_specs']) !!}
                        <span class="text-danger">{{ $errors->first('tag_specs') }}</span>
                    </div>

                    <div class="form-group {{ $errors->has('pic') ? 'has-error' : '' }}">
                        {!! Form::label('picture:') !!}
                        {!! Form::file('pic', old('pic'), ['class'=>'form-control', 'placeholder'=>'Upload Picture']) !!}
                        <span class="text-danger">{{ $errors->first('tag_specs') }}</span>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-success">Add New</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>

        </div>
    </div>
</div>


<script src="/js/treeview.js"></script>
<script src="/js/help.js"></script>
</body>
</html>