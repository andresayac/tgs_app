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
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
            buttonText: {
                prev: 'Ant',
                next: 'Sig',
                today: 'Hoy',
                month: 'Mes',
                week: 'Semana',
                day: 'Día',
                list: 'Agenda',
            },
            buttonHints: {
                prev: '$0 antes',
                next: '$0 siguiente',
                today(buttonText) {
                    return (buttonText === 'Día') ? 'Hoy' :
                        ((buttonText === 'Semana') ? 'Esta' : 'Este') + ' ' + buttonText.toLocaleLowerCase()
                },
            },
            viewHint(buttonText) {
                return 'Vista ' + (buttonText === 'Semana' ? 'de la' : 'del') + ' ' + buttonText.toLocaleLowerCase()
            },
            weekText: 'Sm',
            weekTextLong: 'Semana',
            allDayText: 'Todo el día',
            moreLinkText: 'más',
            moreLinkHint(eventCnt) {
                return `Mostrar ${eventCnt} eventos más`
            },
            noEventsText: 'No hay eventos para mostrar',
            navLinkHint: 'Ir al $0',
            closeHint: 'Cerrar',
            timeHint: 'La hora',
            eventHint: 'Evento',
            height: 'auto',
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaDay,agendaWeek,listWeek'
            },
            events: {
                url: targeturl,
                method: 'POST',
                headers: {
                    "X-CSRF-Token": token
                }
            },
            dayClick: function(date, jsEvent, view) {
                if (moment().format('YYYY-MM-DD') <= date.format('YYYY-MM-DD')) {
                    window.location.href = eventoAddUrl +
                        '?d=' + date.format("YYYY-MM-DD") +
                        '&t=' + date.format("HH:mm:ss");

                } else {
                    alert("Selecione una fecha mayor o igual a la actual")
                }
            },

            eventClick: function(calEvent, jsEvent, view) {
                // evento al hacer click sobre un evento
                window.location.href = eventoAsistenciaUrl + '/' + calEvent.data_id;
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

        fullCalendar.globalLocales.push(function() {
            'use strict';

            var es = {
                code: 'es',
                week: {
                    dow: 1, // Monday is the first day of the week.
                    doy: 4, // The week that contains Jan 4th is the first week of the year.
                },
                buttonText: {
                    prev: 'Ant',
                    next: 'Sig',
                    today: 'Hoy',
                    month: 'Mes',
                    week: 'Semana',
                    day: 'Día',
                    list: 'Agenda',
                },
                buttonHints: {
                    prev: '$0 antes',
                    next: '$0 siguiente',
                    today(buttonText) {
                        return (buttonText === 'Día') ? 'Hoy' :
                            ((buttonText === 'Semana') ? 'Esta' : 'Este') + ' ' + buttonText.toLocaleLowerCase()
                    },
                },
                viewHint(buttonText) {
                    return 'Vista ' + (buttonText === 'Semana' ? 'de la' : 'del') + ' ' + buttonText.toLocaleLowerCase()
                },
                weekText: 'Sm',
                weekTextLong: 'Semana',
                allDayText: 'Todo el día',
                moreLinkText: 'más',
                moreLinkHint(eventCnt) {
                    return `Mostrar ${eventCnt} eventos más`
                },
                noEventsText: 'No hay eventos para mostrar',
                noEventsMessage: 'No hay eventos para mostrar',
                navLinkHint: 'Ir al $0',
                closeHint: 'Cerrar',
                timeHint: 'La hora',
                eventHint: 'Evento',
            };

            return es;

        }());

    });
</script>