<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 * @var string[]|\Cake\Collection\CollectionInterface $roles
 * @var string[]|\Cake\Collection\CollectionInterface $departaments
 * @var string[]|\Cake\Collection\CollectionInterface $branchs
 * @var string[]|\Cake\Collection\CollectionInterface $designations
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
                    <li class="breadcrumb-item active" aria-current="page">Editar Usuario</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="card-box mb-30">
    <div class="pd-20">
        <h4 class="text-blue h4">Datos del Usuario</h4>
    </div>
    <?= $this->Form->create($user) ?>
    <div class="pd-20 card-box mb-30">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label>Activo</label>
                            <?= $this->Form->select('active', ['0' => 'NO','1' => 'SI'], [ 'empty' => false, 'class' => 'selectpicker form-control', 'label' => false, 'required' => true]) ?>
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
                            <?= $this->Form->control('password', ['label' => 'Contraseña', 'class' => 'form-control', 'type' => 'password', 'value'=>'']); ?>
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
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <?= $this->Form->select('document_type', [
                                'CC' => 'CC',
                                'CE' => 'CE',
                                'Otro' => 'Otro',
                            ], ['empty' => '...', 'class' => 'selectpicker form-control', 'label' => false, 'required' => true]) ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <?= $this->Form->control('document', ['type' => 'number', 'label' => false, 'required' => true, 'error' => false, 'class' => 'form-control']) ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <?= $this->Form->control('date_birthday', ['empty' => true, 'label' => ['text' => 'Fecha de Nacimiento'], 'class' => "form-control date-picker", 'placeholder' => 'Selecione Fecha']); ?>
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
                    <?= $this->Form->button('Editar Usuario', ['class' => 'btn btn-outline-primary']) ?>
                </div>
            </div>

        </div>
    </div>
    <?= $this->Form->end() ?>
</div>
