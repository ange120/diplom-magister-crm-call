@extends('layouts.user_layout')

@section('title', 'Все записи голосов')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Все записи голосов</h1>
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
                                Имя записи
                            </th>
                            <th>
                                Текс записи
                            </th>
                            <th>
                                Язык записи
                            </th>
                            <th style="width: 30%">
                                Действия
                            </th>
                        </tr>
                        </thead>
                        <tbody>

                        @forelse($result as $post)
                            <tr>
                                <td>
                                    {{ $post['id']}}
                                </td>
                                <td>
                                    {{ $post['name'] }}
                                </td>
                                <td>
                                    {{ $post['text'] }}
                                </td>
                                <td>
                                    {{ $post['language'] }}
                                </td>
                                @if(session('subscriptionId') !== 1)
                                    @if(session('endSubscription') === true)
                                <td class="project-actions text-right">
                                    <a class="btn btn-warning btn-sm" href="{{ route('voice_by_user.edit', $post['id']) }}">
                                        <i class="fas fa-pencil-alt">
                                        </i>
                                        Редактировать
                                    </a>

                                    <form action="{{ route('voice_by_user.destroy',$post['id']) }}" method="POST"
                                          style="display: inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm delete-btn">
                                            <i class="fas fa-trash">
                                            </i>
                                            Удалить
                                        </button>
                                    </form>
                                        @else

                                        @endif
                                    @else

                                    @endif
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
                                {{ $voiceRecordList->links()}}
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
