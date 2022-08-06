<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Branch $branch
 * @var \Cake\Collection\CollectionInterface|string[] $companies
 */
?>

<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Nueva Sucursal</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/branchs">Sucursal</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Nueva</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="card-box mb-30">
    <div class="pd-20">
        <h4 class="text-blue h4">Datos de la Sucursal</h4>
        <p class="mb-0"></p>
    </div>
    <?= $this->Form->create($branch) ?>
    <div class="pd-20 card-box mb-30">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <?= $this->Form->control('name', ['label' => 'Nombre de la Sucursal', 'class' => 'form-control']); ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <label>Activa</label>
                        <?= $this->Form->select('active', ['0' => 'NO', '1' => 'SI'], ['empty' => false, 'class' => 'selectpicker form-control', 'label' => false, 'required' => true]) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <?= $this->Form->control('com_id', ['options' => $companies, 'empty' => false, 'label' => ['text' => 'Empresa'], 'class' => 'selectpicker form-control']); ?>
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
                        <?= $this->Form->button('Crear Sucursal', ['class' => 'btn btn-outline-primary']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>