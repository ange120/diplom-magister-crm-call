@extends('layouts.admin_layout')

@section('title', 'Редагування Trunk')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Редагування trunk: {{$trunk->login }}</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-check"></i>{{ session('success') }}</h4>
                </div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-ban"></i>{{ session('error') }}</h4>
                </div>
            @endif
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary">
                        <!-- form start -->
                        <form action="{{ route('trunk_by_admin.update', $trunk->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            @if(isset($message))
                                <div class="alert alert-danger">{{ $message }}</div>
                            @endif

                            <div class="card-body">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputName">SIP сервер</label>
                                        <input type="text" name="sip_server" class="form-control" id="exampleInputName" value="{{$trunk->sip_server}}" placeholder="SIP сервер" required >
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">Логін</label>
                                        <input type="text" name="login" class="form-control"  value="{{$trunk->login}}" id="exampleInputName" placeholder="Логін" required >
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Пароль</label>
                                        <input type="text" name="password" class="form-control" id="exampleInputPassword1" value="{{$trunk->password}}" placeholder="Пароль" required >
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword2">Підтвердження  пароля</label>
                                        <input type="password" name="confirm_password" class="form-control" id="exampleInputPassword2" placeholder="Підтвердження  пароля" required >
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Обновить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
