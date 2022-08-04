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
                            <label style="display: block;">Estado</label>
                            <?= $this->Form->checkbox('active', ['hiddenField' => false, 'checked' => true, 'class' => 'switch-btn form-control', 'data-color' => '#0099ff']) ?>
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
                    <?= $this->Form->control('branch_id', ['options' => $branchs, 'empty' => '...', 'label' => ['text' => 'Sucursal'], 'class' => 'selectpicker form-control']); ?>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <?= $this->Form->control('dep_id', ['options' => $departaments, 'empty' => '...', 'label' => ['text' => 'Area'], 'class' => 'selectpicker form-control']); ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <?= $this->Form->control('designation_id', ['options' => $designations, 'empty' => '...', 'label' => ['text' => 'Cargo'], 'class' => 'selectpicker form-control']); ?>
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

<?php echo $this->Html->css("/src/plugins/switchery/switchery.min.css"); ?>
<?php echo $this->Html->script("/src/plugins/switchery/switchery.min.js"); ?>

<script>
    var elems = Array.prototype.slice.call(document.querySelectorAll('.switch-btn'));
    $('.switch-btn').each(function() {
        new Switchery($(this)[0], $(this).data());
    });
</script>
