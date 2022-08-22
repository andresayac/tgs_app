<?php

$meses = [1 => 'Ene', 2 => 'Feb', 3 => 'Mar', 4 => 'May', 5 => 'Abr', 6 => 'Jun', 7 => 'Jul', 8 => 'Ago', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dic'];
$dias = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];

$query_search = $this->request->getData() ?? [];

?>


<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Historico de Capacitaciones</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/trainings/me">Mis Capacitaciones</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Historico</li>
                </ol>
            </nav>
        </div>
    </div>
</div>


<div class="card-box mb-30">
    <div class="pd-20">
        <div class="row no-gutters">
            <div class="col-12">
                <div class="float-left">
                    <span class="text-blue h5"> Busqueda y filtros </span>
                </div>
            </div>
        </div>

        <?= $this->Form->create(null, ['valueSources' => 'query']) ?>

        <div class="row mt-2">
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label>Desde</label>
                    <?= $this->Form->control('start_date', ['label' => false, 'placeholder' => 'ej. 2022-08-10', 'autocomplete' => 'off', 'class' => 'form-control form-control-sm datepicker-2 date-picker-history', 'value' => $query_search['start_date'] ?? '']) ?>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label>Hasta</label>
                    <?= $this->Form->control('end_date', ['label' => false, 'placeholder' => 'ej. 2022-08-15', 'autocomplete' => 'off', 'class' => 'form-control form-control-sm datepicker-2 date-picker-history', 'value' => $query_search['end_date'] ?? '']) ?>
                </div>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <?php if (!empty($query_search['start_date']) || !empty($query_search['end_date'])) : ?>
                        <?= $this->Html->link('Limpiar filtros', ['action' => 'history'], ["class" => "btn btn-danger btn-sm"]) ?>
                    <?php endif ?>
                    <?= $this->Form->button('Buscar', ["class" => "btn btn-primary btn-sm"]) ?>
                </div>
            </div>
        </div>



        <?= $this->Form->end() ?>

    </div>
</div>

<div class=" pd-20 card-box mb-30">
    <div class="clearfix mb-20">
        <div class="pull-left">
            <span class="text-blue h5">Lista de Capacitaciones</span>

        </div>

    </div>
    <div class="dataTables_wrapper dt-bootstrap4 no-footer">
        <?php foreach ($trainings as $training) : ?>
            <div class="chat-profile-header clearfix">
                <div class="left">
                    <div class="clearfix">
                        <div class="chat-profile-photo">
                            <p class="h5 text-blue text-left" style="font-size: 15px;"><?= $meses[$training->start_date->format('n')] ?><br><?= $training->start_date->format('j') ?></p>
                        </div>
                        <div class="pricing-card-header">
                            <div class="left">
                                <h6><?= $this->Html->link($training->name, ['action' => 'attendance', $training->id]) ?></h6>
                                <p><?= $dias[$training->start_date->format('w')] ?> <?= $training->start_date->format('H:i') ?> - <?= $training->end_date->format('H:i') ?> </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="right text-right">
                    <div class="dropdown">
                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                            <i class="dw dw-more" style="font-size: 18px;"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                            <?php if (isset($_permisos_user_['trainings']['attendance'])) : ?>
                                <?= $this->Html->link(__('<i class="icon-copy bi bi-calendar-check"></i>Asistencia'), ['action' => 'attendance', $training->id], [
                                    'escape' => false,
                                    'class' => 'dropdown-item'
                                ]) ?>
                            <?php endif; ?>
                            <?php if (isset($_permisos_user_['trainings']['view'])) : ?>
                                <?= $this->Html->link(__('<i class="dw dw-eye"></i>Ver'), ['action' => 'view', $training->id], [
                                    'escape' => false,
                                    'class' => 'dropdown-item'
                                ]) ?>
                            <?php endif; ?>
                            <?php if (isset($_permisos_user_['trainings']['edit'])) : ?>
                                <?= $this->Html->link(__('<i class="dw dw-edit2"></i>Editar'), ['action' => 'edit', $training->id], [
                                    'escape' => false,
                                    'class' => 'dropdown-item'
                                ]) ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>



        <?php endforeach ?>


    </div>


</div>



<script>
    // date picker
    $(".date-picker-history").datepicker({
        language: "en",
        autoClose: true,
        dateFormat: "yyyy-mm-dd",
    });
</script>