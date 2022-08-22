<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Training $training $departaments $designations $users
 */

$assistants = [
    "Users" => []
];

foreach ($users as $user) {
    $assistants['Users']["Area: " . $user['departament']['name'] . " - Cargo: " . $user['designation']['name']][$user['document']] = $user['fullname'];
}

$fecha_selected = $this->request->getQuery('d') ?? false;
$hora_selected = $this->request->getQuery('t') ?? false;

if ($this->request->getQuery('d')) {
    $training->set('start_date', $this->request->getQuery('d'));
    $training->set('start_hour', $this->request->getQuery('t'));
    $training->set('end_hour', $this->request->getQuery('t'));
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
                                <?= $this->Form->input('start_date', ['type' => 'text', 'label' => false, 'class' => 'form-control date-picker-training']) ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label>Capacitador</label>
                            <?= $this->Form->select('trainer', $assistants['Users'], ['empty' => false, 'class' => 'selectpicker form-control', 'label' => false, 'required' => true, "multiple" => true, "data-actions-box" => true, "data-live-search" => true]) ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label>Hora de Inicio</label>
                            <?= $this->Form->input('start_hour', ['empty' => false, 'class' => 'form-control time-picker-training select2', 'label' => false, 'required' => true]) ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label>Hora estimada de finalización</label>
                            <?= $this->Form->input('end_hour', ['empty' => false, 'class' => 'form-control time-picker-training select2', 'label' => false, 'required' => true]) ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <?= $this->Form->control('place', ['label' => 'Lugar de Capacitación', 'class' => 'form-control']); ?>
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

    // date picker
    $(".date-picker-training").datepicker({
        language: "en",
        autoClose: true,
        minDate: new Date(),
        dateFormat: "yyyy-mm-dd"
    });


    $(".time-picker-training").timeDropper({
        format: 'HH:mm',
        autoswitch: false,
        meridians: true,
        mousewheel: false,
        setCurrentTime: true,
        init_animation: "fadein",
        primaryColor: "#1977CC",
        borderColor: "#1977CC",
        backgroundColor: "#FFF",
        textColor: '#555'
    });
</script>