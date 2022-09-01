@extends('layouts.user_layout')

@section('title', 'Добавить trunk')

@section('content')
    @if(session('subscriptionId') !== 1)
        @if(session('endSubscription') === true)
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Добавить trunk</h1>
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
                        <form action="{{ route('trunk_by_user.store') }}" method="POST">
                            @csrf
                            @if(isset($message))
                                <div class="alert alert-danger">{{ $message }}</div>
                            @endif
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputName">Sip сервер</label>
                                    <input type="text" name="sip_server" class="form-control" id="exampleInputName" placeholder="Sip сервер" required >
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Логин</label>
                                    <input type="text" name="login" class="form-control" id="exampleInputName" placeholder="Логин" required >
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Пароль</label>
                                    <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Пароль" required >
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword2">Подтверждение  Пароля</label>
                                    <input type="password" name="confirm_password" class="form-control" id="exampleInputPassword2" placeholder="Подтверждение Пароля" required >
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Добавить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
        @else
            @include('layouts.lock_layout')
        @endif
    @else
        @include('layouts.lock_layout')
    @endif
    <!-- /.content -->
@endsection
