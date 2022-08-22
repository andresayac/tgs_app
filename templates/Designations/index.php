<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Designation[]|\Cake\Collection\CollectionInterface $designations
 */
?>


<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Cargos</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/designations">Cargos</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Lista</li>
                </ol>
            </nav>
        </div>
        <div class="col-md-6 col-sm-12 text-right">
            <a class="btn btn-primary" href="/designations/add">
                Nuevo Cargo
            </a>
        </div>
    </div>
</div>

<div class="card-box mb-30">
    <div class="pd-20">
        <h4 class="text-blue h4">Lista de Cargos</h4>
        <p class="mb-0"></p>
    </div>
    <div class="dataTables_wrapper dt-bootstrap4 no-footer">
        <table id="datatable-designations" class="data-table table stripe hover nowrap dataTable no-footer dtr-inline">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('name', 'Cargo') ?></th>
                    <th><?= $this->Paginator->sort('active', 'Estado') ?></th>
                    <th class="actions datatable-nosort"><?= __('Acciones') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($designations as $designation) : ?>
                    <tr>
                        <td><?= $this->Number->format($designation->id) ?></td>
                        <td><?= h($designation->name) ?></td>
                        <td><span class="badge badge-<?= ((bool) $designation->active) ? 'primary' : 'danger' ?>"><?= ((bool) $designation->active) ? 'Activo' : 'Inactivo' ?></span></td>
                        <td>
                            <div class="dropdown">
                                <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                    <i class="dw dw-more"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                    <?php if (isset($_permisos_user_['designations']['view'])) : ?>
                                        <?= $this->Html->link(__('<i class="dw dw-eye"></i>Ver'), ['action' => 'view', $designation->id], [
                                            'escape' => false,
                                            'class' => 'dropdown-item'
                                        ]) ?>
                                    <?php endif; ?>
                                    <?php if (isset($_permisos_user_['designations']['edit'])) : ?>
                                        <?= $this->Html->link(__('<i class="dw dw-edit2"></i>Editar'), ['action' => 'edit', $designation->id], [
                                            'escape' => false,
                                            'class' => 'dropdown-item'
                                        ]) ?>
                                    <?php endif; ?>
                                    <?php if (isset($_permisos_user_['designations']['delete'])) : ?>
                                        <?= $this->Form->postLink('<i class="dw dw-delete-3"></i>Eliminar', ['action' => 'delete', $designation->id], ['class' => 'dropdown-item', 'escape' => false, 'confirm' => __('Esta seguro que quiere eliminar la capacitación # {0}?', $designation->id)]) ?>
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
                    targets: 1,
                    className: "truncate"
                }
            ],
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
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