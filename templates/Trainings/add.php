<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Training $training $departaments $designations
 */

$assistants = [
    "Departamentos" => [],
    "Cargos" => []
];


foreach ($departaments as $departament) {
    $assistants['Departamentos']["departament_{$departament['id']}"] = $departament['name'];
}

foreach ($designations as $designation) {
    $assistants['Cargos']["designation_{$designation['id']}"] = $designation['name'];
}

$fecha_selected = $this->request->getQuery('d') ?? false;
$hora_selected = $this->request->getQuery('t') ?? false;

if ($this->request->getQuery('d')) {
    $training->set('fecha_inicio', $this->request->getQuery('d'));
    $training->set('fecha_fin', $this->request->getQuery('d'));
}
?>


<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Nueva Capacitación</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/trainings">Sucursal</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Nueva</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="card-box mb-30">
    <div class="pd-20">
        <h4 class="text-blue h4">Datos de la Capacitación</h4>
        <p class="mb-0"></p>
    </div>
    <?= $this->Form->create($training) ?>
    <div class="pd-20 card-box mb-30">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="row">
                    <div class="col-md-8 col-sm-12">
                        <div class="form-group">
                            <?= $this->Form->control('name', ['label' => 'Nombre de Capacitación', 'class' => 'form-control']); ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <div class="input text">
                                <label>Fecha de realización</label>
                                <?= $this->Form->input('start_date', ['type' => 'text', 'label' => false, 'class' => 'form-control datetimepickertraining']) ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <div class="input text">
                                <label>Fecha de terminación</label>
                                <?= $this->Form->input('end_date', ['type' => 'text', 'label' => false, 'class' => 'form-control datetimepickertraining']) ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label>Areas a Capacitar</label>
                            <?= $this->Form->select('departaments', $assistants['Departamentos'], ['empty' => false, 'class' => 'selectpicker form-control select2', 'label' => false, 'required' => true, "multiple" => true, "data-actions-box" => true, "data-live-search" => true]) ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label>Cargos a Capacitar</label>
                            <?= $this->Form->select('designations', $assistants['Cargos'], ['empty' => false, 'class' => 'selectpicker form-control select2', 'label' => false, 'required' => true, "multiple" => true, "data-actions-box" => true, "data-live-search" => true]) ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label>Notas</label>
                            <?= $this->Form->input('note', ['class' => 'form-control', 'type' => 'textarea']) ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 pd-20 mb-15">
                    <div class="form-group">
                        <?= $this->Form->button('Crear Capacitación', ['class' => 'btn btn-outline-primary']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>


<script>
    $(".datetimepickertraining").datepicker({
        timepicker: true,
        language: "es",
        autoClose: false,
        dateFormat: 'yyyy-mm-dd',
        timeFormat: 'hh:ii',
    });
</script>