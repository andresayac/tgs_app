<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Designation $designation
 */

$designation->note = 'Agregar a Futuro';
?>

<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Sucursal</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/branchs">Sucursales</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Ver</li>
                </ol>
            </nav>
        </div>
    </div>
</div>


<div class="card-box mb-30">
    <div class="pd-20">
        <h4 class="text-blue h4">Datos del Cargo</h4>
        <p class="mb-0"></p>
    </div>
</div>

<div class="row">
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
        <div class="pd-20 card-box height-100-p">

            <h5 class="text-center h5 mb-0"></h5>
            <p class="text-center text-muted font-14">
                <strong><?= h($designation->name) ?></strong>
            </p>
            <div class="profile-info">
                <h5 class="mb-20 h5 text-blue">Información del Cargo</h5>
                <ul>
                    <li>
                        <span>Cargo:</span>
                        <?= h($designation->name) ?>
                    </li>
                    <li>
                        <span>Notas:</span>
                        <blockquote>
                            <?= $this->Text->autoParagraph(h($designation->note)); ?>
                        </blockquote>
                    </li>
                </ul>
            </div>

        </div>
    </div>
    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-30">
        <div class="pd-20 card-box height-100-p overflow-hidden">

            <h5 class="text-center h5 mb-0"></h5>
            <p class="text-center text-muted font-14">
                <strong>Usuarios relacionados al Cargo</strong>
            </p>
            <div class="profile-info">
                <div class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <table id="datatable-companies" class="data-table table stripe hover nowrap dataTable no-footer dtr-inline">
                        <thead>
                            <tr>
                                <th><?= $this->Paginator->sort('id') ?></th>
                                <th><?= $this->Paginator->sort('username', 'Usuario') ?></th>
                                <th><?= $this->Paginator->sort('fullname', 'Nombre') ?></th>
                                <th><?= $this->Paginator->sort('document', 'Documento') ?></th>
                                <th><?= $this->Paginator->sort('active', 'Estado') ?></th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($designation->users as $users) : ?>
                                <tr>
                                    <td><?= $users->has('id') ? $this->Html->link($users->id, ['controller' => 'Branchs', 'action' => 'view', $users->id]) : '' ?></td>
                                    <td><?= h($users->username) ?></td>
                                    <td><?= h($users->fullname) ?></td>
                                    <td><?= h($users->date_birthday) ?></td>
                                    <td><span class="badge badge-<?= ((bool) $users->active) ? 'primary' : 'danger' ?>"><?= ((bool) $users->active) ? 'Activo' : 'Inactivo' ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
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
