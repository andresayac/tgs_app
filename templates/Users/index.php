<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */

$total = count($users);
?>
<?php if ($total > 100) : ?>
    <div class="pre-loader">
        <div class="pre-loader-box">
            <div class="loader-logo">
                <img src="/img/mti-logo-dark.png" alt="" class="light-logo">
            </div>
            <div class="loader-progress" id="progress_div">
                <div class="bar" id="bar1"></div>
            </div>
            <div class="percent" id="percent1">0%</div>
            <div class="loading-text">Cargando...</div>
        </div>
    </div>
<?php endif; ?>
<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Usuarios</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/users">Usuarios</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Lista</li>
                </ol>
            </nav>
        </div>
        <div class="col-md-6 col-sm-12 text-right">
            <div class="dropdown">
                <?php $valida_menu = (isset($_permisos_user_['users']['import']) && isset($_permisos_user_['users']['export'])) ? true : false; ?>
                <a class="btn btn-primary <?php if ($valida_menu) echo "dropdown-toggle" ?>" href="/users/add" role="button" data-toggle="<?php if ($valida_menu) echo "dropdown" ?>">
                    Nuevo usuario
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="/users/add">Nuevo Usuario</a>
                    <?php if (isset($_permisos_user_['users']['import'])) : ?><a class="dropdown-item" href="/users/import">Importar Usuarios</a><?php endif; ?>
                    <?php if (isset($_permisos_user_['users']['export'])) : ?><a class="dropdown-item" href="/users/export">Exportar Usuarios</a><?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card-box mb-30">
    <div class="pd-20">
        <h4 class="text-blue h4">Lista de Usuarios</h4>
        <p class="mb-0"></p>
    </div>
    <div class="dataTables_wrapper dt-bootstrap4 no-footer">
        <table id="datatable-usuarios" class="data-table table stripe hover nowrap dataTable no-footer dtr-inline">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('fullname', 'Nombre') ?></th>
                    <th><?= $this->Paginator->sort('rol_id', 'Rol') ?></th>
                    <th><?= $this->Paginator->sort('active', 'Estado') ?></th>
                    <th><?= $this->Paginator->sort('branch_id', 'Sucursal') ?></th>
                    <th><?= $this->Paginator->sort('dep_id', 'Area') ?></th>
                    <th><?= $this->Paginator->sort('designation_id', 'Cargo') ?></th>
                    <th class="datatable-nosort"><?= __('Acciones') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user) : ?>
                    <tr>
                        <td><?= $user->id ?></td>
                        <td><?= h($user->fullname) ?></td>
                        <td><?= $user->has('role') ? $this->Html->link($user->role->name, ['controller' => 'Roles', 'action' => 'view', $user->role->id]) : '' ?></td>
                        <td><span class="badge badge-<?= ((bool) $user->active) ? 'primary' : 'danger' ?>"><?= ((bool) $user->active) ? 'Activo' : 'Inactivo' ?></span></td>
                        <td><?= $user->has('branch') ? $this->Html->link($user->branch->name, ['controller' => 'Branchs', 'action' => 'view', $user->branch->id]) : '' ?></td>
                        <td><?= $user->has('departament') ? $this->Html->link($user->departament->name, ['controller' => 'Departaments', 'action' => 'view', $user->departament->id]) : '' ?></td>
                        <td><?= $user->has('designation') ? $this->Html->link($user->designation->name, ['controller' => 'Designations', 'action' => 'view', $user->designation->id]) : '' ?></td>
                        <td>
                            <div class="dropdown">
                                <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                    <i class="dw dw-more"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                    <?php if (isset($_permisos_user_['users']['view'])) : ?>
                                        <?= $this->Html->link(__('<i class="dw dw-eye"></i>Ver'), ['action' => 'view', $user->id], [
                                            'escape' => false,
                                            'class' => 'dropdown-item'
                                        ]) ?>
                                    <?php endif; ?>
                                    <?php if (isset($_permisos_user_['users']['edit'])) : ?>
                                        <?= $this->Html->link(__('<i class="dw dw-edit2"></i>Editar'), ['action' => 'edit', $user->id], [
                                            'escape' => false,
                                            'class' => 'dropdown-item'
                                        ]) ?>
                                    <?php endif; ?>
                                    <?php if (isset($_permisos_user_['users']['delete'])) : ?>
                                        <?= $this->Form->postLink('<i class="dw dw-delete-3"></i>Eliminar', ['action' => 'delete', $user->id], ['class' => 'dropdown-item', 'escape' => false, 'confirm' => __('Esta seguro que quiere eliminar el usuario # {0}?', $user->fullname)]) ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>
<script>
    $(document).ready(function() {
        $('.data-table').DataTable({
            scrollCollapse: true,
            autoWidth: false,
            info: true,
            paging: true,
            responsive: true,
            columnDefs: [{
                    targets: "datatable-nosort",
                    orderable: false,
                },
                {
                    responsivePriority: 1,
                    targets: "datatable-nosort"
                },
                {
                    targets: [1, 4, 5, 6],
                    className: "truncate"
                }
            ],
            "lengthMenu": [
                [10, 25],
                [10, 25]
            ],
            "language": {
                "info": "_START_-_END_ de _TOTAL_ registros",
                searchPlaceholder: "Buscar",
                paginate: {
                    next: '<i class="ion-chevron-right"></i>',
                    previous: '<i class="ion-chevron-left"></i>'
                },
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfoEmpty": "Mostrando registros del 0 al 0 <br> de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            },
        });
    });
</script>