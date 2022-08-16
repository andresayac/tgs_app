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
                <p class="mb-2">Solo se permite la estructura del archivo plantilla</p>
                <?= $this->Form->create(null, ['type' => 'file']) ?>
                <div class="form-group">
                    <div class="custom-file">
                        <?= $this->Form->file('excel', ['label' => false, 'error' => false, 'id' => 'img-input', 'accept' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']) ?>
                    </div>
                    <?= $this->Form->button('Buscar', ["class" => "btn btn-primary btn-sm"]) ?>
                </div>
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
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-30">
        <div class="pd-20 card-box height-100-p"></div>
    </div>
</div>