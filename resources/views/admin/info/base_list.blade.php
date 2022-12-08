@extends('layouts.admin_layout')

@section('title', 'Всі записи')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Всі записи</h1>
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
                                Призначити на користувача
                            </h4>
                            <select class="form-control select2 select2-hidden-accessible" name="user" style="width: 100%;-webkit-box-shadow: 0px 2px 9px 1px rgba(15, 255, 0, 0.2);-moz-box-shadow: 0px 2px 9px 1px rgba(15, 255, 0, 0.2);box-shadow: 0px 2px 9px 1px rgba(15, 255, 0, 0.2);" data-select2-id="1" tabindex="-1" aria-hidden="true" required>
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
                                ФІО
                            </th>
                            <th>
                                Призначено на користувача
                            </th>
                            <th style="width: 30%">
                                Дії
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
                                        @if($post['toUser'] === 'Не назначено')
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="{{$post['id']}}" name="post[]" id="flexCheckDefault">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Вібрати запис {{$post['id_client']}}
                                            </label>
                                        </div>
                                        @else
                                            <button type="button" class="btn btn-warning btn-sm coll-btn" data-toggle="modal" data-target="#exampleModal"
                                                    onclick="getId( {{$post['id']}},{{$post['id_client']}})"> <i class="icon fa fa-solid fa-pen"></i>
                                                Оновити менеджера</button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <div class="alert alert-warning" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×
                                    </button>
                                    <h4><i class="icon fa fa-exclamation-triangle"></i>Записи відсутні!</h4>
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
                                Відправити
                            </button>
                        </div>

                    </form>

                </div>
                <!-- /.card-body -->
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Bootstrap 4 -->

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-center" id="exampleModalLabel">Обновить запись для пользователя</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('baseUpdateUser') }}" method="POST">
                    @csrf
                    @method('POST')
                <div class="modal-body">

                        <div class="form-group">
                            <label for="idRow" class="form-control-label">Запис:</label>
                            <input type="text" name="id" class="form-control" id="idRow" style="display: none">
                            <input type="text" class="form-control" id="idShow" readonly>
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="form-control-label">Користувач:</label>
                            <select class="form-control select2 select2-hidden-accessible" name="user"  data-select2-id="1" tabindex="-1" aria-hidden="true" required>
                                <option selected="selected" data-select2-id="3"></option>
                                @foreach($userList as $user)
                                    <option value="{{$user->id}}" >{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрити</button>
                    <button type="submit" class="btn btn-primary">Оновити</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function getId(idRow,idShow){
            $('#idRow').val(idRow)
            $('#idShow').val(idShow)
        }
    </script>
    <!-- /.content -->
@endsection
