@extends('layouts.user_layout')

@section('title', $pageListKeyLanguage['header_page'])

@section('content')
    @if(session('subscriptionId') !== 1)
        @if(session('endSubscription') === true)
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{$pageListKeyLanguage['header_page']}}</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-check"></i>{{ session('success') }}</h4>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-ban"></i>{{ session('error') }}</h4>
                </div>
            @endif
            @if(isset($message))
                <div class="alert alert-danger">{{ $message }}</div>
            @endif
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary">
                        <!-- form start -->
                        <form action="{{ route('voiceCreateUserSound') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputName">{{$pageListKeyLanguage['label_record_name']}}</label>
                                    <input type="text" name="name" class="form-control" id="exampleInputName" placeholder="Имя записи" required >
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">{{$pageListKeyLanguage['label_language_record']}}</label>

                                    <select class="form-control select2 select2-hidden-accessible" name="language" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true" required>
                                        <option selected="selected" data-select2-id="3"></option>
                                        @foreach($languages as $language)
                                            <option data-select2-id="46" value="{{$language->id}}" >{{$language->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlFile1">{{$pageListKeyLanguage['label_select_file']}}</label>
                                    <input type="file" name="file" class="form-control-file" id="exampleFormControlFile1"  required>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">{{$pageListKeyLanguage['btn_save']}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
{{--    <section class="content">--}}
{{--        <div class="container-fluid">--}}
{{--            <div class="row">--}}
{{--                <div class="col-lg-12">--}}
{{--                    <div class="card card-primary">--}}
{{--                        <!-- form start -->--}}
{{--                        <form action="{{ route('voice_by_user.store') }}" method="POST">--}}
{{--                            @csrf--}}
{{--                            <div class="card-body">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="exampleInputName">Имя записи</label>--}}
{{--                                    <input type="text" name="name" class="form-control" id="exampleInputName" placeholder="Имя записи" required >--}}
{{--                                </div>--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="exampleFormControlTextarea1">Текс записи</label>--}}
{{--                                    <textarea class="form-control" name="text" id="exampleFormControlTextarea1" rows="3"></textarea>--}}
{{--                                </div>--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="exampleInputEmail1">Язык записи</label>--}}

{{--                                    <select class="form-control select2 select2-hidden-accessible" name="language" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true" required>--}}
{{--                                        <option selected="selected" data-select2-id="3"></option>--}}
{{--                                        @foreach($languages as $language)--}}
{{--                                            <option data-select2-id="46" value="{{$language->id}}" >{{$language->name}}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <!-- /.card-body -->--}}

{{--                            <div class="card-footer">--}}
{{--                                <button type="submit" class="btn btn-primary">Добавить</button>--}}
{{--                            </div>--}}
{{--                        </form>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div><!-- /.container-fluid -->--}}
{{--    </section>--}}
        @else
            @include('layouts.lock_layout')
        @endif
    @else
        @include('layouts.lock_layout')
    @endif
    <!-- /.content -->
@endsection
