<?php

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
                    <li class="breadcrumb-item active" aria-current="page">Importe de Usuario</li>
                </ol>
            </nav>
        </div>
    </div>
</div>


<div class="card-box mb-30">
    <div class="pd-20">
        <h4 class="text-blue h4">Importe masivo de usuarios</h4>
    </div>
</div>

<div class="row">
    <div class="col-xl-6 col-lg-4 col-md-4 col-sm-12 mb-30">
        <div class="pd-20 card-box height-100-p">
            <div class="pd-20">
                <h4 class="text-blue h4">Cargue de Archivo</h4>
                <p class="mb-2">Solo se permite la estructura del archivo plantilla </p>
                <p class="mb-2">NO se permite usuarios con campos usuario y documento duplicados
                    en caso de error de retorna un excel con los archivos erroneos </p>
                <small class="form-text text-muted">

                </small>
                <?= $this->Form->create(null, ['type' => 'file']) ?>
                <div class="form-group">
                    <?= $this->Form->file('excel', ['label' => false, 'class' => 'form-control-file form-control height-auto', 'error' => false, 'accept' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']) ?>
                </div>
                <?= $this->Form->button('Importar', ["class" => "btn btn-primary btn-sm"]) ?>
                <?= $this->Form->end() ?>

            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-4 col-md-4 col-sm-12 mb-30">
        <div class="pd-20 card-box height-100-p">
            <div class="pd-20">
                <h4 class="text-blue h4">Descargar Plantilla</h4>
                <p class="mb-2">Descarga y completa la plantilla utilizando excel</p>
                <div class="form-group">
                    <?= $this->Form->postLink('<i class="icon-copy fa fa-file-excel-o"></i> Descargar', ['action' => 'import', 'file_download'], ['class' => 'btn btn-primary btn-sm scroll-click', 'escape' => false, 'data-toggle' => 'collapse']) ?>

                </div>
            </div>
        </div>
    </div>
</div>