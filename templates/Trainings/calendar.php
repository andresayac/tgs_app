<?php echo $this->Html->css("/src/plugins/fullcalendar/fullcalendar.css"); ?>
<?php echo $this->Html->script("/src/plugins/fullcalendar/fullcalendar.min.js"); ?>

<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Calendario de Capacitaciones</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/users">Calendario</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Capacitaciones</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="pd-20 card-box mb-30">
    <div class="calendar-wrap">
        <div id="calendar"></div>
    </div>
    <!-- calendar modal -->
    <div id="modal-view-event" class="modal modal-top fade calendar-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <h4 class="h4">
                        <span class="event-icon weight-400 mr-3"></span><span class="event-title"></span>
                    </h4>
                    <div class="event-body"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="modal-view-event-add" class="modal modal-top fade calendar-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="add-event">
                    <div class="modal-body">
                        <h4 class="text-blue h4 mb-10">Add Event Detail</h4>
                        <div class="form-group">
                            <label>Event name</label>
                            <input type="text" class="form-control" name="ename" />
                        </div>
                        <div class="form-group">
                            <label>Event Date</label>
                            <input type="text" class="datetimepicker form-control" name="edate" />
                        </div>
                        <div class="form-group">
                            <label>Event Description</label>
                            <textarea class="form-control" name="edesc"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Event Color</label>
                            <select class="form-control" name="ecolor">
                                <option value="fc-bg-default">fc-bg-default</option>
                                <option value="fc-bg-blue">fc-bg-blue</option>
                                <option value="fc-bg-lightgreen">
                                    fc-bg-lightgreen
                                </option>
                                <option value="fc-bg-pinkred">fc-bg-pinkred</option>
                                <option value="fc-bg-deepskyblue">
                                    fc-bg-deepskyblue
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Event Icon</label>
                            <select class="form-control" name="eicon">
                                <option value="circle">circle</option>
                                <option value="cog">cog</option>
                                <option value="group">group</option>
                                <option value="suitcase">suitcase</option>
                                <option value="calendar">calendar</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">
                            Save
                        </button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">
                            Close
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    var targeturl = '<?= $this->Url->build(["controller" => "Trainings", "action" => "getCalendarioEvents"]) ?>';
    var token = "<?= $this->request->getParam('_csrfToken') ?>";
    var eventoAsistenciaUrl = '<?= $this->Url->build(["controller" => "Trainings", "action" => "attendance"]) ?>';
    var eventoAddUrl = '<?= $this->Url->build(["controller" => "Trainings", "action" => "add"]) ?>';


    document.addEventListener("DOMContentLoaded", function() {

        $("#calendar").fullCalendar({
            themeSystem: "bootstrap4",
            timeFormat: 'h(:mm) a',
            locale: 'es',
            height: 'auto',
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaDay'
            },
            events: {
                url: targeturl,
                method: 'POST',
                headers: {
                    "X-CSRF-Token": token
                }
            },
            dayClick: function(date, jsEvent, view) {
                // evento al hacer click sobre parte en blanco
                window.location.href = eventoAddUrl +
                    '?d=' + date.format("YYYY-MM-DD") +
                    '&t=' + date.format("HH:mm:ss");
            },

            eventClick: function(calEvent, jsEvent, view) {
                // evento al hacer click sobre un evento
                window.location.href =  eventoAsistenciaUrl + '/' + calEvent.data_id;
            },

            eventRender: function(event, el) {
                // evento al renderizar los eventos

                // agrego tooltip a cada evento dibujado
                $(el).tooltip({
                    placement: 'top',
                    title: event.title +
                        "<br>" + event.data_fecha +
                        "<br>" + event.data_horario,
                    html: true
                })
            },

        });

    });
</script>