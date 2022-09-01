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
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputId">#</label>
                                    <input type="text" name="id" class="form-control" value="{{$infoSnip->id}}" id="exampleInputId"  readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1"> Имя менеджера</label>
                                    <input type="text" name="name_provider" class="form-control" value="{{$infoSnip->name_provider}}" id="exampleInputEmail1" placeholder="Имя провайдера" required >
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1"> Номер авторизации</label>
                                    <input type="text" name="number_provider" class="form-control" value="{{$infoSnip->number_provider}}" id="exampleInputEmail1" placeholder="Номер авторизации" required >
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
