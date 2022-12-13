@extends('layouts.admin_layout')

@section('title', 'Всі SIP')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Список перекладів</h1>
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
            @if(isset($deleteConfigSnip))
                <div class="alert alert-danger">{{ $deleteConfigSnip }}</div>
            @endif
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary">
                        <!-- form start -->
                        <form action="{{ route('localizationAdminTable') }}" method="POST">
                            @csrf
                            @method('GET')
                            <div class="form-group">
                                <label for="exampleInputEmail1">  Сторінка</label>
                                <select id="userList" class="form-control select2 select2-hidden-accessible"
                                        name="page" style="width: 100%;" data-select2-id="1" tabindex="-1"
                                        aria-hidden="true" required>
                                    <option selected="selected" data-select2-id="3"></option>
                                    @foreach($BindPages as $item)
                                        <option value="{{$item->id}}" >{{$item->name_page}} url({{$item->url_page}})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Показати дані</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>


    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body p-0">
                    @foreach($result as$key=>$table)
                    <table class="table table-striped projects">
                        <thead>
                        <tr>
                            <th>
                                Мова
                            </th>
                            <th>
                               Ключ
                            </th>
                            <th>
                                Переклад
                            </th>
                            <th style="width: 30%">
                                Дії
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($table as $post)
                            <form action="{{ route('localizationAdminTableUpdate') }}" method="POST">
                                @csrf
                                @method('PUT')
                            <tr>
                                <td>
                                    {{$key}}
                                </td>
                                <td>
                                    {{ $post['keys_pages']}}
                                </td>
                                <td>
                                    <input name="text" value="{{ $post['text'] }}">
                                </td>
                                <td class="project-actions text-right">
                                    <input name="id" value="{{$post['id']}}" hidden>
                                    <button type="submit" class="btn btn-warning btn-sm">
                                        <i class="fas fa-pencil-alt">
                                        </i>
                                        Зберегти
                                    </button>
{{--                                    <a class="btn btn-warning btn-sm" >--}}
{{--                                        <i class="fas fa-pencil-alt">--}}
{{--                                        </i>--}}
{{--                                        Зберегти--}}
{{--                                    </a>--}}
                                </td>
                            </tr>
                            </form>
                        @empty
{{--                            <div class="alert alert-warning" role="alert">--}}
{{--                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>--}}
{{--                                <h4><i class="icon fa fa-exclamation-triangle"></i>Записи відсутні!</h4>--}}
{{--                            </div>--}}
                        @endforelse

                        </tbody>
                    </table>
                    @endforeach
                </div>
                <!-- /.card-body -->
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
