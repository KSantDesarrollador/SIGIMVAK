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
                LISTA DE REPORTES ESTADISTICO
            </p>
        </div>
    </section>
    <div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
        <div class="mdl-tabs__panel is-active" id="KsvmReporteGeneral">
            <div class="mdl-grid">
                <div
                    class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--13-col-desktop mdl-cell--0-offset-desktop">
                    <div>
                        <article class="full-width tile-report" style="float:right;">
                            <img height="444px" width="100%"
                                src="<?php echo KsvmServUrl;?>Vistas/assets/img/reporteG2.jpg" alt="repot">
                        </article>
                    </div>
                    <div>
                        <ul class="full-width list-unstyle menu-principal">
                            <article class="full-width tile-list" style="float:left;">
                                <li class="full-width">
                                    <a href="<?php echo KsvmServUrl;?>KsvmReporteComprasEst/1/" class="full-width tile-icon">
                                        <div class="navLateral-body-cl">
                                            <i class="zmdi zmdi-shopping-cart" id="KsvmCompras" style="font-size:45px;"></i>
                                        </div>
                                        <div class="mdl-tooltip" for="KsvmCompras">Reporte de Compras</div>
                                        <div class="navLateral-body-cr hide-on-tablet">
                                            REPORTE DE COMPRAS &nbsp;
                                        </div>
                                    </a>
                                </li>
                            </article>
                            <article class="full-width tile-list" style="float:left;">
                                <li class="full-width">
                                    <a href="<?php echo KsvmServUrl;?>KsvmReporteInventariosEst/1/" class="full-width tile-icon">
                                        <div class="navLateral-body-cl">
                                            <i class="zmdi zmdi-check-circle" id="KsvmInventarios" style="font-size:45px;"></i>
                                        </div>
                                        <div class="mdl-tooltip" for="KsvmInventarios">Reporte de Inventarios</div>
                                        <div class="navLateral-body-cr hide-on-tablet">
                                            REPORTE DE INVENTARIOS
                                        </div>
                                    </a>
                                </li>
                            </article>
                            <article class="full-width tile-list" style="float:left;">
                                <li class="full-width">
                                    <a href="<?php echo KsvmServUrl;?>KsvmReportePedidosEst/1/" class="full-width tile-icon">
                                        <div class="navLateral-body-cl">
                                            <i class="zmdi zmdi-upload" id="KsvmPedidos" style="font-size:45px;"></i>
                                        </div>
                                        <div class="mdl-tooltip" for="KsvmPedidos">Reportes de Pedidos</div>
                                        <div class="navLateral-body-cr hide-on-tablet">
                                            REPORTE DE PEDIDOS
                                        </div>
                                    </a>
                                </li>
                            </article>
                            <article class="full-width tile-list tittles" style="float:left;">
                                <li class="full-width">
                                    <a href="<?php echo KsvmServUrl;?>KsvmReporteTransaccionesEst/1/" class="full-width tile-icon">
                                        <div class="navLateral-body-cl">
                                            <i class="zmdi zmdi-transform" id="KsvmTransacciones" style="font-size:45px;"></i>
                                        </div>
                                        <div class="mdl-tooltip" for="KsvmTransacciones">Reporte de Transacciones</div>
                                        <div class="navLateral-body-cr hide-on-tablet">
                                            REPORTE DE TRANSACCIONES
                                        </div>
                                    </a>
                                </li>
                            </article>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>