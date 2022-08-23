<?php

$huella = $this->Text->autoParagraph(h($user->indexfinger));

?>

<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Perfil</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/"></a>Inicio</li>
                    <li class="breadcrumb-item active" aria-current="page"><?= h($user->username) ?></li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-30">
        <div class="pd-20 card-box height-100-p">
            <h5 class="text-center h5 mb-0"><?= h($user->fullname) ?></h5>
            <p class="text-center text-muted font-14">
                <strong>Rol: </strong> <?= $user->has('role') ? $this->Html->link($user->role->name, ['controller' => 'Roles', 'action' => 'view', $user->role->id]) : '' ?>
            </p>
            <div class="profile-info">
                <h5 class="mb-20 h5 text-blue">Información del Empleado</h5>
                <ul>
                    <li>
                        <span>Nombre de usuario:</span>
                        <?= h($user->username) ?>
                    </li>
                    <li>
                        <span>Documento:</span>
                        <?= h($user->document_type) ?> : <?= h($user->document) ?>
                    </li>
                    <li>
                        <span>Fecha de Nacimiento:</span>
                        <?= h($user->date_birthday) ?>
                    </li>
                    <li>
                        <span>Telefono:</span>
                        <?= h($user->telephone) ?>
                    </li>

                    <li>
                        <span>Sucursal:</span>
                        <?= $user->has('branch') ? $this->Html->link($user->branch->name, ['controller' => 'Branchs', 'action' => 'view', $user->branch->id]) : '' ?>
                    </li>

                    <li>
                        <span>Area:</span>
                        <?= $user->has('departament') ? $this->Html->link($user->departament->name, ['controller' => 'Departaments', 'action' => 'view', $user->departament->id]) : '' ?>
                    </li>


                    <li>
                        <span>Cargo:</span>
                        <?= $user->has('designation') ? $this->Html->link($user->designation->name, ['controller' => 'Designations', 'action' => 'view', $user->designation->id]) : '' ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>