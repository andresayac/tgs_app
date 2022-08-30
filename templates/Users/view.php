<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */

use function PHPUnit\Framework\isEmpty;

$huella = $this->Text->autoParagraph(h($user->indexfinger));

?>

<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Visualización de Usuario</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/users">Usuarios</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= h($user->username) ?></li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="card-box mb-30">
    <div class="pd-20">
        <h4 class="text-blue h4">Datos del Usuario</h4>
        <p class="mb-0"></p>
    </div>
</div>

<div class="row">
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
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

    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-30">
        <div class="card-box height-100-p overflow-hidden">
            <div class="profile-tab height-100-p">
                <div class="tab height-100-p">
                    <ul class="nav nav-tabs customtab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link <?= (empty($huella)) ? 'active': '' ?>" data-toggle="tab" href="#enroll" role="tab"><?= (empty($huella)) ? 'Agregar Huella' : 'Editar Huella' ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= (!empty($huella)) ? 'active': '' ?>" data-toggle="tab" href="#verify" role="tab">Verificar Huella</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <!-- Timeline Tab start -->
                        <div class="tab-pane fade show active" id="enroll" role="tabpanel">
                            <div class="profile-setting">
                                <form action="#" onsubmit="return false">
                                    <ul class="profile-edit-list row">
                                        <li class="weight-500 col-md-12">
                                            <div id="enrollmentStatusField" class="text-center">
                                                <!--Enrollment Status will be displayed Here-->
                                            </div>
                                            <h4 class="text-blue h5 mb-20">
                                                <?= (empty($huella)) ? 'Enrolar' : 'Editar' ?> Empleado
                                            </h4>
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="enrollReaderSelect" class="my-text7 my-pri-color">Elija el lector de huellas dactilares</label>
                                                        <select name="readerSelect" id="enrollReaderSelect" class="form-control" onclick="beginEnrollment()">
                                                            <option selected>Selecionar...</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label for="userID" class="my-text7 my-pri-color"></label>
                                                        <input id="userID" type="hidden" class="form-control" value="<?= h($user->id) ?>" required disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="my-text7 my-pri-color"><strong>Dedo índice</strong></label>
                                                        <div class="row justify-content-center" id="indexFingers">
                                                            <div id="indexfinger1">
                                                                <span class="icon icon-indexfinger-not-enrolled" title="not_enrolled"></span>
                                                            </div>
                                                            <div id="indexfinger2">
                                                                <span class="icon icon-indexfinger-not-enrolled" title="not_enrolled"></span>
                                                            </div>
                                                            <div id="indexfinger3">
                                                                <span class="icon icon-indexfinger-not-enrolled" title="not_enrolled"></span>
                                                            </div>
                                                            <div id="indexfinger4">
                                                                <span class="icon icon-indexfinger-not-enrolled" title="not_enrolled"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="my-text7 my-pri-color"><strong>Otro Dedo</strong> </label>
                                                        <div class="row justify-content-center" id="middleFingers">
                                                            <div id="middleFinger1">
                                                                <span class="icon icon-middlefinger-not-enrolled" title="not_enrolled"></span>
                                                            </div>
                                                            <div id="middleFinger2">
                                                                <span class="icon icon-middlefinger-not-enrolled" title="not_enrolled"></span>
                                                            </div>
                                                            <div id="middleFinger3">
                                                                <span class="icon icon-middlefinger-not-enrolled" title="not_enrolled"></span>
                                                            </div>
                                                            <div id="middleFinger4">
                                                                <span class="icon icon-middlefinger-not-enrolled" title="not_enrolled"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <div class="row justify-content-center">

                                                            <div class="col-4 col-sm-2">
                                                                <button class="btn btn-success" type="submit" onclick="beginCapture(<?= h($user->id) ?>)">Capturar</button>
                                                            </div>
                                                            <div class="col-4 col-sm-2">
                                                                <button class="btn btn-primary" type="submit" onclick="serverEnroll()">Enrolar</button>
                                                            </div>
                                                            <div class="col-4 col-sm-2">
                                                                <button class="btn btn-dark" type="submit" onclick="clearCapture()">Limpiar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>


                                </form>
                            </div>
                        </div>
                        <div class="tab-pane fade show" id="verify" role="tabpanel">

                            <div class="profile-setting">
                                <form action="#" onsubmit="return false">
                                    <ul class="profile-edit-list row">
                                        <li class="weight-500 col-md-12">
                                            <div id="verifyIdentityStatusField" class="text-center">
                                                <!--verifyIdentity Status will be displayed Here-->
                                            </div>



                                            <h4 class="text-blue h5 mb-20" id="verifyIdentityTitle">
                                                Validar huella de empleado
                                            </h4>


                                            <div class="col-md-12 col-sm-12">
                                                <div class="form-group">
                                                    <label for="verifyReaderSelect" class="my-text7 my-pri-color">Elija el lector de huellas dactilares</label>
                                                    <select name="readerSelect" id="verifyReaderSelect" class="form-control" onclick="beginIdentification()">
                                                        <option selected>Selecionar...</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <input id="userIDVerify" type="hidden" class="form-control" value="<?= h($user->id) ?>" required disabled>
                                            <input id="userIDVerifyTMP" type="hidden" class="form-control" value="<?= h($user->id) ?>" required disabled>



                                            <div class="col-md-12 col-sm-12">
                                                <div class="form-group">
                                                    <label class="my-text7 my-pri-color">Validar dedo indice</label>
                                                    <div id="verificationFingers" class="form-row justify-content-center">
                                                        <div id="verificationFinger" class="col mb-md-0 text-center">
                                                            <span class="icon icon-indexfinger-not-enrolled" title="not_enrolled"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="form-row mt-3" id="userDetails">
                                                <!--this is where user details will be displayed-->
                                            </div>


                                            <div class="form-row m-3 mt-md-5 justify-content-center">
                                                <div class="col-4 col-sm-2">
                                                    <button class="btn btn-success" data-toggle="tooltip" title="Iniciar captura de huella" type="submit" onclick="captureForIdentify(<?= h($user->id) ?>)">Capturar</button>
                                                </div>
                                                <div class="col-4 col-sm-2">
                                                    <button class="btn btn-primary" data-toggle="tooltip" title="Validar huella" type="submit" onclick="serverIdentify()">Validar</button>
                                                </div>
                                                <div class="col-4 col-sm-2">
                                                    <button class="btn btn-dark" type="submit" onclick="clearCapture()">Limpiar</button>
                                                </div>
                                            </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if(!empty($huella)) echo "
<script>
iziToast.info({
    // title: 'Hey',
    position: 'bottomRight',
    message: 'Este Usuario ya tiene Huella vinculada'
});
</script>"; 
?>

<?php echo $this->Html->script("/src/scripts/fingerprint/es6-shim.js"); ?>
<?php echo $this->Html->script("/src/scripts/fingerprint/websdk.client.bundle.min.js"); ?>
<?php echo $this->Html->script("/src/scripts/fingerprint/fingerprint.sdk.min.js"); ?>
<?php echo $this->Html->script("/src/scripts/fingerprint/custom.js"); ?>


<style>
    .icon {
        display: inline-block;
        width: 70px;
        height: 70px;
        background-size: cover;
    }

    .icon-indexfinger-not-enrolled {
        background-image: url("/img/fingerprint/svg/fingerprint_not_enrolled.svg");
    }

    .icon-indexfinger-enrolled {
        background-image: url("/img/fingerprint/svg/fingerprint_enrolled.svg");
    }

    .icon-middlefinger-not-enrolled {
        background-image: url("/img/fingerprint/svg/fingerprint_not_enrolled.svg");
    }

    .icon-middlefinger-enrolled {
        background-image: url("/img/fingerprint/svg/fingerprint_enrolled.svg");
    }

    .capture-indexfinger {
        animation-duration: 500ms;
        animation-name: blink-index-finger;
        animation-iteration-count: infinite;
    }

    .capture-middlefinger {
        animation-duration: 500ms;
        animation-name: blink-middle-finger;
        animation-iteration-count: infinite;
    }

    @keyframes blink-index-finger {
        from {
            background-image: url("/img/fingerprint/svg/fingerprint_not_enrolled.svg");
        }

        to {
            background-image: url("/img/fingerprint/svg/fingerprint_anim.svg");
        }
    }

    @keyframes blink-middle-finger {
        from {
            background-image: url("/img/fingerprint/svg/fingerprint_not_enrolled.svg");
        }

        to {
            background-image: url("/img/fingerprint/svg/fingerprint_anim.svg");
        }
    }
</style>