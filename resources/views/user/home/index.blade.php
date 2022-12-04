@extends('layouts.user_layout')

@section('title', $pageListKeyLanguage['title_label'])

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{$pageListKeyLanguage['title_label']}}</h1>
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
            @if ($infoSubscription === false)
                <div class="alert alert-danger" id="AlertError" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-ban"></i>Будь ласка, встановіть підписку для цього користувача.</h4>
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
                        <div class="col-4" style="padding-top: 2%;">
                            <div class="form-group">
                                <label for="exampleInputName">{{$pageListKeyLanguage['label_voice']}}</label>
                                <select id="select_voice" class="form-control select2 select2-hidden-accessible"
                                        name="language" style="width: 100%;" data-select2-id="1" tabindex="-1"
                                        aria-hidden="true" required>
                                    @foreach($voice as $value)
                                        <option value="{{$value->id}}">{{$value->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-8" style="padding-top: 2%;" id="data-a">
                            <form class="form-row" action="{{ route('callManyUser') }}" onsubmit="return setVoice()" method="POST">
                                @csrf
                                <input id="set_value_language" name="language" style="display: none">
                                <div class="col-3">
                                    <label for="exampleInputName">{{$pageListKeyLanguage['label_count_start']}}:</label>
                                    <input type="number" min="1"  name="count_start" class="form-control"
                                           id="exampleInputName" placeholder="ID записи" required>
                                </div>
                                <div class="col-3">
                                    <label for="exampleInputName">{{$pageListKeyLanguage['label_count_end']}}:</label>
                                    <input type="number" min="0" max="" name="count_end" class="form-control"
                                           id="exampleInputName" placeholder="ID записи">
                                </div>
                                <div class="col-3">
                                    <label for="statuslist">{{$pageListKeyLanguage['label_status']}}:</label>
                                    <select class="form-control select2 "
                                                name="status" style="width: 100%;" id="statuslist"
                                                 tabindex="-1">
                                            <option selected="selected" value="0">{{$pageListKeyLanguage['label_select_status']}}</option>
                                            @foreach($allStatus as $status)
                                                <option
                                                value="{{$status->id}}">{{$status->name}}</option>
                                            @endforeach
                                        </select>
                                </div>
                                <div class="col " style=" display: flex;align-items: flex-end; margin-bottom: 0.7%;">
                                    <button type="submit" class="btn btn-info btn-sm">
                                        <i class="fas fa-phone">
                                        </i>
                                        {{$pageListKeyLanguage['label_call']}}
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
                    <table class="table table-striped projects" id="baseinfotable">
                        <thead>
                        <tr>
                            <th style="width: 5%">
                                ID
                            </th>
                            <th>
                                {{$pageListKeyLanguage['table_phone']}}
                            </th>
                            <th>
                                {{$pageListKeyLanguage['table_status']}}
                            </th>
                            <th>
                                {{$pageListKeyLanguage['table_user']}}
                            </th>
                            <th style="width: 30%">
                                {{$pageListKeyLanguage['table_label_btn']}}
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
                                        <select disabled class="form-control select2 select2-hidden-accessible"
                                                name="status" style="width: 100%;" id="selected_{{$post['id']}}"
                                                data-select2-id="1" tabindex="-1" aria-hidden="true" required>
                                            <option selected="selected" data-select2-id="3"></option>
                                            @foreach($listStatus as $status)
                                                <option
                                                    @if($status == $post['status']) selected @endif>{{$status}}</option>
                                            @endforeach
                                        </select>
                                        <input name="idUser" value="{{$post['id']}}" hidden>
                                    </td>
                                    <td>
                                        {{ $post['user_info'] }}
                                    </td>
                                    <td class="project-actions text-right">
                                        <a class="btn btn-warning btn-sm coll-btn" onclick="updateStatus( {{$post['id']}})">
                                            {{$pageListKeyLanguage['btn_update_status']}}
                                        </a>
                                        <a class="btn btn-info btn-sm coll-btn" onclick="getSelected( {{$post['id']}})">
                                            <i class="fas fa-phone">
                                            </i>
                                            {{$pageListKeyLanguage['btn_call']}}
                                        </a>
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="fas fa-check">
                                            </i>
                                            {{$pageListKeyLanguage['btn_save_status']}}
                                        </button>
                                    </td>
                                </tr>
                            </form>
                        @empty
                            <div class="alert alert-warning" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h4><i class="icon fa fa-exclamation-triangle"></i>{{$pageListKeyLanguage['label_not_have_record']}}}!</h4>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>

