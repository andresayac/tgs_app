<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Company $company
 */
?>

<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Empresas</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/companies">Empresas</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Ver</li>
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
</div>

<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-30">
        <div class="pd-20 card-box height-100-p">
        
            <h5 class="text-center h5 mb-0"></h5>
            <p class="text-center text-muted font-14">
                <strong><?= h($company->name) ?> </strong>
            </p>
            <div class="profile-info">
                <h5 class="mb-20 h5 text-blue">Información de la empresa</h5>
                <ul>
                    <li>
                        <span>País:</span>
                        <?= h($company->country) ?>
                    </li>
                    <li>
                        <span>Departamento:</span>
                        <?= h($company->state) ?>
                    </li>
                    <li>
                        <span>Ciudad:</span>
                        <?= h($company->city) ?>
                    </li>
                    <li>
                        <span>Dirección:</span>
                        <?= h($company->address) ?>
                    </li>
                    <li>
                        <span>Código Postal:</span>
                        <?= $company->zipcode === null ? '' : $company->zipcode ?>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</div>
