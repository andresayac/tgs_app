<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Training[]|\Cake\Collection\CollectionInterface $trainings
 */
$data = [
    "Users" => []
];

foreach ($users as $user) {
    $data['Users'][$user['document']] = [
        "name" => $user['fullname']
    ];
}



?>


<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Capacitaciones</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/trainings">Capacitaciones</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Lista</li>
                </ol>
            </nav>
        </div>
        <div class="col-md-6 col-sm-12 text-right">
            <a class="btn btn-primary" href="/trainings/add">
                Nueva Capacitación
            </a>
        </div>
    </div>
</div>

<div class="card-box mb-30">
    <div class="pd-20">
        <h4 class="text-blue h4">Lista de Capacitaciónes</h4>
        <p class="mb-0"></p>
    </div>
    <div class="dataTables_wrapper dt-bootstrap4 no-footer">
        <table id="datatable-trainings" class="data-table table stripe hover nowrap dataTable no-footer dtr-inline">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('name', 'Nombre') ?></th>
                    <th><?= $this->Paginator->sort('trainer', 'Capacitador') ?></th>
                    <th><?= $this->Paginator->sort('start_date', 'Fecha') ?></th>
                    <th><?= $this->Paginator->sort('start_date', 'Inicio') ?></th>
                    <th><?= $this->Paginator->sort('end_date', 'Fin') ?></th>
                    <th><?= $this->Paginator->sort('created_by', 'Crea') ?></th>
                    <th class="actions datatable-nosort"><?= __('Acciones') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($trainings as $training) : ?>
                    <tr>
                        <td><?= $this->Number->format($training->id) ?></td>
                        <td><?= h($training->name) ?></td>
                        <td>
                            <?php
                            $trainers = explode(',', $training->trainer);
                            $count = 1;
                            foreach ($trainers as $value) {
                                if (empty($value)) break;
                                if ($count === 3) {
                                    echo "<span class='badge badge-primary'>...</span>";
                                    break;
                                }
                                echo "<span class='badge badge-primary' style='margin: 1px;'>{$data['Users'][$value]['name']}</span>";
                                $count++;
                            } ?></td>
                        <td><?= h($training->start_date->format('Y-m-d')) ?></td>
                        <td><?= h($training->start_date->format('h:i a')) ?></td>
                        <td><?= h($training->end_date->format('h:i a')) ?></td>
                        <td><?= h($training->created_by) ?></td>
                        <td>
                            <div class="dropdown">
                                <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                    <i class="dw dw-more"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                    <?= $this->Html->link(__('<i class="icon-copy bi bi-calendar-check"></i>Asistencia'), ['action' => 'attendance', $training->id], [
                                        'escape' => false,
                                        'class' => 'dropdown-item'
                                    ]) ?>
                                    <?= $this->Form->postLink('<i class="dw dw-copy"></i>Duplicar', ['action' => 'duplicate', $training->id], ['class' => 'dropdown-item', 'escape' => false, 'confirm' => __('Esta seguro que quiere duplicar la capacitación # {0}?', $training->id)]) ?>

                                    <?= $this->Html->link(__('<i class="dw dw-eye"></i>Ver'), ['action' => 'view', $training->id], [
                                        'escape' => false,
                                        'class' => 'dropdown-item'
                                    ]) ?>
                                    <?= $this->Html->link(__('<i class="dw dw-edit2"></i>Editar'), ['action' => 'edit', $training->id], [
                                        'escape' => false,
                                        'class' => 'dropdown-item'
                                    ]) ?>
                                    <?= $this->Form->postLink('<i class="dw dw-delete-3"></i>Eliminar', ['action' => 'delete', $training->id], ['class' => 'dropdown-item', 'escape' => false, 'confirm' => __('Esta seguro que quiere eliminar la capacitación # {0}?', $training->id)]) ?>
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