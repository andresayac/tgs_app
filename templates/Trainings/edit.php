<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Training $training  $users
 */

$assistants = [
    "Users" => []
];

foreach ($users as $user) {
    $assistants['Users'][$user['document']] = $user['name'] . " " . $user['lastname'] . " - " . $user['document'];
}

$trainer = explode(",", $training->trainer);

?>

<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Editar Capacitación</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/trainings">Capacitación</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Editar</li>
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
                            <?= $this->Form->select('trainer', $assistants['Users'], ['empty' => false, 'class' => 'selectpicker form-control', 'label' => false, 'required' => true, "multiple" => true, "data-actions-box" => true, "data-live-search" => true, "value" => $trainer]) ?>
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
                            <label>Notas</label>
                            <?= $this->Form->input('note', ['class' => 'form-control', 'type' => 'textarea']) ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 pd-20 mb-15">
                    <div class="form-group">
                        <?= $this->Form->button('Editar Capacitación', ['class' => 'btn btn-outline-primary']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>


<script>
    $(".date-time-picker-training").datepicker({
        timepicker: true,
        language: "es",
        autoClose: false,
        dateFormat: 'yyyy-mm-dd'
    });

    // date picker
    $(".date-picker-training").datepicker({
        language: "en",
        autoClose: true,
        dateFormat: "yyyy-mm-dd",
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