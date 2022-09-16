@extends('layouts.admin_layout')

@section('title', 'Добавить запись')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
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
        <div class="col-sm-6">
            <h1 class="m-0">Загрузить записи</h1>
        </div><!-- /.col -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary">
                        <!-- form start -->
                        <form action="{{ route('base_info.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleFormControlFile1">Выберите файл</label>
                                    <input type="file" name="file" class="form-control-file"
                                           id="exampleFormControlFile1" required>
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-info btn-sm coll-btn" data-toggle="modal"
                                            data-target="#exampleModal"
                                    >
                                        <i class="icon fa solid fa-question"></i>
                                        Информация о структуре файла
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">Загрузить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="col-sm-6">
            <h1 class="m-0">Загрузить записи на пользователя</h1>
        </div><!-- /.col -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary">
                        <!-- form start -->
                        <form action="{{ route('baseCreateToUser') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleFormControlFile1">Выберите файл</label>
                                    <input type="file" name="file" class="form-control-file"
                                           id="exampleFormControlFile1" required>
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-info btn-sm coll-btn" data-toggle="modal"
                                            data-target="#exampleModal">
                                        <i class="icon fa solid fa-question"></i>
                                        Информация о структуре файла
                                    </button>
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlFile1">Пользователь</label>
                                    <select class="form-control select2 select2-hidden-accessible" name="user"
                                            data-select2-id="1" tabindex="-1" aria-hidden="true" required>
                                        <option selected="selected" data-select2-id="3"></option>
                                        @foreach($userList as $user)
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">Загрузить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="col-sm-6">
            <h1 class="m-0">Загрузить одну запись</h1>
        </div><!-- /.col -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary">
                        <!-- form start -->
                        <form action="{{ route('baseCreateOnly') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputNameID">ID клиента</label>
                                    <input type="number" name="id_client" class="form-control" id="exampleInputNameID"
                                           placeholder="ID клиента" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputName">Номер телефона</label>
                                    <input type="number" name="phone" class="form-control" id="exampleInputName"
                                           placeholder="Номер телефона" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Поле 1</label>
                                    <input type="text" name="field_1" class="form-control" id="exampleInputEmail1"
                                           placeholder="Поле 1">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Поле 2</label>
                                    <input type="text" name="field_2" class="form-control" id="exampleInputEmail1"
                                           placeholder="Поле 2">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Поле 3</label>
                                    <input type="text" name="field_3" class="form-control" id="exampleInputEmail1"
                                           placeholder="Поле 3">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Поле 4</label>
                                    <input type="text" name="field_4" class="form-control" id="exampleInputEmail1"
                                           placeholder="Поле 4">
                                </div>
{{--                                <div class="form-group">--}}
{{--                                    <label for="exampleInputPassword1">Менеджер</label>--}}
{{--                                    <input type="text" name="manager" class="form-control" id="exampleInputPassword1"--}}
{{--                                           placeholder="Менеджер">--}}
{{--                                </div>--}}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Статус</label>

                                    <select class="form-control select2 select2-hidden-accessible" name="status"
                                            style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true"
                                            required>
                                        <option selected="selected" data-select2-id="3"></option>
                                        @foreach($selectStatus as $role)
                                            <option value="{{$role->id}}">{{$role->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword2">Комментарий</label>
                                    <input type="text" name="commit" class="form-control" id="exampleInputPassword2"
                                           placeholder="Комментарий">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword2">ФИО</label>
                                    <input type="text" name="user_info" class="form-control" id="exampleInputPassword2"
                                           placeholder="ФИО">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword2">Стран</label>
                                    <input type="text" name="country" class="form-control" id="exampleInputPassword2"
                                           placeholder="Стран">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword2">Город</label>
                                    <input type="text" name="city" class="form-control" id="exampleInputPassword2"
                                           placeholder="Город">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword2">Пол</label>
                                    <input type="text" name="sex" class="form-control" id="exampleInputPassword2"
                                           placeholder="Пол">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword2">Дата рождения</label>
                                    <input type="date" name="birthday" class="form-control" id="exampleInputPassword2"
                                           placeholder="Дата рождения">
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">Добавить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Bootstrap 4 -->

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-center" id="exampleModalLabel">Информация для загрузки файла</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <h5>1. Убрать шапку для полей пример на скриншоте</h5>
                        <div class="text-center">
                            <img src="/files/testFile.png" style="width: 100%" class="rounded">
                        </div>
                        <h5>2. Обязательно соблюдать последовательность полей</h5>
                        <ul>
                            <li>ID клиента</li>
                            <li>Номер телефона</li>
                            <li>Поле 1</li>
                            <li>Поле 2</li>
                            <li>Поле 3</li>
                            <li>Поле 4</li>
                            <li>Менеджер</li>
                            <li>Статус</li>
                            <li>Комментарий</li>
                            <li>empty_1</li>
                            <li>empty_2</li>
                        </ul>
                        <h5>3. Проверить в поле статус и сравнить со статусами в crm. Если есть недостающие
                            добавить.</h5>


                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                </div>

            </div>
        </div>
    </div>
@endsection
