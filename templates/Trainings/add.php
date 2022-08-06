<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Training $training
 */
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
                                <label>Fecha de Inicio</label>
                                <input class="form-control datetimepicker" placeholder="Selecionar Fecha" type="text" name="start_date" id="start-date" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <div class="input text">
                                <label>Fecha de terminación</label>
                                <input class="form-control datetimepicker" placeholder="Selecionar Fecha" type="text" name="end_date" id="end_date" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                        <label>Areas o Cargos a Capacitar</label>
										<select
											class="selectpicker form-control"
											multiple
											data-actions-box="true"
                                            data-live-search="true"
											data-selected-text-format="count"
                                            name="designations" id="designations"
										>
											<optgroup label="Areas">
												<option>Almacenamiento</option>
												<option>Calidad</option>
												<option>Nomina</option>
											</optgroup>
											<optgroup label="Cargos">
												<option>T.I</option>
												<option>Calidad</option>
												<option>Bodega</option>
											</optgroup>
										</select>
                            <?php //$this->Form->control('designations', ['label' => 'Areas para Capacitación', 'class' => 'form-control']); ?>
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
    $(".datetimepicker").datepicker({
        timepicker: true,
        language: "en",
        autoClose: false,
        dateFormat: "dd MM yyyy",
    });
</script>