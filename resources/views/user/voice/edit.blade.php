@extends('layouts.user_layout')

@section('title', 'Редактирование записи голоса')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Редактирование запись голоса: {{$voiceRecord->name }}</h1>
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
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary">
                        <!-- form start -->
                        <form action="{{ route('voice_by_user.update', $voiceRecord->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputName">Имя записи</label>
                                        <input type="text" name="name" class="form-control" id="exampleInputName" value="{{$voiceRecord->name}}" placeholder="Имя записи" required >
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">Текс записи</label>
                                        <textarea class="form-control" name="text" id="exampleFormControlTextarea1" rows="3"> value="{{$voiceRecord->text}}"</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Язык записи</label>

                                        <select class="form-control select2 select2-hidden-accessible" name="language" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true" required>
                                            <option selected="selected" data-select2-id="3"></option>
                                            @foreach($languages as $language)
                                                <option value="{{$language->id}}"  @if($language->id === $voiceRecord->id_language) selected @endif>{{$language->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Обновить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
