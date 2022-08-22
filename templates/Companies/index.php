<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Company[]|\Cake\Collection\CollectionInterface $companies
 */
?>

<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Empresas</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/companies">Empresas</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Lista</li>
                </ol>
            </nav>
        </div>
        <div class="col-md-6 col-sm-12 text-right">
            <a class="btn btn-primary" href="/companies/add">
                Nueva Empresa
            </a>
        </div>
    </div>
</div>

<div class="card-box mb-30">
    <div class="pd-20">
        <h4 class="text-blue h4">Lista de Empresas</h4>
        <p class="mb-0"></p>
    </div>
    <div class="dataTables_wrapper dt-bootstrap4 no-footer">
        <table id="datatable-companies" class="data-table table stripe hover nowrap dataTable no-footer dtr-inline">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('name', 'Empresa') ?></th>
                    <th><?= $this->Paginator->sort('address', 'Dirección') ?></th>
                    <th><?= $this->Paginator->sort('city', 'Ciudad') ?></th>
                    <th><?= $this->Paginator->sort('state', 'Estado') ?></th>
                    <th><?= $this->Paginator->sort('country', 'País') ?></th>
                    <th><?= $this->Paginator->sort('active', 'Estado') ?></th>
                    <th class="actions datatable-nosort"><?= __('Acciones') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($companies as $company) : ?>
                    <tr>
                        <td><?= $this->Number->format($company->id) ?></td>
                        <td><?= h($company->name) ?></td>
                        <td><?= h($company->address) ?></td>
                        <td><?= h($company->city) ?></td>
                        <td><?= h($company->state) ?></td>
                        <td><?= h($company->country) ?></td>
                        <td><span class="badge badge-<?= ((bool) $company->active) ? 'primary' : 'danger' ?>"><?= ((bool) $company->active) ? 'Activo' : 'Inactivo' ?></span></td>
                        <td>
                            <div class="dropdown">
                                <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                    <i class="dw dw-more"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                    <?php if (isset($_permisos_user_['companies']['view'])) : ?>
                                        <?= $this->Html->link(__('<i class="dw dw-eye"></i>Ver'), ['action' => 'view', $company->id], [
                                            'escape' => false,
                                            'class' => 'dropdown-item'
                                        ]) ?>
                                    <?php endif; ?>
                                    <?php if (isset($_permisos_user_['companies']['edit'])) : ?>
                                        <?= $this->Html->link(__('<i class="dw dw-edit2"></i>Editar'), ['action' => 'edit', $company->id], [
                                            'escape' => false,
                                            'class' => 'dropdown-item'
                                        ]) ?>
                                    <?php endif; ?>
                                    <?php if (isset($_permisos_user_['companies']['delete'])) : ?>
                                        <?= $this->Form->postLink('<i class="dw dw-delete-3"></i>Eliminar', ['action' => 'delete', $company->id], ['class' => 'dropdown-item', 'escape' => false, 'confirm' => __('Esta seguro que quiere eliminar la capacitación # {0}?', $company->id)]) ?>
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