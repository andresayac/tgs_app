<?php
$meses = [1 => 'Ene', 2 => 'Feb', 3 => 'Mar', 4 => 'May', 5 => 'Abr', 6 => 'Jun', 7 => 'Jul', 8 => 'Ago', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dic'];
$dias = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];

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
                    <li class="breadcrumb-item active" aria-current="page">Mi lista</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="card-box mb-30">
    <div class="pd-20">
        <div class="row">
            <div class="col-12">
                <div class="float-left">
                    <?= $this->Html->link('Nueva Capacitación', ['action' => 'add'], ["class" => "btn btn-primary btn-sm mt-1"]) ?>
                    <?= $this->Html->link('Ver Calendario', ['action' => 'calendar'], ["class" => "btn btn-info  btn-sm mt-1"]) ?>
                    <?= $this->Html->link('Histórico', ['action' => 'history'], ["class" => "btn btn-warning  btn-sm mt-1"]) ?>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="pd-20 card-box mb-30">
    <div class="clearfix mb-20">
        <div class="pull-left">
            <span class="text-blue h5">Capacitaciones para hoy (<span class="text-black h5"><?= $trainings->count() ?></span>)</span>
        </div>
        <div class="pull-right">
            <a class=""><i class="icon-copy bi bi-calendar-minus text-blue"></i> <?= $meses[date('n')] ?> <?= date('j') ?></a>
        </div>
    </div>
    <div class="dataTables_wrapper dt-bootstrap4 no-footer">
        <?php foreach ($trainings as $training) : ?>

            <div class="chat-profile-header clearfix">
                <div class="left">
                    <div class="clearfix">
                        <div class="chat-profile-photo">
                            <p class="h5 text-blue text-left" style="font-size: 15px;">Hoy</p>
                        </div>
                        <div class="pricing-card-header">
                            <div class="left">
                                <h6><?= $this->Html->link($training->name, ['action' => 'attendance', $training->id]) ?></h6>
                                <p> <?= $dias[$training->start_date->format('w')] ?> <?= $training->start_date->format('H:i') ?> - <?= $training->end_date->format('H:i') ?> </p>
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

<div class=" pd-20 card-box mb-30">
    <div class="clearfix mb-20">
        <div class="pull-left">
            <span class="text-blue h5">Proximas capacitaciones</span>

        </div>

    </div>

    <div class="dataTables_wrapper dt-bootstrap4 no-footer">
        <?php foreach ($next_trainings as $next_training) : ?>
            <div class="chat-profile-header clearfix">
                <div class="left">
                    <div class="clearfix">
                        <div class="chat-profile-photo">
                            <p class="h5 text-blue text-left" style="font-size: 15px;"><?= $meses[$next_training->start_date->format('n')] ?><br><?= $next_training->start_date->format('j') ?></p>
                        </div>
                        <div class="pricing-card-header">
                            <div class="left">
                                <h6><?= $this->Html->link($next_training->name, ['action' => 'attendance', $next_training->id]) ?></h6>
                                <p> <?= $dias[$next_training->start_date->format('w')] ?> <?= $next_training->start_date->format('H:i') ?> - <?= $next_training->end_date->format('H:i') ?> </p>
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
                            <?= $this->Html->link(__('<i class="icon-copy bi bi-calendar-check"></i>Asistencia'), ['action' => 'attendance', $next_training->id], [
                                'escape' => false,
                                'class' => 'dropdown-item'
                            ]) ?>
                            <?= $this->Html->link(__('<i class="dw dw-eye"></i>Ver'), ['action' => 'view', $next_training->id], [
                                'escape' => false,
                                'class' => 'dropdown-item'
                            ]) ?>
                            <?= $this->Html->link(__('<i class="dw dw-edit2"></i>Editar'), ['action' => 'edit', $next_training->id], [
                                'escape' => false,
                                'class' => 'dropdown-item'
                            ]) ?>
                        </div>
                    </div>
                </div>
            </div>

        <?php endforeach ?>


    </div>

</div>