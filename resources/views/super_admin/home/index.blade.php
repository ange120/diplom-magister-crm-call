@extends('layouts.admin_layout')

@section('title', 'Главная')

@section('content')


    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Главная</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{$user_count}}</h3>

                            <p>Пользователей</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person"></i>
                        </div>
                        <a href="{{route('users.index')}}" class="small-box-footer">Все Пользователи <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{$base_count}}</h3>

                            <p>Записей</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{route('base_info.index')}}"  class="small-box-footer">Все Записи <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{$snip_count}}</h3>

                            <p>SNIP</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-unlocked"></i>
                        </div>
                        <a href="{{route('base_info.index')}}"  class="small-box-footer">Все SNIP <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{$voice_count}}</h3>

                            <p>Голосов</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-mic-c"></i>
                        </div>
                        <a href="{{route('voice_by_admin.index')}}"  class="small-box-footer">Все Записи голосов <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>


            </div>
            <!-- /.row -->
            <!-- Main row -->






            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
