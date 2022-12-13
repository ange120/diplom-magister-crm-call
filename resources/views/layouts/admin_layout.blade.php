<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Панель адміністратора - @yield('title')</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/admin/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="/admin/plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/admin/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="/admin/plugins/daterangepicker/daterangepicker.css">
    <link href="/admin/dist/css/colorbox.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#">
                        <i class="fas fa-bars"></i>
                        <span class="sr-only">Toggle navigation</span>
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item dropdown user-menu">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <span>{{ Auth::user()->name }}</span>
                    </a>
                <li class="user-footer">
                    <a class="btn btn-default btn-flat float-right  btn-block " href="{{route('getSettingsPage')}}">
                        <i class="fa fa-cogs" aria-hidden="true"></i>
                        Налаштування
                    </a>
                </li>
                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
                        <li class="user-footer">
                            <a class="btn btn-default btn-flat float-right  btn-block " href="#"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa fa-fw fa-power-off"></i>
                                Вихід
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="GET" style="display: none;"></form>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a class="brand-link" href="{{ route('homeAdmin') }}">
                <img src="/admin/dist/img/AdminLTELogo.png" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Панель-адмін.</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

                        <li class="nav-item">
                            <a href="{{ route('homeAdmin') }}" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Головна сторінка
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon far fa-newspaper"></i>
                                <p>
                                    Записи
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('base_info.index')}}" class="nav-link">
                                        <p>Всі Записи</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('baseList')}}" class="nav-link">
                                        <p>Призначити на користувача</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('base_info.create')}}" class="nav-link">
                                        <p>Додати записи</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                     Користувачі
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('users.index')}}" class="nav-link">
                                        <p>Всі користувачі</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('users.create')}}" class="nav-link">
                                        <p>Додати користувача</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-tags"></i>
                                <p>
                                    Підписка
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('subscriptions_user.index')}}" class="nav-link">
                                        <p>Всі підписки</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('subscriptionAllUsers')}}" class="nav-link">
                                        <p>Призначити підписку</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-book"></i>
                                <p>
                                    Статуси
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('status.index')}}" class="nav-link">
                                        <p>Всі статуси</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('status.create')}}" class="nav-link">
                                        <p>Додати статус</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon far fa-id-card"></i>
                                <p>
                                    SIP
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('snip_by_admin.index')}}" class="nav-link">
                                        <p>Всі SIP</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('snip_by_admin.create')}}" class="nav-link">
                                        <p>Додати SIP</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-microphone"></i>
                                <p>
                                    Записи Голосів
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('voice_by_admin.index')}}" class="nav-link">
                                        <p>Всі записи голосів</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('voice_by_admin.create')}}" class="nav-link">
                                        <p>Додати записи голосів</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>
                                    Trunk
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('trunk_by_admin.index')}}" class="nav-link">
                                        <p>Всі trunks</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('trunk_by_admin.create')}}" class="nav-link">
                                        <p>Добавити trunks</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-regular fa-globe"></i>
                                <p>
                                    Налаштування мови
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('localizationAdmin')}}" class="nav-link">
                                        <p>Список сторінок</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('trunk_by_admin.create')}}" class="nav-link">
                                        <p>Додати мову</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>
        <!-- /.content-wrapper -->


        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="/admin/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="/admin/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)

    </script>
    <!-- Bootstrap 4 -->
    <script src="/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="/admin/plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->
    <script src="/admin/plugins/sparklines/sparkline.js"></script>
    <!-- JQVMap -->
    <script src="/admin/plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="/admin/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="/admin/plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="/admin/plugins/moment/moment.min.js"></script>
    <script src="/admin/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="/admin/plugins/summernote/summernote-bs4.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/admin/dist/js/adminlte.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="/admin/dist/js/demo.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="/admin/dist/js/pages/dashboard.js"></script>
    <script type="text/javascript" src="/admin/dist/js/jquery.colorbox-min.js"></script>
    <script src="https://cdn.tiny.cloud/1/jxsqeq85qzdwuqqqruya91jqsrhqtxykhxtks6sn0t1kn69g/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script type="text/javascript" src="/packages/barryvdh/elfinder/js/standalonepopup.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script>

    <script src="/admin/admin.js"></script>
    <script type="text/javascript">
        $(function () {
            $("#statuslist").change(function () {
                var status = this.value;
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                var url = '{{ route("getbase_info", ":status") }}';
                url = url.replace(':status', status );
                $.ajax({
                url: url,
                type: 'get',
                dataType: 'json',
               success: function(response){
                var appendHtml = "";
                for(let i = 0; i < response.length; i++) {
                    let obj = response[i];
                    var editurl = '{{ route("base_info.edit", ":status") }}';
                    editurl = editurl.replace(':status', obj.id );
                    appendHtml+='<tr><td>'+obj.id_client+'</td><td>'+obj.phone+'</td><td>'+obj.status+'</td><td>'+obj.user_info+'</td><td class="project-actions text-right"><a class="btn btn-info btn-sm" onclick="adminCall('+obj.id+')"><i class="fas fa-phone"></i>Звонок</a><a class="btn btn-warning btn-sm" href="'+editurl+'"><i class="fas fa-pencil-alt"></i>Редактировать</a><form action="{{ route("base_info.destroy", '+obj.id+') }}" method="POST" style="display: inline-block"> @csrf    @method("DELETE")<button type="submit" class="btn btn-danger btn-sm delete-btn"><i class="fas fa-trash"> </i> Удалить</button> </form></td></tr>';
                    console.log(appendHtml);
                }
                 $("#baseinfotable tbody").empty();
                 $("#baseinfotable tbody").append(appendHtml);
                console.log(response[0]);
               }
             });
            });
        });
    </script>
</body>

</html>
