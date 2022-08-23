@extends('layouts.admin_layout')

@section('title', 'Редактирование подписки для пользователя')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Редактирование подписки для пользователя: {{$userName}}</h1>
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
                        <form action="{{ route('updateSubscriptionUser', $subscriptionUser->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputName">Имя пользователя</label>
                                        <input type="text" name="name" class="form-control" id="exampleInputName" value="{{$userName}}" disabled >
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputName">Подписка</label>
                                        <select id="select_snip" class="form-control select2 select2-hidden-accessible" name="id_subscription" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true" required>
                                            @foreach($subscriptionList as $item)
                                                <option  value="{{$item->id}}" @if($item->id == $subscriptionUser->id_subscription) selected @endif> {{$item->info_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputName">Дата начала подписки</label>
                                        <input class="date form-control" name="date_start_subscriptions" value="{{$subscriptionUser->date_start_subscriptions}}" type="text">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputName">Дата окончания подписки</label>
                                        <input  class="date form-control"name="date_end_subscriptions"  value="{{$subscriptionUser->date_end_subscriptions}}">                                    </div>
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

    <script type="text/javascript">
        $('.date').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
        });
    </script>
    <!-- /.content -->
@endsection
