<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Training $training
 */


$meses = [1 => 'Ene', 2 => 'Feb', 3 => 'Mar', 4 => 'May', 5 => 'Abr', 6 => 'Jun', 7 => 'Jul', 8 => 'Ago', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dic'];
$dias = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];

$trainers = explode(',', $training->trainer);
$count = 1;

$data = [
    "Users" => [],
    "UsersID" => []
];

foreach ($users as $user) {
    $data['Users'][$user['document']] = [
        "name" => strtoupper($user['fullname']) ?? ''
    ];

    $data['UsersID'][$user['id']] = [
        "name" => strtoupper($user['fullname'])
    ];
}


?>
<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Resumen de Capacitación</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/trainings">Capacitaciones</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Resumen</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="invoice-wrap mb-20">
    <div class="invoice-box">
        <div class="invoice-header">
            <div class="logo text-center">
                <img src="vendors/images/deskapp-logo.png" alt="" />
            </div>
        </div>
        <h4 class="text-center mb-30 weight-600">Capacitación</h4>
        <div class="row pb-30">
            <div class="col-md-7">
                <h5 class="mb-15">Nombre</h5>
                <p class="font-14 mb-5">
                    <strong class="weight-600">Crea Capacitación</strong>
                </p>
                <p class="font-14 mb-5">
                    <strong class="weight-600">Fecha de Realización</strong>
                </p>
                <p class="font-14 mb-5">
                    <strong class="weight-600">ID capacitación</strong>
                </p>
                <p class="font-14 mb-5">
                    <strong class="weight-600">Capacitador</strong>
                </p>
                <p class="font-14 mb-5">
                    <strong class="weight-600">Lugar</strong>
                </p>
                <p class="font-14 mb-5">
                    <strong class="weight-600"> Notas: </strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($training->note)); ?>
                </blockquote>
                </p>
            </div>
            <div class="col-md-5">
                <div class="text-right">
                    <p class="font-14 mb-5"><?= h($training->name) ?></p>
                    <p class="font-14 mb-5">
                        <span class='badge badge-primary' style='margin: 1px;'><?= $data['UsersID'][$training->created_by]['name'] ?></span>
                    </p>
                    <p class="font-14 mb-5"><?= $dias[$training->start_date->format('w')] ?> <?= $training->start_date->format('d') ?> <?= $meses[$training->start_date->format('n')] ?> | <?= $training->start_date->format('h:i a') ?> - <?= $training->end_date->format('h:i a') ?></p>
                    <p class="font-14 mb-5"><?= $this->Number->format($training->id) ?></p>
                    <p class="font-14 mb-5">
                        <?php foreach ($trainers as $value) : ?>
                            <?php if (empty($value)) break; ?>
                            <span class='badge badge-primary' style='margin: 1px;'><?= $data['Users'][$value]['name'] ?></span>
                        <?php endforeach; ?>
                    </p>
                    <p class="font-14 mb-5"> <?= h($training->place) ?></p>
                </div>
            </div>
        </div>
        <div class="invoice-desc pb-30">
            <div class="invoice-desc-head clearfix">
                <div class="invoice-sub"></div>
                <div class="invoice-rate"></div>
                <div class="invoice-subtotal"></div>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Empleado</th>
                    <th scope="col">Asiste</th>
                    <th scope="col">Hora Asistencia</th>
                    <th scope="col">Tipo de Asistencia</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($training->trainings_assistances as $trainingsAssistances) : ?>
                    <tr>
                        <td scope="row"><?= h($trainingsAssistances->user->fullname) ?></td>
                        <td scope="row"><span class="badge badge-<?= ((bool) $trainingsAssistances->checked) ? 'primary' : 'danger' ?>"><?= ((bool) $trainingsAssistances->checked) ? 'Asistio' : 'No Asistio' ?></span></td>
                        <td scope="row"><?= h($trainingsAssistances->check_ts) ?></td>
                        <td scope="row"><?= h($trainingsAssistances->type_check) ?></td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="invoice-desc pb-30">

            <div class="invoice-desc-footer">
                <div class="invoice-desc-head clearfix">
                    <div class="invoice-sub"></div>
                    <div class="invoice-sub"><?php if (empty($training->trainings_assistances)) echo "No hay Asistentes"; ?></div>
                    <div class="invoice-subtotal"></div>
                </div>

            </div>
        </div>
        <h4 class="text-center pb-20"><?= (!$training->end_date->isPast()) ? 'PENDIENTE' : 'FINALIZADA'; ?></h4>
    </div>
</div>