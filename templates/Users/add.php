<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 * @var \Cake\Collection\CollectionInterface|string[] $roles
 * @var \Cake\Collection\CollectionInterface|string[] $departaments
 * @var \Cake\Collection\CollectionInterface|string[] $branchs
 * @var \Cake\Collection\CollectionInterface|string[] $designations
 */
?>


<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Usuarios</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/users">Usuarios</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Nuevo Usuario</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="card-box mb-30">
    <div class="pd-20">
        <h4 class="text-blue h4">Lista de Usuarios</h4>
        <p class="mb-0"></p>
    </div>
    <?= $this->Form->create($user) ?>
    <?php if ($user->hasErrors()) : ?>
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-danger">
                        <div class="alert-title">Revisa estos campos</div>
                        <ul>
                            <?php foreach ($user->getErrors() as $campo => $errores) {
                                foreach ($errores as $tipo => $error) {
                                    echo "<li>" . $error . "</li>";
                                }
                            } ?>
                        </ul>
                    </div>

                </div>
            </div>
        <?php endif ?>
    <div class="pd-20 card-box mb-30">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label>Activo</label>
                            <?= $this->Form->select('active', ['0' => 'NO', '1' => 'SI'], ['empty' => false, 'class' => 'selectpicker form-control', 'label' => false, 'required' => true, 'value' => 1]) ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <?= $this->Form->control('rol_id', ['options' => $roles, 'empty' => false, 'label' => ['text' => 'Rol'], 'class' => 'selectpicker form-control']); ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <?= $this->Form->control('username', ['label' => 'Usuario', 'class' => 'form-control']); ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <?php
                            if (in_array($_logged_user_['rol_id'], [1, 2])) echo $this->Form->control('lastname', ['label' => 'Contraseña', 'class' => 'form-control', 'type' => 'password']);
                            ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <?= $this->Form->control('name', ['label' => 'Nombre', 'class' => 'form-control']); ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <?= $this->Form->control('lastname', ['label' => 'Apellido', 'class' => 'form-control']); ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <label>Tipo y número de identificación</label>
                    </div>
                    <div class="col-md-1 col-sm-12">
                        <div class="form-group">
                            <?= $this->Form->select('document_type', [
                                'CC' => 'CC',
                                'CE' => 'CE',
                                'Otro' => 'Otro',
                            ], ['empty' => '...', 'class' => 'selectpicker form-control', 'styles' => '', 'label' => false, 'required' => true]) ?>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12">
                        <div class="form-group">
                            <?= $this->Form->control('document', ['type' => 'number', 'label' => false, 'required' => true, 'error' => false, 'class' => 'form-control']) ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <?= $this->Form->control('date_birthday', ['empty' => true, 'label' => ['text' => 'Fecha de Nacimiento'], 'class' => "form-control date-picker-date-birthday", 'placeholder' => 'Selecione Fecha']); ?>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <?= $this->Form->control('telephone', ['label' => 'Teléfono', 'class' => 'form-control']); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="pd-20 card-box mb-30">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <?= $this->Form->control('branch_id', ['options' => $branchs, 'empty' => '...', 'label' => ['text' => 'Sucursal'], 'class' => 'selectpicker form-control', "data-live-search" => true, "data-dropup-auto" => "false", "data-size" => "5"]); ?>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <?= $this->Form->control('dep_id', ['options' => $departaments, 'empty' => '...', 'label' => ['text' => 'Area'], 'class' => 'selectpicker form-control', "data-live-search" => true, "data-dropup-auto" => "false", "data-size" => "5"]); ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <?= $this->Form->control('designation_id', ['options' => $designations, 'empty' => '...', 'label' => ['text' => 'Cargo'], 'class' => 'selectpicker form-control', "data-live-search" => true, "data-dropup-auto" => "false", "data-size" => "5"]); ?>
                </div>
            </div>

            <div class="col-md-12 col-sm-12 pd-20 mb-15">
                <div class="form-group">
                    <?= $this->Form->button('Crear Usuario', ['class' => 'btn btn-outline-primary']) ?>
                </div>
            </div>

        </div>
    </div>
    <?= $this->Form->end() ?>
</div>

<script>
    // date picker
    $(".date-picker-date-birthday").datepicker({
        language: "en",
        autoClose: true,
        dateFormat: "yyyy-mm-dd"
    });
</script>