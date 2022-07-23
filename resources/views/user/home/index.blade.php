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
                                        <select class="form-control select2 select2-hidden-accessible" name="status" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true" required>
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
                                        <a class="btn btn-info btn-sm coll-btn" href="{{ route('callUser', $post['id']) }}">
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
