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
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body p-0">
                    <form action="{{ route('baseSetUser') }}" method="POST">
                        @csrf
                        @method('POST')
                        <div style="margin-top: 1rem; margin-bottom: 1rem">
                            <h4 style="text-align: center">
                                Назначить на пользователя
                            </h4>
                            <select class="form-control select2 select2-hidden-accessible" name="user" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true" required>
                                <option selected="selected" data-select2-id="3"></option>
                                @foreach($userList as $user)
                                    <option value="{{$user->id}}" >{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>

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
                            <th>
                                Назначено на пользователя
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
                                    <td>
                                        {{ $post['toUser'] }}
                                    </td>
                                    <td class="project-actions text-right">
                                        <div class="form-check" @if($post['toUser'] === 'Не назначено')>
                                            <input class="form-check-input" type="checkbox" value="{{$post['id']}}" name="post[]" id="flexCheckDefault">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Выбрать запись {{$post['id_client']}}
                                            </label>
                                        </div @endif>
                                    </td>
                                </tr>
                            @empty
                                <div class="alert alert-warning" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×
                                    </button>
                                    <h4><i class="icon fa fa-exclamation-triangle"></i>Записи отсутствуют!</h4>
                                </div>
                            @endforelse
                        </tbody>
                    </table>
                        <div class="row">

                            <div class="col-sm-12 col-md-7" style="margin-top: 1rem;">
                                <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                                    <ul class="pagination">
                                        {{ $baseList->links()}}
                                    </ul>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success btn-sm" style="height: 35px;margin-top: 1rem;padding-right: 20px; padding-left: 20px">
                                <i class="fas fa-calendar-check">
                                </i>
                                Отправить
                            </button>
                        </div>

                    </form>

                </div>
                <!-- /.card-body -->
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
