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
                REPORTE DE TRANSACCIONES
            </p>
        </div>
    </section>
    <div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
        <div class="mdl-tabs__panel is-active" id="KsvmReporteTransacciones">
            <div class="mdl-grid">
                <div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
                    <div class="">
                        <!-- Formulario de busqueda -->
                        <form data-form="" action="" method="POST" autocomplete="off" enctype="multipart/form-data">
                            <div class="mdl-textfield mdl-js-textfield">
                                <article class="full-width tile-buscar">
                                    <div class="mdl-textfield--expandable" style="display:inline-flex;">
                                        <select class="mdl-textfield__input" name="KsvmFiltro" id="KsvmFiltro">
                                        <option value="" selected="" disabled>Filtro</option>
                                        <option value="Ingreso">Ingresos</option>
                                        <option value="Egreso">Egresos</option>
                                        </select>&nbsp;
                                        <label class="hide-on-tablet" for="KsvmFchInicio">Desde</label>
                                        <input class="mdl-textfield__input tcal" type="text" id="KsvmFchInicio"
                                            name="KsvmFchInicio" placeholder="Fecha Inicio" >
                                        <label class="hide-on-tablet" for="KsvmFchFin">Hasta</label>
                                        <input class="mdl-textfield__input tcal" type="text" id="KsvmFchFin"
                                            name="KsvmFchFin" placeholder="Fecha Fin" >&nbsp;
                                    </div>
                                    <button type="submit" style="float:right;" class="btn btn-info"
                                        for="KsvmBuscarTransacciones">
                                        <i class="zmdi zmdi-search">&nbsp;<strong class="hide-on-tablet">BUSCAR</strong></i>
                                    </button>
                                </article>
                                <div class="mdl-textfield--expandable navBar-options-list">
                                    <a class="btn btn-sm btn-success mdl-shadow--8dp hide-on-tablet"
                                        href="<?php echo KsvmServUrl;?>Reportes/KsvmTransaccionesPdf.php" target="_blank"><i
                                            class="zmdi zmdi-file">&nbsp;PDF</i></a>
                                    <a href="<?php echo KsvmServUrl;?>KsvmReporteGeneral/1/" id="btn-input"
                                        class="btn btn-sm btn-dark mdl-shadow--8dp hide-on-tablet">MENU&nbsp;<i
                                            class="zmdi zmdi-arrow-left"></i></a>
                                </div>
                            </div>
                            <div class="RespuestaAjax"></div>
                        </form>
                    </div>

                    <!-- Método para mostrar la lista de Transacciones -->
                    <?php
                    require_once "./Controladores/KsvmTransaccionControlador.php";
                    $KsvmIniTran = new KsvmTransaccionControlador();
                    
                    if (isset($_POST['KsvmFchInicio']) && isset($_POST['KsvmFchFin']) && isset($_POST['KsvmFiltro'])) {

                        $_SESSION['KsvmFchInicio'] = $_POST['KsvmFchInicio'];
                        $_SESSION['KsvmFchFin'] = $_POST['KsvmFchFin'];
                        $_SESSION['KsvmFiltro'] = $_POST['KsvmFiltro'];
                        $KsvmPagina = explode("/", $_GET['Vistas']);
						echo $KsvmIniTran -> __KsvmPaginador($KsvmPagina[1], KsvmNumPag, $_SESSION['KsvmRolId-SIGIM'], 
						3, $_SESSION['KsvmFchInicio'], $_SESSION['KsvmFchFin'], $_SESSION['KsvmFiltro']);
                    } elseif (isset($_POST['KsvmFchInicio']) && isset($_POST['KsvmFchFin']) && !isset($_POST['KsvmFiltro'])) {

                        $_SESSION['KsvmFchInicio'] = $_POST['KsvmFchInicio'];
                        $_SESSION['KsvmFchFin'] = $_POST['KsvmFchFin'];
                        $KsvmPagina = explode("/", $_GET['Vistas']);
						echo $KsvmIniTran -> __KsvmPaginador($KsvmPagina[1], KsvmNumPag, $_SESSION['KsvmRolId-SIGIM'], 
						3, $_SESSION['KsvmFchInicio'], $_SESSION['KsvmFchFin'], "");
                    } else{

						$KsvmPagina = explode("/", $_GET['Vistas']);
						echo $KsvmIniTran -> __KsvmPaginador($KsvmPagina[1], KsvmNumPag, $_SESSION['KsvmRolId-SIGIM'], 
						3, "", "", "");
				       }
				    ?>

                </div>
            </div>
        </div>

        		<!-- Método para cargar datos en el formulario -->
		<?php 
			  
              $KsvmPagina = explode("/", $_GET['Vistas']);
              if ($KsvmPagina[2] != "") {
              $KsvmDataEdit = $KsvmIniTran->__KsvmEditarDetalleTransaccionControlador($KsvmPagina[2]);
    
                  $KsvmQuery = $KsvmDataEdit->fetchAll();
                  
            ?>
            <script>
                window.onload = function () {
    
                    $("#KsvmFormOcp").trigger("reset");
                    $(".modal-title").text("Detalles Transacción");
                    $("#KsvmDetallesTransaccion").modal({
                        show: true
                    });
                }
            </script>
    
            <!-- Formulario de Detalles del Transaccion -->
    
            <div class="modal fade" id="KsvmDetallesTransaccion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content ">
                        <div class="modal-header">
                            <button class="close close-edit" type="button" id="btnExitTranRep" data-dismiss="modal"
                                aria-hidden="true">&times;</button>
                            <h5 class="modal-title text-center"></h5>
                        </div>
                        <div class="modal-body">
                            <form action="" method="POST" id="KsvmFormOcp">
                                <input type="hidden" name="KsvmCodEdit" value="<?php echo $KsvmPagina[2]; ?>">
                                <div class="mdl-grid">
                                    <div
                                        class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--2-col-desktop">
                                        <div class="mdl-textfield"><strong>Num.Egreso :</strong></div>
                                    </div>
                                    <div
                                        class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--4-col-desktop">
                                        <div class="mdl-textfield"><strong>Medicamento:</strong></div>
                                    </div>
                                    <div
                                        class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--2-col-desktop">
                                        <div class="mdl-textfield"><strong>Cantidad :</strong></div>
                                    </div>
                                    <div
                                        class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--4-col-desktop">
                                        <div class="mdl-textfield"><strong>Observación :</strong></div>
                                    </div>
                                    <?php foreach ($KsvmQuery as $KsvmLlenarForm) {?>
                                    <div
                                        class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--2-col-desktop">
                                        <div class="mdl-data-table__cell--non-numeric">
                                            <div class="mdl-textfield__input">
                                                <?php echo $KsvmLlenarForm['TsnNumTran'];?></div>
                                        </div>
                                    </div>
                                    <div
                                        class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--4-col-desktop">
                                        <div class="mdl-data-table__cell--non-numeric">
                                            <div class="mdl-textfield__input">
                                                <?php echo $KsvmLlenarForm['MdcDescMed'].' '.$KsvmLlenarForm['MdcConcenMed'];?>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--2-col-desktop">
                                        <div class="mdl-data-table__cell--non-numeric mdl-textfield--floating-label">
                                            <div class="mdl-textfield__input">
                                                <?php echo $KsvmLlenarForm['DtsCantTran'];?></div>
                                        </div>
                                    </div>
                                    <div
                                        class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--4-col-desktop">
                                        <div class="mdl-data-table__cell--non-numeric mdl-textfield--floating-label">
                                            <div class="mdl-textfield__input">
                                                <?php echo $KsvmLlenarForm['DtsObservTran'];?></div>
                                        </div>
                                    </div>
                                    <?php }?>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    
            <?php }?>
    </div>
</section>