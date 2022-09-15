@extends('layouts.user_layout')

@section('title', 'Редактирование SNIP')

@section('content')
    @if(session('subscriptionId') !== 1)
        @if(session('endSubscription') === true)
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Редактирование SNIP: {{$infoSnip->login_snip }}</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-check"></i>{{ session('success') }}</h4>
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
                        <form action="{{ route('snip_by_user.update', $infoSnip->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            @if(isset($updateConfigSnip))
                                <div class="alert alert-danger">{{ $updateConfigSnip }}</div>
                            @endif
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputId">#</label>
                                    <input type="text" name="id" class="form-control" value="{{$infoSnip->id}}" id="exampleInputId"  readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1"> Имя менеджера</label>
                                    <select onchange="getPhone()" id="userList" class="form-control select2 select2-hidden-accessible" name="name_provider" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true" >
                                        <option selected="selected" data-select2-id="3"></option>
                                        @foreach($userList as $user)
                                            <option value="{{$user->phone_manager}}" @if($user->phone_manager == $infoSnip->name_provider) selected @endif>{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="userPhone"> Номер авторизации</label>
                                    <input type="text" id="userPhone" name="number_provider" class="form-control" value="{{$infoSnip->name_provider}}"  placeholder="Номер авторизации" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Trunk</label>
                                    <select  class="form-control select2 select2-hidden-accessible" name="id_trunk" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true" >
                                        <option selected="selected" data-select2-id="3"></option>
                                        @foreach($trunkList as $trunk)
                                            <option value="{{$trunk->id}}"  @if($trunk->id == $infoSnip->id_trunk) selected @endif>{{$trunk->login}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1"> Назва аккаунту</label>
                                    <input type="text" name="login_snip" class="form-control" value="{{$infoSnip->login_snip}}" id="exampleInputEmail1" placeholder="Назва аккаунту" required >
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1"> Пароль аккаунту</label>
                                    <input type="password" name="password_snip" class="form-control" value="{{$infoSnip->password_snip}}" id="exampleInputEmail1" placeholder="Пароль аккаунту" required >
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
        @else
            @include('layouts.lock_layout')
        @endif
    @else
        @include('layouts.lock_layout')
    @endif
    <!-- /.content -->
@endsection
