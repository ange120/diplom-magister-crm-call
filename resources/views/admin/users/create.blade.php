@extends('layouts.admin_layout')

@section('title', 'Створити користувача')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Створити користувача</h1>
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
            @if(isset($message))
                <div class="alert alert-danger">{{ $message }}</div>
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
                        <form action="{{ route('users.store') }}" method="POST">
                            @csrf
                            @if(isset($errorInfo))
                                <div class="alert alert-danger">{{ $errorInfo }}</div>
                            @endif
                            @error('name', 'email','password','confirm_password')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputName">Ім'я користувача</label>
                                    <input type="text" name="name" class="form-control" id="exampleInputName" placeholder="Ім'я користувача" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email</label>
                                    <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Email"  required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Пароль</label>
                                    <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Пароль" required >
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword2">Підтвердження пароля</label>
                                    <input type="password" name="confirm_password" class="form-control" id="exampleInputPassword2" placeholder="Підтвердження пароля" required >
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputName">Номер менеджера</label>
                                    <input type="number" name="phone_manager" class="form-control" id="exampleInputName" placeholder="Номер менеджера" required >
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Роль</label>
                                    <select class="form-control select2 select2-hidden-accessible" name="role" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true" >
                                        <option selected="selected" data-select2-id="3"></option>
                                        @foreach($roles as $role)
                                            <option data-select2-id="46">{{$role}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Створити</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
