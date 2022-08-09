<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Training $training
 */

$assistants = [
    "Users" => [],
    "NewUsersAssistances" => []
];


foreach ($users as $user) {
    $assistants['Users'][$user['document']] = $user['name'] . " " . $user['lastname'];
}

$assistants['NewUsersAssistances'] = $assistants['Users'];


foreach ($assistances as $user) {
    unset($assistants['NewUsersAssistances'][$user->user->document]);
}

$trainer = explode(",", $training->trainer);

$training->set('start_hour', $training->start_date->format('H:i'));

$training->set('end_hour', $training->end_date->format('H:i'));

?>

<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Asistencia de Capacitación</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/trainings">Capacitación</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Asistencia</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="card-box mb-30">
    <div class="pd-20">
        <h4 class="text-blue h4">Datos de la Capacitación</h4>
        <p class="mb-0"></p>
    </div>
    <?= $this->Form->create($training) ?>
    <div class="pd-20 card-box mb-30">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="row">
                    <div class="col-md-8 col-sm-12">
                        <div class="form-group">
                            <?= $this->Form->control('name', ['label' => 'Nombre de Capacitación', 'class' => 'form-control', 'disabled' => true]); ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <div class="input text">
                                <label>Fecha de realización</label>
                                <?= $this->Form->input('start_date', ['type' => 'text', 'label' => false, 'class' => 'form-control date-picker-training', 'disabled' => true]) ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label>Capacitador</label>
                            <?= $this->Form->select('trainer', $assistants['Users'], ['empty' => false, 'class' => 'selectpicker form-control', 'label' => false, 'required' => true, "multiple" => true, "data-actions-box" => true, "data-live-search" => true, "value" => $trainer, 'disabled' => true]) ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label>Hora de Inicio</label>
                            <?= $this->Form->input('start_hour', ['empty' => false, 'class' => 'form-control time-picker-training select2', 'label' => false, 'required' => true, 'disabled' => true]) ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label>Hora estimada de finalización</label>
                            <?= $this->Form->input('end_hour', ['empty' => false, 'class' => 'form-control time-picker-training select2', 'label' => false, 'required' => true, 'disabled' => true]) ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label>Notas</label>
                            <?= $this->Form->input('note', ['class' => 'form-control', 'type' => 'textarea', 'disabled' => true]) ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>



<div class="card-box mb-30">
    <div class="pd-20">
        <h4 class="text-blue h4">Asistentes</h4>
        <p class="mb-0"></p>
    </div>
    <div class="pd-20 card-box mb-30">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <?= $this->Form->create($training) ?>
                <div class="form-group">
                    <label>Usuarios disponibles </label>
                    <?= $this->Form->select('new_assistances', $assistants['NewUsersAssistances'], ['empty' => false, 'class' => 'selectpicker form-control', 'label' => false, 'required' => true, "multiple" => true, "data-actions-box" => true, "data-live-search" => true]) ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <?= $this->Form->button('Agregar usuarios a la capacitación', ['class' => 'btn btn-outline-primary']) ?>
                </div>
            </div>
        </div>
    </div>
    <?= $this->Form->end() ?>

    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="dataTables_wrapper dt-bootstrap4 no-footer">
                <table id="datatable-trainings" class="data-table table stripe hover nowrap dataTable no-footer dtr-inline">
                    <thead>
                        <tr>
                            <th><?= $this->Paginator->sort('id') ?></th>
                            <th><?= $this->Paginator->sort('user_id', 'Empleado') ?></th>
                            <th><?= $this->Paginator->sort('checked', 'Asistio') ?></th>
                            <th><?= $this->Paginator->sort('type_check', 'Tipo de Verificación') ?></th>
                            <th class="actions"><?= __('Acciones') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($assistances as $training) : ?>
                            <tr>
                                <td><?= h($training->id) ?></td>
                                <td><?= $training->has('user') ? $this->Html->link($training->user->name, ['controller' => 'Users', 'action' => 'view', $training->user->id]) : '' ?></td>

                                <td><span class="badge badge-<?= ((bool) $training->checked) ? 'primary' : 'danger' ?>" id="badge-item-<?= $training->id ?>"><?= ((bool) $training->checked) ? 'Asistio' : 'No Asistio' ?></span></td>

                                <td><?= h($training->type_check) ?></td>
                                <td>
                                    <div class="table-actions">
                                        <div class="custom-control custom-checkbox mb-5">
                                            <input <?= $training->training->start_date->isToday() && !$training->checked ? "" :  "disabled" ?> <?= ($training->checked) ? 'checked' : '' ?> type="checkbox" data-assistant="<?= $training->id ?>" class="custom-control-input checks" id="checkbox-<?= $training->id ?>" data-user="<?= $training->user->id ?>">
                                            <label for="checkbox-<?= $training->id ?>" class="custom-control-label"></label>
                                        </div>


                                        <?= $this->Form->control('', [
                                            "escape" => false,
                                            'type' => 'button',
                                            "class" => "icon-copy bi bi-fingerprint",
                                            "data-toggle" => "modal",
                                            "data-target" => "#modal-1",
                                            "data-user-id" => $training->user->id,
                                            "data-training-id" => $training->id,
                                            "data-name-id" => $training->user->name,
                                            "data-color" => "#265ed7",
                                            "id" => "btn-fingerprint",
                                            "name" => "btn-fingerprint",
                                            "style" => "color: rgb(38, 94, 215); margin-right: 5px; border: none; font-size: 18px;",
                                            "disabled" => ($training->training->start_date->isToday() && !$training->checked) ? false : true
                                        ]) ?>

                                        <?php if (!$training->checked) : ?>
                                            <?= $this->Form->postLink('', ['action' => 'attendanceDelete', $training->id, $training->training_id], [
                                                'class' => 'icon-copy dw dw-delete-3',
                                                'style' => "color: rgb(233, 89, 89); margin-top: 3.1px;",
                                                'confirm' => __(
                                                    'Esta seguro que quiere eliminar el  asistente ',
                                                    $training->user->name . " " . $training->user->lastname
                                                )
                                            ])
                                            ?>
                                        <?php endif ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-1" tabindex="-1" role="dialog" aria-labelledby="modal-1Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-1Label">Verificación de huella</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php if ($training->start_date->isToday() && !$training->checked) : ?>
                    <?= $this->Form->hidden('userID', ['type' => 'text', 'id' => 'userID']) ?>
                    <?= $this->Form->hidden('TrainingID', ['type' => 'text', 'id' => 'TrainingID']) ?>
                    <?= $this->Form->hidden('userIDVerifyTMP', ['type' => 'text', 'id' => 'userIDVerifyTMP']) ?>

                    <div id="verifyIdentityStatusField" class="text-center">

                    </div>

                    <div class="col-md-12 col-sm-12">
                        <div class="form-group">
                            <label for="verifyReaderSelect" class="my-text7 my-pri-color">Elija el lector de huellas dactilares</label>
                            <select name="readerSelect" id="verifyReaderSelect" class="form-control" onclick="beginIdentification()">
                                <option selected>Selecionar...</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12">
                        <div class="form-group">
                            <input id="userIDVerify" type="hidden" class="form-control" required disabled>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12">
                        <div class="form-group">
                            <label class="my-text7 my-pri-color">Validar huella registrada</label>
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
                        <div class="col-4">
                            <?= '<button class="btn btn-success" type="submit" onclick="captureForIdentify()">Capturar Huella</button>' ?>
                        </div>
                        <div class="col-4">
                            <button class="btn btn-primary" type="submit" onclick="serverIdentifyAssistance()">Validar</button>
                        </div>
                        <div class="col-md-4 col-sm-3">
                            <button class="btn btn-dark" type="submit" onclick="clearCapture()">Limpiar Huellas</button>
                        </div>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>



<?php echo $this->Html->script("/src/scripts/fingerprint/es6-shim.js"); ?>
<?php echo $this->Html->script("/src/scripts/fingerprint/websdk.client.bundle.min.js"); ?>
<?php echo $this->Html->script("/src/scripts/fingerprint/fingerprint.sdk.min.js"); ?>
<?php echo $this->Html->script("/src/scripts/fingerprint/custom.js"); ?>


<style>
    .icon {
        display: inline-block;
        width: 64px;
        height: 64px;
        background-size: cover;
    }

    .icon-indexfinger-not-enrolled {
        background-image: url("/img/fingerprint/svg/indexfinger_not_enrolled.svg");
    }

    .icon-indexfinger-enrolled {
        background-image: url("/img/fingerprint//svg/indexfinger_enrolled.svg");
    }

    .icon-middlefinger-not-enrolled {
        background-image: url("/img/fingerprint/svg/middlefinger_not_enrolled.svg");
    }

    .icon-middlefinger-enrolled {
        background-image: url("/img/fingerprint/svg/middlefinger_enrolled.svg");
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
            background-image: url("/img/fingerprint/svg/indexfinger_not_enrolled.svg");
        }

        to {
            background-image: url("/img/fingerprint/svg/indexfinger-anim.svg");
        }
    }

    @keyframes blink-middle-finger {
        from {
            background-image: url("/img/fingerprint/svg/middlefinger_not_enrolled.svg");
        }

        to {
            background-image: url("/img/fingerprint/svg/middlefinger-anim.svg");
        }
    }
</style>

<script>
    $(document).ready(function() {

        $('.data-table').DataTable({
            scrollCollapse: true,
            autoWidth: false,
            responsive: true,
            columnDefs: [{
                targets: "datatable-nosort",
                orderable: false,
            }],
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "language": {
                "info": "_START_-_END_ de _TOTAL_ registros",
                searchPlaceholder: "Buscar",
                paginate: {
                    next: '<i class="ion-chevron-right"></i>',
                    previous: '<i class="ion-chevron-left"></i>'
                },
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            },
        });
    });
</script>



<?php if ($training->training->start_date->isToday()) : ?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {


            $('.modal').appendTo("body");

            $('#modal-1').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget)
                var modal = $(this)

                var user_id = button.data('user-id')
                var training_id = button.data('training-id')


                modal.find('#userIDVerify').val(user_id);
                modal.find('#userIDVerifyTMP').val(user_id);
                modal.find('#TrainingID').val(training_id);
            })

            $('#modal-1').on('hide.bs.modal', function(event) {
                var button = $(event.relatedTarget)
                var modal = $(this)
                clearCapture();
            })

            $('.checks').change(function() {
                if (this.checked) {
                    fn_asistencia(this, "asistir");
                } else {
                    fn_asistencia(this, "no_asistir");
                }
            });

            var fn_asistencia = function(check, accion_str) {

                var _check = check;
                var _action = accion_str
                var data_user = $(_check).data('user');
                var data_assistant = $(_check).data('assistant');


                var targeturl = '<?= $this->Url->build(["controller" => "Trainings", "action" => "attendanceSave"]) ?>';
                var token = "<?= $this->request->getParam('_csrfToken') ?>";

                $('.cargando-' + data_user).show();
                $(_check).prop("disabled", true);

                $.ajax({
                    type: 'post',
                    beforeSend: function(request) {
                        request.setRequestHeader("X-CSRF-Token", token);
                    },
                    url: targeturl,
                    data: {
                        user_id: data_user,
                        assistant_id: data_assistant,
                        accion: _action
                    },
                    success: function(result) {
                        if (result !== "success") {
                            location.reload();
                        }
                        $(_check).prop("disabled", false);

                        const text = (_action === "asistir") ? 'Asistio' : 'No Asistio';
                        const type = (_action === "asistir") ? 'badge badge-primary' : 'badge btn-danger';;
                        const query = '#badge-item-' + data_assistant;
                        $(query).removeAttr('class').attr('class', type).text(text);

                        (_action === "asistir") ? $("#btn-fingerprint").removeAttr('disable').attr('disabled', true): $("#btn-fingerprint").removeAttr('disable').attr('disabled', false);


                    }
                });

            }

        });
    </script>
<?php endif ?>