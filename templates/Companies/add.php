<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Company $company
 */

$_imagen_url = empty($user->imagen) ? "" : $this->Url->image('users/' . $company->logo, ['fullBase' => true]);
?>


<script>
    // se usa en custom-file-input.js
    var default_preview_from_controller = '<?= $this->Html->image('users/default.jpg', ['width' => 200]) ?>';
    var initial_preview_from_controller = '<?= $_imagen_url ?>';
</script>

<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Empresas</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/companies">Empresas</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Nueva</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="card-box mb-30">
    <div class="pd-20">
        <h4 class="text-blue h4">Datos de la Empresa</h4>
        <p class="mb-0"></p>
    </div>
    <?= $this->Form->create($company) ?>
    <div class="pd-20 card-box mb-30">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <?= $this->Form->control('name', ['label' => 'Nombre de Empresa', 'class' => 'form-control']); ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <?= $this->Form->control('address', ['label' => 'Dirección', 'class' => 'form-control']); ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <?= $this->Form->control('city', ['label' => 'Ciudad', 'class' => 'form-control']); ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <?= $this->Form->control('state', ['label' => 'Departamento', 'class' => 'form-control']); ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <?= $this->Form->control('zipcode', ['label' => 'Ciudad', 'class' => 'form-control']); ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <?= $this->Form->control('country', ['label' => 'Departamento', 'class' => 'form-control']); ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label>Activa</label>
                            <?= $this->Form->select('active', ['0' => 'NO', '1' => 'SI'], ['empty' => false, 'class' => 'selectpicker form-control', 'label' => false, 'required' => true]) ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 pd-20 mb-15">
                    <div class="form-group">
                        <?= $this->Form->button('Crear Usuario', ['class' => 'btn btn-outline-primary']) ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>

