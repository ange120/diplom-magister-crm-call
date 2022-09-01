@extends('layouts.user_layout')

@section('title', 'Все статьи')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Все записи</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
            @if (session('success'))
                <div class="alert alert-success" id="AlertSuccess" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-check"></i>{{ session('success') }}</h4>
                </div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-danger" id="AlertError" role="alert">
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
            <div class="card">
                <div class="container">
                    <div class="row">
                        <div class="col-sm" style="padding-top: 2%;">
                            <div class="form-group">
                                <label for="exampleInputName"><h4>SNIP</h4></label>
                                <select id="select_snip" class="form-control select2 select2-hidden-accessible" name="language" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true" required>
                                    @foreach($snip as $item)
                                        <option value="{{$item->id}}">{{$item->ip_snip}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @if(session('subscriptionId') !== 1)
                            @if(session('endSubscription') === true)
                                <div class="col-sm"  style="padding-top: 2%;">
                                    <div class="form-group">
                                        <label for="exampleInputName"><h4>Голос</h4></label>
                                        <select id="select_voice" class="form-control select2 select2-hidden-accessible" name="language" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true" required>
                                            @foreach($voice as $value)
                                                <option value="{{$value->id}}" >{{$value->name}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body p-0">
                    <table class="table table-striped projects">
                        <thead>
                        <tr>
                            <th style="width: 5%">
                                ID
                            </th>
                            <th>
                                Номер телефна
                            </th>
                            <th>
                                Статус
                            </th>
                            <th>
                                ФИО
                            </th>
                            <th style="width: 30%">
                                Действия
                            </th>
                        </tr>
                        </thead>
                            <tbody>
                            @forelse($result as $post)
                                <form action="{{ route('updateStatus') }}" method="POST">
                                    @csrf
                                    @method('POST')
                                <tr>
                                    <td>
                                        {{ $post['id_client']}}
                                    </td>
                                    <td>
                                        {{ $post['phone'] }}
                                    </td>
                                    <td>
                                        <select disabled class="form-control select2 select2-hidden-accessible" name="status" style="width: 100%;" id="selected_{{$post['id']}}" data-select2-id="1" tabindex="-1" aria-hidden="true" required>
                                            <option selected="selected" data-select2-id="3"></option>
                                            @foreach($listStatus as $status)
                                                <option  @if($status == $post['status']) selected @endif>{{$status}}</option>
                                            @endforeach
                                        </select>
                                        <input name="idUser" value="{{$post['id']}}" hidden>
                                    </td>
                                    <td>
                                        {{ $post['user_info'] }}
                                    </td>
                                    <td class="project-actions text-right">
                                        <a class="btn btn-info btn-sm coll-btn" onclick="getSelected( {{$post['id']}})">
                                            <i class="fas fa-phone">
                                            </i>
                                            Звонок
                                        </a>
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="fas fa-check">
                                            </i>
                                            Подтвердить звонок
                                        </button>
                                    </td>
                                </tr>
                                </form>
                            @empty
                                <div class="alert alert-warning" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h4><i class="icon fa fa-exclamation-triangle"></i>Записи отсутствуют!</h4>
                                </div>
                            @endforelse

                            </tbody>
                    </table>
                    <div class="col-sm-12 col-md-7" style="margin-top: 1rem;">
                        <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">

                            <ul class="pagination">
                                {{ $baseList->links()}}
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
