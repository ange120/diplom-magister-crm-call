@extends('layouts.admin_layout')

@section('title', 'Створити SIP')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Створити SIP</h1>
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
                        <form action="{{ route('snip_by_admin.store') }}" method="POST">
                            @csrf
                            @if(isset($updateConfig) )
                                <div class="alert alert-danger">{{ $updateConfig }}</div>
                            @endif
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1"> Ім'я менеджера</label>
                                    <select onchange="getPhone()" id="userList" class="form-control select2 select2-hidden-accessible" name="name_provider" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true"required >
                                        <option selected="selected" data-select2-id="3"></option>
                                        @foreach($userList as $user)
                                            <option value="{{$user->phone_manager}}" >{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="userPhone"> Номер авторизації</label>
                                    <input type="text" id="userPhone" name="number_provider" class="form-control"  placeholder="Номер авторизації" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Trunk</label>
                                    <select  class="form-control select2 select2-hidden-accessible" name="id_trunk" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true" required>
                                        <option selected="selected" data-select2-id="3"></option>
                                        @foreach($trunkList as $trunk)
                                            <option value="{{$trunk->id}}" >{{$trunk->login}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1"> Назва аккаунту</label>
                                    <input type="text" name="login_snip" class="form-control" id="exampleInputEmail1" placeholder="Назва аккаунту" required >
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1"> Пароль аккаунту</label>
                                    <input type="password" name="password_snip" class="form-control" id="exampleInputEmail1" placeholder="Пароль аккаунту" required >
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
    <script>
        function getPhone(){
            $("#userPhone").val($("#userList").val())
        }

    </script>
    <!-- /.content -->
@endsection
