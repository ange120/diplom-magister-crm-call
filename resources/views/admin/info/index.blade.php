@extends('layouts.admin_layout')

@section('title', 'Все записи')

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
                <div class="alert alert-success" role="alert">
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
                        <div class="col-3" style="padding-top: 2%;">
                            <div class="form-group">
                                <label for="exampleInputName">Голос</label>
                                <select id="select_voice" class="form-control select2 select2-hidden-accessible"
                                        name="language" style="width: 100%;" data-select2-id="1" tabindex="-1"
                                        aria-hidden="true" required>
                                    @foreach($voice as $value)
                                        <option value="{{$value->id}}">{{$value->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-9" style="padding-top: 2%;">
                            <form id="filterForm" class="form-row" action="{{ route('callManyUserAdmin') }}" onsubmit="return setVoice()" method="POST">
                                @csrf
                                <input id="set_value_language" name="language" style="display: none">
                                <div class="col-2">
                                    <label for="in_form_count_start">Отобрать от:</label>
                                    <input type="number" min="1"  name="count_start" class="form-control"
                                           id="in_form_count_start" placeholder="ID записи" required>
                                </div>
                                <div class="col-2">
                                    <label for="in_form_count_end">Отобрать до:</label>
                                    <input type="number" min="1" name="count_end" class="form-control"
                                           id="in_form_count_end" placeholder="ID записи">
                                </div>
                                <div class="col " style=" display: flex;align-items: flex-end; margin-bottom: 0.7%;">
                                    <button type="submit" class="btn btn-info btn-sm" style="margin-left: 1%; margin-right: 1%;">
                                        <i class="fas fa-phone">
                                        </i>
                                        Сделать звонок на пользователей
                                    </button>
                                    <button type="button" onclick="deleteUsers()" class="btn btn-danger btn-sm"  style="margin-left: 1%; margin-right: 1%;">
                                        <i class="fas fa-phone">
                                        </i>
                                        Удалить выбранных пользователей
                                    </button>
                                </div>

                            </form>
                        </div>
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
                            </th>
                        </tr>
                        </thead>
                        <tbody>

                        @forelse($result as $post)
                            <tr>
                                <td>
                                    {{ $post['id_client']}}
                                </td>
                                <td>
                                    {{ $post['phone'] }}
                                </td>
                                <td>
                                    {{ $post['status'] }}
                                </td>
                                <td>
                                    {{ $post['user_info'] }}
                                </td>

                                <td class="project-actions text-right">
                                    <a class="btn btn-info btn-sm" onclick="adminCall( {{$post['id']}})">
                                        <i class="fas fa-phone">
                                        </i>
                                        Звонок
                                    </a>
                                    <a class="btn btn-warning btn-sm" href="{{ route('base_info.edit', $post['id']) }}">
                                        <i class="fas fa-pencil-alt">
                                        </i>
                                        Редактировать
                                    </a>
                                    <form action="{{ route('base_info.destroy', $post['id']) }}" method="POST"
                                          style="display: inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm delete-btn">
                                            <i class="fas fa-trash">
                                            </i>
                                            Удалить
                                        </button>
                                    </form>
                                </td>
                            </tr>
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
