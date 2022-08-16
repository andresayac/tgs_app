<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>


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
                <a class="btn btn-primary dropdown-toggle"  href="#" role="button" data-toggle="dropdown">
                    Nuevo usuario
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="/users/add">Nuevo Usuario</a>
                    <a class="dropdown-item" href="/users/import">Importar Usuarios</a>
                    <a class="dropdown-item" href="/users/export">Exportar Usuarios</a>
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
                    <th><?= $this->Paginator->sort('rol_id', 'Rol') ?></th>
                    <th><?= $this->Paginator->sort('name', 'Nombres') ?></th>
                    <th><?= $this->Paginator->sort('lastname', 'Apellidos') ?></th>
                    <th><?= $this->Paginator->sort('active', 'Estado') ?></th>
                    <th><?= $this->Paginator->sort('branch_id', 'Sucursal') ?></th>
                    <th><?= $this->Paginator->sort('dep_id', 'Area') ?></th>
                    <th><?= $this->Paginator->sort('designation_id', 'Cargo') ?></th>
                    <th class="actions"><?= __('Acciones') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user) : ?>
                    <tr>
                        <td><?= $user->id ?></td>
                        <td><?= $user->has('role') ? $this->Html->link($user->role->name, ['controller' => 'Roles', 'action' => 'view', $user->role->id]) : '' ?></td>
                        <td><?= h($user->name) ?></td>
                        <td><?= h($user->lastname) ?></td>
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
                                    <?= $this->Html->link(__('<i class="dw dw-eye"></i>Ver'), ['action' => 'view', $user->id], [
                                        'escape' => false,
                                        'class' => 'dropdown-item'
                                    ]) ?>
                                    <?= $this->Html->link(__('<i class="dw dw-edit2"></i>Editar'), ['action' => 'edit', $user->id], [
                                        'escape' => false,
                                        'class' => 'dropdown-item'
                                    ]) ?>

                                    <?= $this->Form->postLink(
                                        '<i class="dw dw-delete-3"></i>Eliminar',
                                        [
                                            'action' => 'delete', $user->id
                                        ],
                                        [
                                            'escape' => false,
                                            'class' => 'dropdown-item',
                                            'confirm' => __('¿Eliminar: {0}?', $user->name)
                                        ]
                                    ) ?>
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
            responsive: true,
            columnDefs: [{
                targets: "datatable-nosort",
                orderable: false,
            }],
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
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
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