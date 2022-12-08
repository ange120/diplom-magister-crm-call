@extends('layouts.admin_layout')

@section('title', 'Всі користувачі')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Всі користувачі</h1>
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
            <div class="card">
                <div class="card-body p-0">
                    <table class="table table-striped projects">
                        <thead>
                            <tr>
                                <th style="width: 5%">
                                    ID
                                </th>
                                <th>
                                    Ім'я
                                </th>
                                <th>
                                    Email
                                </th>
                                <th>
                                    Номер менеджера
                                </th>
                                <th>
                                    Роль
                                </th>
                                <th>
                                    Підписка
                                </th>
                                <th>
                                    Дата створення акаунту
                                </th>
                                <th>
                                    Дата оновлення акаунту
                                </th>
                                <th style="width: 30%">
                                    Дії
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($result as $user)
                                <tr>
                                    <td>
                                        {{ $user['id'] }}
                                    </td>
                                    <td>
                                        {{ $user['name'] }}
                                    </td>
                                    <td>
                                        {{ $user['email'] }}
                                    </td>
                                    <td>
                                        {{ $user['phone_manager'] }}
                                    </td>
                                    <td>
                                        {{ $user['role'] }}
                                    </td>
                                    <td>
                                        {{ $user['subscriptions'] }}
                                    </td>
                                    <td>
                                        {{ $user['created_at'] }}
                                    </td>
                                    <td>
                                        {{ $user['updated_at'] }}
                                    </td>
                                    <td class="project-actions text-right">
                                        <a class="btn btn-info btn-sm" href="{{ route('users.edit', $user['id']) }}">
                                            <i class="fas fa-pencil-alt">
                                            </i>
                                            Редагувати
                                        </a>
                                        <form action="{{ route('users.destroy', $user['id']) }}" method="POST"
                                            style="display: inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm delete-btn">
                                                <i class="fas fa-trash">
                                                </i>
                                                Видалити
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach


                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
