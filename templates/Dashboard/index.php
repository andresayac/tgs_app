<?php

$meses = [1 => 'Ene', 2 => 'Feb', 3 => 'Mar', 4 => 'May', 5 => 'Abr', 6 => 'Jun', 7 => 'Jul', 8 => 'Ago', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dic'];
$dias = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];

$month_categories = [];
$data_report = [
    ['name' => 'Capacitaciones'],
    ['name' => 'Asistentes Cofirmados'],
    ['name' => 'Asistentes no Cofirmado']
];


foreach ($trainings_month_chart ?? [] as $key => $value) {
    $month_categories[] = $meses[$value['month']];
    $data_report[0]['data'][] = (int) $value['total'];
}

foreach ($trainings_assistence_chart ?? [] as $value) {
    $data_report[1]['data'][] = (int) $value['assistances_yes'];
    $data_report[2]['data'][] = (int) $value['assistances_not'];
}


?>


<div class="xs-pd-20-10 pd-ltr-20">
    <div class="title pb-20">
        <h2 class="h3 mb-0">Actividad</h2>
    </div>

    <div class="row pb-10">
        <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
            <div class="card-box height-100-p widget-style3">
                <div class="d-flex flex-wrap">
                    <div class="widget-data">
                        <div class="weight-700 font-24 text-dark"><?php echo (!empty($trainings_counts)) ? $trainings_counts : 0; ?></div>
                        <div class="font-14 text-secondary weight-500">
                            Total Capacitaciones
                        </div>
                    </div>
                    <div class="widget-icon">
                        <div class="icon" data-color="#00eccf">
                            <i class="icon-copy dw dw-calendar-6"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
            <div class="card-box height-100-p widget-style3">
                <div class="d-flex flex-wrap">
                    <div class="widget-data">
                        <div class="weight-700 font-24 text-dark"><?php echo (!empty($trainings_month)) ? $trainings_month : 0; ?></div>
                        <div class="font-14 text-secondary weight-500">
                            Capacitaciones del mes
                        </div>
                    </div>
                    <div class="widget-icon">
                        <div class="icon" data-color="#ff5b5b">
                            <span class="icon-copy dw dw-calendar-3"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
            <div class="card-box height-100-p widget-style3">
                <div class="d-flex flex-wrap">
                    <div class="widget-data">
                        <div class="weight-700 font-24 text-dark"><?php echo (!empty($users_counts)) ? $users_counts : 0; ?></div>
                        <div class="font-14 text-secondary weight-500">
                            Total de Usuarios
                        </div>
                    </div>
                    <div class="widget-icon">
                        <div class="icon">
                            <i class="icon-copy fa fa-user" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
            <div class="card-box height-100-p widget-style3">
                <div class="d-flex flex-wrap">
                    <div class="widget-data">
                        <div class="weight-700 font-24 text-dark"><?php echo (!empty($users_month)) ? $users_month : 0; ?></div>
                        <div class="font-14 text-secondary weight-500">Usuarios creados en el mes</div>
                    </div>
                    <div class="widget-icon">
                        <div class="icon" data-color="#09cc06">
                            <i class="icon-copy fa fa-user-plus" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-8 mb-30">
            <div class="card-box height-100-p pd-20">
                <h2 class="h4 mb-20">Capacitaciones del Año</h2>
                <div id="chart5"></div>
            </div>
        </div>
        <div class="col-xl-4 mb-30">
            <div class="card-box height-100-p pd-20">
                <h2 class="h4 mb-20">Descarga de capacitaciones</h2>
                <div class="form-group">
                    <?= $this->Form->create(null, ['type' => 'file']) ?>
                    <div class="form-group">
                        <label>Rango de Capacitaciones</label>
                        <?= $this->Form->input('rango_reporte', ['type' => 'text', 'label' => false, 'class' => 'form-control datetimepicker-range-report']) ?>
                    </div>
                    <?= $this->Form->button('Descargar Reporte', ["class" => "btn btn-primary btn-sm"]) ?>
                    <?= $this->Html->link('Limpiar filtros', ['action' => 'index'], ["class" => "btn btn-danger btn-sm"]) ?>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </div>


</div>


<?php echo $this->Html->script("/src/plugins/apexcharts/apexcharts.min.js"); ?>
<script>
    $(document).ready(function() {
        $(".datetimepicker-range-report").datepicker({
            language: "en",
            range: true,
            multipleDates: true,
            multipleDatesSeparator: " - ",
            dateFormat: "yyyy-mm-dd",
            maxDate: new Date(),
        });


        var data_report = <?= json_encode($data_report) ?>;
        var month_categories = <?= json_encode($month_categories) ?>;

        var options5 = {
            chart: {
                height: 350,
                type: 'bar',
                parentHeightOffset: 0,
                fontFamily: 'Poppins, sans-serif',
                toolbar: {
                    show: false,
                },
            },
            colors: ['#6c757d', '#1b00ff', '#f56767'],
            grid: {
                borderColor: '#c7d2dd',
                strokeDashArray: 5,
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '25%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            series: data_report,
            xaxis: {
                categories: month_categories,
                labels: {
                    style: {
                        colors: ['#353535'],
                        fontSize: '16px',
                    },
                },
                axisBorder: {
                    color: '#8fa6bc',
                }
            },
            yaxis: {
                title: {
                    text: ''
                },
                labels: {
                    style: {
                        colors: '#353535',
                        fontSize: '16px',
                    },
                },
                axisBorder: {
                    color: '#f00',
                }
            },
            legend: {
                horizontalAlign: 'right',
                position: 'top',
                fontSize: '16px',
                offsetY: 0,
                labels: {
                    colors: '#353535',
                },
                markers: {
                    width: 10,
                    height: 10,
                    radius: 15,
                },
                itemMargin: {
                    vertical: 0
                },
            },
            fill: {
                opacity: 1

            },
            tooltip: {
                style: {
                    fontSize: '15px',
                    fontFamily: 'Poppins, sans-serif',
                },
                y: {
                    formatter: function(val) {
                        return val
                    }
                }
            }
        }
        var chart5 = new ApexCharts(document.querySelector("#chart5"), options5);
        chart5.render();


    })
</script>