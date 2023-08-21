<!--
* Copyright 2019 Klever Santiago Vaca Muela
-->

<!-- pageContent -->

<section class="full-width pageContent">
    <section class="full-width header-well">
        <div class="full-width header-well-icon">
            <i class="zmdi zmdi-chart"></i>
        </div>
        <div class="full-width header-well-text">
            <p class="text-condensedLight">
                REPORTE DE PEDIDOS
            </p>
        </div>
    </section>
    <div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
        <div class="mdl-tabs__panel is-active" id="KsvmReporteCompras">
            <div class="mdl-grid">
                <div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop expand">
                    <div class="" style="float:left;">
                        <!-- Formulario de busqueda -->
                        <form data-form="" action="" method="POST" autocomplete="off" enctype="multipart/form-data">
                            <div class="mdl-textfield mdl-js-textfield">
                                <article class="full-width tile-buscar-est">
                                    <div class="mdl-textfield--expandable">
                                        <strong class="hide-on-tablet">Busqueda:</strong>
                                        <hr>
                                        <div class="mdl-textfield mdl-js-textfield">
                                            <select class="ksvmSelectDin" name="KsvmTipo" id="KsvmDato1"
                                                style="width:100%;">
                                                <option value="" selected="">Seleccione Tipo</option>
                                                <option value="1">Pedidos</option>
                                            </select>
                                        </div>
                                        <div class="mdl-textfield mdl-js-textfield">
                                            <select class="ksvmSelectDin" name="KsvmMdcId" id="KsvmExtId"
                                                style="width:100%;">
                                                <option value="" selected="">Seleccione Medicamento</option>
                                                <?php require_once "./Controladores/KsvmMedicamentoControlador.php";
													$KsvmSelMed = new KsvmMedicamentoControlador();
													echo $KsvmSelMed->__KsvmSeleccionarMedicamento();
													?>
                                            </select>
                                            <span id="KsvmError1" class="ValForm"><i
                                                    class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
                                                    campo</i></span>
                                        </div>
                                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                            <input class="mdl-textfield__input" type="text" id="KsvmDato2"
                                                pattern="-?[0-9]{4,4}" name="KsvmAnio">
                                            <label class="mdl-textfield__label" for="KsvmDato2">Año</label>
                                            <span class="mdl-textfield__error">Año Inválido</span>
                                        </div>&nbsp;
                                    </div>
                                    <button type="submit" style="float:right;" class="btn btn-info"
                                        for="KsvmBuscarCompra">
                                        <i class="zmdi zmdi-search">&nbsp;<strong
                                                class="hide-on-tablet">BUSCAR</strong></i>
                                    </button>
                                </article>
                                <div class="mdl-textfield--expandable " style="margin-top:30px; right:20px;">
                                    <a href="<?php echo KsvmServUrl;?>KsvmReporteEstadistico/1/" id="btn-input"
                                        style="width:90%;"
                                        class="btn btn-md btn-dark mdl-shadow--8dp hide-on-tablet">MENU
                                        PRINCIPAL&nbsp;<i class="zmdi zmdi-arrow-left"></i></a>
                                </div>
                            </div>
                            <div class="RespuestaAjax"></div>
                        </form>
                    </div>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <figure class="highcharts-figure">
                    <div id="container" class="full-width">                        
                        <p class="highcharts-description">
                           No se encuentran registros que mostrar....
                        </p>
                        </div>
                    </figure>

                    <!-- Método para mostrar la lista de Compras -->
                    <?php
                    require_once "./Controladores/KsvmRequisicionControlador.php";
                    $KsvmIniComp = new KsvmRequisicionControlador();

                    if (isset($_POST['KsvmTipo']) && $_POST['KsvmTipo'] == 1) {

					if (isset($_POST['KsvmMdcId']) && $_POST['KsvmMdcId'] != null && isset($_POST['KsvmAnio']) && $_POST['KsvmAnio'] != null) {

                        $_SESSION['KsvmMdcId'] = $_POST['KsvmMdcId'];
                        $_SESSION['KsvmAnio'] = $_POST['KsvmAnio'];

                        $KsvmMedicamento = $KsvmIniComp -> __KsvmMuestraMedicamento($_SESSION['KsvmMdcId']);

                        // Reporte estadistico de acuerdo al valor de la compra

                        $KsvmTotRegVal = $KsvmIniComp -> __KsvmTotalRegistros($_SESSION['KsvmMdcId'], $_SESSION['KsvmAnio'], 1);
                        $KsvmDataEne = $KsvmIniComp -> __KsvmCargarReportePedidos($_SESSION['KsvmMdcId'], $_SESSION['KsvmAnio'], $KsvmTotRegVal, "January", 1);
                        if (is_numeric($KsvmDataEne)) {
                            $KsvmEneVal = "{name: 'Enero', y: ".$KsvmDataEne.", drilldown: 'Enero'},";
                        } 

                        $KsvmTotRegVal = $KsvmIniComp -> __KsvmTotalRegistros($_SESSION['KsvmMdcId'], $_SESSION['KsvmAnio'], 1);
                        $KsvmDataFeb = $KsvmIniComp -> __KsvmCargarReportePedidos($_SESSION['KsvmMdcId'], $_SESSION['KsvmAnio'], $KsvmTotRegVal, "February", 1);
                        if (is_numeric($KsvmDataFeb)) {
                        $KsvmFebVal = "{name: 'Febrero', y: ".$KsvmDataFeb.", drilldown: 'Febrero'},";
                        }

                        $KsvmTotRegVal = $KsvmIniComp -> __KsvmTotalRegistros($_SESSION['KsvmMdcId'], $_SESSION['KsvmAnio'], 1);
                        $KsvmDataMar = $KsvmIniComp -> __KsvmCargarReportePedidos($_SESSION['KsvmMdcId'], $_SESSION['KsvmAnio'], $KsvmTotRegVal, "March", 1);
                        if (is_numeric($KsvmDataMar)) {
                        $KsvmMarVal = "{name: 'Marzo', y: ".$KsvmDataMar.", drilldown: 'Marzo'},";
                        }

                        $KsvmTotRegVal = $KsvmIniComp -> __KsvmTotalRegistros($_SESSION['KsvmMdcId'], $_SESSION['KsvmAnio'], 1);
                        $KsvmDataApr = $KsvmIniComp -> __KsvmCargarReportePedidos($_SESSION['KsvmMdcId'], $_SESSION['KsvmAnio'], $KsvmTotRegVal, "April", 1);
                        if (is_numeric($KsvmDataApr)) {
                        $KsvmAprVal = "{name: 'Abril', y: ".$KsvmDataApr.", drilldown: 'Abril'},";
                        }

                        $KsvmTotRegVal = $KsvmIniComp -> __KsvmTotalRegistros($_SESSION['KsvmMdcId'], $_SESSION['KsvmAnio'], 1);
                        $KsvmDataMay = $KsvmIniComp -> __KsvmCargarReportePedidos($_SESSION['KsvmMdcId'], $_SESSION['KsvmAnio'], $KsvmTotRegVal, "May", 1);
                        if (is_numeric($KsvmDataMay)) {
                        $KsvmMayVal = "{name: 'Mayo', y: ".$KsvmDataMay.", drilldown: 'Mayo'},";
                        }

                        $KsvmTotRegVal = $KsvmIniComp -> __KsvmTotalRegistros($_SESSION['KsvmMdcId'], $_SESSION['KsvmAnio'], 1);
                        $KsvmDataJun = $KsvmIniComp -> __KsvmCargarReportePedidos($_SESSION['KsvmMdcId'], $_SESSION['KsvmAnio'], $KsvmTotRegVal, "June", 1);
                        if (is_numeric($KsvmDataJun)) {
                        $KsvmJunVal = "{name: 'Junio', y: ".$KsvmDataJun.", drilldown: 'Junio'},";
                        }

                        $KsvmTotRegVal = $KsvmIniComp -> __KsvmTotalRegistros($_SESSION['KsvmMdcId'], $_SESSION['KsvmAnio'], 1);
                        $KsvmDataJul = $KsvmIniComp -> __KsvmCargarReportePedidos($_SESSION['KsvmMdcId'], $_SESSION['KsvmAnio'], $KsvmTotRegVal, "July", 1);
                        if (is_numeric($KsvmDataJul)) {
                        $KsvmJulVal = "{name: 'Julio', y: ".$KsvmDataJul.", drilldown: 'Julio'},";
                        }

                        $KsvmTotRegVal = $KsvmIniComp -> __KsvmTotalRegistros($_SESSION['KsvmMdcId'], $_SESSION['KsvmAnio'], 1);
                        $KsvmDataAgo = $KsvmIniComp -> __KsvmCargarReportePedidos($_SESSION['KsvmMdcId'], $_SESSION['KsvmAnio'], $KsvmTotRegVal, "August", 1);
                        if (is_numeric($KsvmDataAgo)) {
                        $KsvmAgoVal = "{name: 'Agosto', y: ".$KsvmDataAgo.", drilldown: 'Agosto'},";
                        }

                        $KsvmTotRegVal = $KsvmIniComp -> __KsvmTotalRegistros($_SESSION['KsvmMdcId'], $_SESSION['KsvmAnio'], 1);
                        $KsvmDataSep = $KsvmIniComp -> __KsvmCargarReportePedidos($_SESSION['KsvmMdcId'], $_SESSION['KsvmAnio'], $KsvmTotRegVal, "September", 1);
                        if (is_numeric($KsvmDataSep)) {
                        $KsvmSepVal = "{name: 'Septiembre', y: ".$KsvmDataSep.", drilldown: 'Septiembre'},";
                        }

                        $KsvmTotRegVal = $KsvmIniComp -> __KsvmTotalRegistros($_SESSION['KsvmMdcId'], $_SESSION['KsvmAnio'], 1);
                        $KsvmDataOct = $KsvmIniComp -> __KsvmCargarReportePedidos($_SESSION['KsvmMdcId'], $_SESSION['KsvmAnio'], $KsvmTotRegVal, "October", 1);
                        if (is_numeric($KsvmDataOct)) {
                        $KsvmOctVal = "{name: 'Octubre', y: ".$KsvmDataOct.", drilldown: 'Octubre'},";
                        }

                        $KsvmTotRegVal = $KsvmIniComp -> __KsvmTotalRegistros($_SESSION['KsvmMdcId'], $_SESSION['KsvmAnio'], 1);
                        $KsvmDataNov = $KsvmIniComp -> __KsvmCargarReportePedidos($_SESSION['KsvmMdcId'], $_SESSION['KsvmAnio'], $KsvmTotRegVal, "November", 1);
                        if (is_numeric($KsvmDataNov)) {
                        $KsvmNovVal = "{name: 'Noviembre', y: ".$KsvmDataNov.", drilldown: 'Noviembre'},";
                        }

                        $KsvmTotRegVal = $KsvmIniComp -> __KsvmTotalRegistros($_SESSION['KsvmMdcId'], $_SESSION['KsvmAnio'], 1);
                        $KsvmDataDec = $KsvmIniComp -> __KsvmCargarReportePedidos($_SESSION['KsvmMdcId'], $_SESSION['KsvmAnio'], $KsvmTotRegVal, "December", 1);
                        if (is_numeric($KsvmDataDec)) {
                        $KsvmDecVal = "{name: 'Diciembre', y: ".$KsvmDataDec.", drilldown: 'Diciembre'}";
                        }
                     
                    }
                       
				    ?>

                    <?php 
                        require_once "./Controladores/KsvmBodegaControlador.php";
                        $KsvmIniComp = new KsvmBodegaControlador();
                        $KsvmDataBodega = $KsvmIniComp->__KsvmCargaBodega();
                        ?>

                    <script type="text/javascript">
                        // Create the chart
                        Highcharts.chart('container', {
                            chart: {
                                type: 'column'
                            },
                            title: {
                                text: 'Reporte de Pedido de medicamentos mensual'
                            },
                            subtitle: {
                                text: 'Datos estadisticos del Medicamento : <?php echo $KsvmMedicamento['MdcDescMed'].' '.$KsvmMedicamento['MdcConcenMed']?>'
                            },
                            accessibility: {
                                announceNewData: {
                                    enabled: true
                                }
                            },
                            xAxis: {
                                type: 'category'
                            },
                            yAxis: {
                                title: {
                                    text: 'Poercentaje total de pedidos'
                                }

                            },
                            legend: {
                                enabled: false
                            },
                            plotOptions: {
                                series: {
                                    borderWidth: 0,
                                    dataLabels: {
                                        enabled: true,
                                        format: '{point.y:.1f}%'
                                    }
                                }
                            },

                            tooltip: {
                                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> en total<br/>'
                            },

                            series: [{
                                name: "Meses",
                                colorByPoint: true,
                                data: [

                                    <?php
                                    echo $KsvmEneVal;
                                    echo $KsvmFebVal;
                                    echo $KsvmMarVal;
                                    echo $KsvmAprVal;
                                    echo $KsvmMayVal;
                                    echo $KsvmJunVal;
                                    echo $KsvmJulVal;
                                    echo $KsvmAgoVal;
                                    echo $KsvmSepVal;
                                    echo $KsvmOctVal;
                                    echo $KsvmNovVal;
                                    echo $KsvmDecVal; 
                                    ?>
                                ]
                            }],
                            drilldown: {
                                series: [{
                                        name: "Enero",
                                        id: "Enero",
                                        data: [
                                            [
                                                "Semana1",
                                                19.1
                                            ],
                                            [
                                                "Semana2",
                                                30.3
                                            ],
                                            [
                                                "Semana3",
                                                33.02
                                            ],
                                            [
                                                "Semana4",
                                                17.4
                                            ]
                                        ]
                                    },
                                    {
                                        name: "Febrero",
                                        id: "Febrero",
                                        data: [
                                            [
                                                "Semana1",
                                                13.02
                                            ],
                                            [
                                                "Semana2",
                                                7.36
                                            ],
                                            [
                                                "Semana3",
                                                43.35
                                            ],
                                            [
                                                "Semana4",
                                                20.11
                                            ]
                                        ]
                                    },
                                    {
                                        name: "Marzo",
                                        id: "Marzo",
                                        data: [
                                            [
                                                "Semana1",
                                                18.39
                                            ],
                                            [
                                                "Semana2",
                                                19.96
                                            ],
                                            [
                                                "Semana3",
                                                33.36
                                            ],
                                            [
                                                "Semana4",
                                                20.54
                                            ]
                                        ]
                                    },
                                    {
                                        name: "Abril",
                                        id: "Abril",
                                        data: [
                                            [
                                                "Semana1",
                                                12.6
                                            ],
                                            [
                                                "Semana2",
                                                10.92
                                            ],
                                            [
                                                "Semana3",
                                                20.4
                                            ],
                                            [
                                                "Semana4",
                                                30.1
                                            ]
                                        ]
                                    },
                                    {
                                        name: "Mayo",
                                        id: "Mayo",
                                        data: [
                                            [
                                                "Semana1",
                                                12.96
                                            ],
                                            [
                                                "Semana2",
                                                11.82
                                            ],
                                            [
                                                "Semana3",
                                                18.14
                                            ],
                                            [
                                                "Semana4",
                                                44.19
                                            ]
                                        ]
                                    },
                                    {
                                        name: "Junio",
                                        id: "Junio",
                                        data: [
                                            [
                                                "Semana1",
                                                9,96
                                            ],
                                            [
                                                "Semana2",
                                                33.82
                                            ],
                                            [
                                                "Semana3",
                                                24.34
                                            ],
                                            [
                                                "Semana4",
                                                10.14
                                            ]
                                        ]
                                    },
                                    {
                                        name: "Julio",
                                        id: "Julio",
                                        data: [
                                            [
                                                "Semana1",
                                                22.96
                                            ],
                                            [
                                                "Semana2",
                                                31.82
                                            ],
                                            [
                                                "Semana3",
                                                22.24
                                            ],
                                            [
                                                "Semana4",
                                                17.04
                                            ]
                                        ]
                                    },
                                    {
                                        name: "Agosto",
                                        id: "Agosto",
                                        data: [
                                            [
                                                "Semana1",
                                                15.96
                                            ],
                                            [
                                                "Semana2",
                                                20.82
                                            ],
                                            [
                                                "Semana3",
                                                11.54
                                            ],
                                            [
                                                "Semana4",
                                                44.18
                                            ]
                                        ]
                                    },
                                    {
                                        name: "Septiembre",
                                        id: "Septiembre",
                                        data: [
                                            [
                                                "Semana1",
                                                23.96
                                            ],
                                            [
                                                "Semana2",
                                                44.82
                                            ],
                                            [
                                                "Semana3",
                                                10.11
                                            ],
                                            [
                                                "Semana4",
                                                18.33
                                            ]
                                        ]
                                    },
                                    {
                                        name: "Octubre",
                                        id: "Octubre",
                                        data: [
                                            [
                                                "Semana1",
                                                10.96
                                            ],
                                            [
                                                "Semana2",
                                                18.82
                                            ],
                                            [
                                                "Semana3",
                                                21.29
                                            ],
                                            [
                                                "Semana4",
                                                29.31
                                            ]
                                        ]
                                    },
                                    {
                                        name: "Noviembre",
                                        id: "Noviembre",
                                        data: [
                                            [
                                                "Semana1",
                                                10.96
                                            ],
                                            [
                                                "Semana2",
                                                16.82
                                            ],
                                            [
                                                "Semana3",
                                                21.44
                                            ],
                                            [
                                                "Semana4",
                                                10.33
                                            ]
                                        ]
                                    },
                                    {
                                        name: "Diciembre",
                                        id: "Diciembre",
                                        data: [
                                            [
                                                "Semana1",
                                                21.96
                                            ],
                                            [
                                                "Semana2",
                                                35.82
                                            ],
                                            [
                                                "Semana3",
                                                15.66
                                            ],
                                            [
                                                "Semana4",
                                                16.12
                                            ]
                                        ]
                                    }
                                ]
                            }
                        });
                    </script>
                </div>
            </div>

            <?php } else{
                
                // Reporte estadistico general de costos por año

                $KsvmDataUno = $KsvmIniComp -> __KsvmCargarReportePedidos("",2018, "", "", 1);
                if ($KsvmDataUno == "") {
                    $KsvmDataUno = 0;
                }
                $KsvmDataDos = $KsvmIniComp -> __KsvmCargarReportePedidos("",2019, "", "", 1);
                if ($KsvmDataDos == "") {
                    $KsvmDataDos = 0;
                }
                $KsvmDataTres = $KsvmIniComp -> __KsvmCargarReportePedidos("",2020, "", "", 1);
                if ($KsvmDataTres == "") {
                    $KsvmDataTres = 0;
                }
                $KsvmDataCuatro = $KsvmIniComp -> __KsvmCargarReportePedidos("",2021, "", "", 1);
                if ($KsvmDataCuatro == "") {
                    $KsvmDataCuatro = 0;
                }
                $KsvmDataCinco = $KsvmIniComp -> __KsvmCargarReportePedidos("",2022, "", "", 1);
                if ($KsvmDataCinco == "") {
                    $KsvmDataCinco = 0;
                }
                $KsvmDataSeis = $KsvmIniComp -> __KsvmCargarReportePedidos("",2023, "", "", 1);
                if ($KsvmDataSeis == "") {
                    $KsvmDataSeis = 0;
                }
                $KsvmDataSiete = $KsvmIniComp -> __KsvmCargarReportePedidos("",2024, "", "", 1);
                if ($KsvmDataSiete == "") {
                    $KsvmDataSiete = 0;
                }
                $KsvmDataOcho = $KsvmIniComp -> __KsvmCargarReportePedidos("",2025, "", "", 1);
                if ($KsvmDataOcho == "") {
                    $KsvmDataOcho = 0;
                }
                $KsvmDataNueve = $KsvmIniComp -> __KsvmCargarReportePedidos("",2026, "", "", 1);
                if ($KsvmDataNueve == "") {
                    $KsvmDataNueve = 0;
                }
                $KsvmDataDiez = $KsvmIniComp -> __KsvmCargarReportePedidos("",2027, "", "", 1);
                if ($KsvmDataDiez == "") {
                    $KsvmDataDiez = 0;
                }
                $KsvmDataOnce = $KsvmIniComp -> __KsvmCargarReportePedidos("",2028, "", "", 1);
                if ($KsvmDataOnce == "") {
                    $KsvmDataOnce = 0;
                }
                $KsvmDataDoce = $KsvmIniComp -> __KsvmCargarReportePedidos("",2029, "", "", 1);
                if ($KsvmDataDoce == "") {
                    $KsvmDataDoce = 0;
                }
                $KsvmDataVal = "{name: 'CANTIDAD', data: [".$KsvmDataUno.", ".$KsvmDataDos.", ".$KsvmDataTres.", ".$KsvmDataCuatro.",
                    ".$KsvmDataCinco.", ".$KsvmDataSeis.", ".$KsvmDataSiete.", ".$KsvmDataOcho.", ".$KsvmDataNueve.", ".$KsvmDataDiez.",
                    ".$KsvmDataOnce.", ".$KsvmDataDoce."]}";

                // Reporte estadistico general de demanda por año

                // $KsvmDataUno = $KsvmIniComp -> __KsvmCargarReportePedidos("",2018, "", "", 2);
                // if ($KsvmDataUno == "") {
                //     $KsvmDataUno = 0;
                // }
                // $KsvmDataDos = $KsvmIniComp -> __KsvmCargarReportePedidos("",2019, "", "", 2);
                // if ($KsvmDataDos == "") {
                //     $KsvmDataDos = 0;
                // }
                // $KsvmDataTres = $KsvmIniComp -> __KsvmCargarReportePedidos("",2020, "", "", 2);
                // if ($KsvmDataTres == "") {
                //     $KsvmDataTres = 0;
                // }
                // $KsvmDataCuatro = $KsvmIniComp -> __KsvmCargarReportePedidos("",2021, "", "", 2);
                // if ($KsvmDataCuatro == "") {
                //     $KsvmDataCuatro = 0;
                // }
                // $KsvmDataCinco = $KsvmIniComp -> __KsvmCargarReportePedidos("",2022, "", "", 2);
                // if ($KsvmDataCinco == "") {
                //     $KsvmDataCinco = 0;
                // }
                // $KsvmDataSeis = $KsvmIniComp -> __KsvmCargarReportePedidos("",2023, "", "", 2);
                // if ($KsvmDataSeis == "") {
                //     $KsvmDataSeis = 0;
                // }
                // $KsvmDataSiete = $KsvmIniComp -> __KsvmCargarReportePedidos("",2024, "", "", 2);
                // if ($KsvmDataSiete == "") {
                //     $KsvmDataSiete = 0;
                // }
                // $KsvmDataOcho = $KsvmIniComp -> __KsvmCargarReportePedidos("",2025, "", "", 2);
                // if ($KsvmDataOcho == "") {
                //     $KsvmDataOcho = 0;
                // }
                // $KsvmDataNueve = $KsvmIniComp -> __KsvmCargarReportePedidos("",2026, "", "", 2);
                // if ($KsvmDataNueve == "") {
                //     $KsvmDataNueve = 0;
                // }
                // $KsvmDataDiez = $KsvmIniComp -> __KsvmCargarReportePedidos("",2027, "", "", 2);
                // if ($KsvmDataDiez == "") {
                //     $KsvmDataDiez = 0;
                // }
                // $KsvmDataOnce = $KsvmIniComp -> __KsvmCargarReportePedidos("",2028, "", "", 2);
                // if ($KsvmDataOnce == "") {
                //     $KsvmDataOnce = 0;
                // }
                // $KsvmDataDoce = $KsvmIniComp -> __KsvmCargarReportePedidos("",2029, "", "", 2);
                // if ($KsvmDataDoce == "") {
                //     $KsvmDataDoce = 0;
                // }
                // $KsvmDataCant = "{name: 'DEMANDA', data: [".$KsvmDataUno.", ".$KsvmDataDos.", ".$KsvmDataTres.", ".$KsvmDataCuatro.",
                //     ".$KsvmDataCinco.", ".$KsvmDataSeis.", ".$KsvmDataSiete.", ".$KsvmDataOcho.", ".$KsvmDataNueve.", ".$KsvmDataDiez.",
                //     ".$KsvmDataOnce.", ".$KsvmDataDoce."]}";
                
                ?>

            <script type="text/javascript">
                Highcharts.chart('container', {
                    chart: {
                        type: 'area'
                    },
                    accessibility: {
                        description: 'La imagen describe los porcentajes de pedidos de cada año'
                    },
                    title: {
                        text: 'Reporte Anual de Pedidos'
                    },
                    // subtitle: {
                    //     text: 'Reporte Anual de Compras'
                    // },
                    xAxis: {
                        allowDecimals: false,
                        labels: {
                            formatter: function () {
                                return this.value; // clean, unformatted number for year
                            }
                        },
                        accessibility: {
                            rangeDescription: 'Rango: 2015 - 2030.'
                        }
                    },
                    yAxis: {
                        title: {
                            text: 'Estado de cantidad de pedidos'
                        },
                        labels: {
                            formatter: function () {
                                return this.value / 1000 + 'k';
                            }
                        }
                    },
                    tooltip: {
                        pointFormat: '{series.name} Total de <b>{point.y:,.0f}</b><br/>medicamentos en pedidos {point.x}'
                    },
                    plotOptions: {
                        area: {
                            pointStart: 2018,
                            marker: {
                                enabled: false,
                                symbol: 'circle',
                                radius: 2,
                                states: {
                                    hover: {
                                        enabled: true
                                    }
                                }
                            }
                        }
                    },
                    series: [
                        
                        <?php echo $KsvmDataVal?>
                        <?php /*echo $KsvmDataCant*/?>
                    ]
                });
            </script>
            <?php }?>
        </div>

    </div>

</section>