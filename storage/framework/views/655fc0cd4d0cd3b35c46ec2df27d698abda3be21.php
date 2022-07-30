<?php $__env->startSection('title', 'Все записи'); ?>

<?php $__env->startSection('content'); ?>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Все записи</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <?php if(session('success')): ?>
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-check"></i><?php echo e(session('success')); ?></h4>
                </div>
            <?php endif; ?>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body p-0">
                    <form action="<?php echo e(route('baseSetUser')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('POST'); ?>
                        <div style="margin-top: 1rem; margin-bottom: 1rem">
                            <h4 style="text-align: center">
                                Назначить на пользователя
                            </h4>
                            <select class="form-control select2 select2-hidden-accessible" name="user" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true" required>
                                <option selected="selected" data-select2-id="3"></option>
                                <?php $__currentLoopData = $userList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($user->id); ?>" ><?php echo e($user->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                ФИО
                            </th>
                            <th>
                                Назначено на пользователя
                            </th>
                            <th style="width: 30%">
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td>
                                        <?php echo e($post['id_client']); ?>

                                    </td>
                                    <td>
                                        <?php echo e($post['phone']); ?>

                                    </td>
                                    <td>
                                        <?php echo e($post['status']); ?>

                                    </td>
                                    <td>
                                        <?php echo e($post['user_info']); ?>

                                    </td>
                                    <td>
                                        <?php echo e($post['toUser']); ?>

                                    </td>
                                    <td class="project-actions text-right">

                                        <div class="form-check" <?php if($post['toUser'] === 'Не назначено'): ?>>
                                            <input class="form-check-input" type="checkbox" value="<?php echo e($post['id']); ?>" name="post[]" id="flexCheckDefault">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Выбрать запись <?php echo e($post['id_client']); ?>

                                            </label>
                                        </div <?php endif; ?>>

                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div class="alert alert-warning" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×
                                    </button>
                                    <h4><i class="icon fa fa-exclamation-triangle"></i>Записи отсутствуют!</h4>
                                </div>
                            <?php endif; ?>
                        </tbody>
                    </table>
                        <div class="row">

                            <div class="col-sm-12 col-md-7" style="margin-top: 1rem;">
                                <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                                    <ul class="pagination">
                                        <?php echo e($baseList->links()); ?>

                                    </ul>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success btn-sm" style="height: 35px;margin-top: 1rem;padding-right: 20px; padding-left: 20px">
                                <i class="fas fa-calendar-check">
                                </i>
                                Отправить
                            </button>
                        </div>

                    </form>

                </div>
                <!-- /.card-body -->
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OpenServer\domains\app\crm_app\resources\views/admin/info/base_list.blade.php ENDPATH**/ ?>