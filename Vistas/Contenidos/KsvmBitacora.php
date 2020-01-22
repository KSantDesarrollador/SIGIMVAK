<!--
* Copyright 2019 Klever Santiago Vaca Muela
-->
<?php
   if ($_SESSION['KsvmRolNom-SIGIM'] != "Administrador") {
      echo $CerrarSesion->__KsvmMatarSesion();
   }
 ?>

<!-- pageContent -->
<section class="full-width pageContent">
    <section class="full-width header-well">
        <div class="full-width header-well-icon">
            <i class="zmdi zmdi-chart"></i>
        </div>
        <div class="full-width header-well-text">
            <p class="text-condensedLight">
                REPORTE DE SESIONES
            </p>
        </div>
    </section>
    <div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
        <div class="mdl-tabs__panel is-active" id="KsvmReporteBitacoraes">
            <div class="mdl-grid">
                <div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
                    <div class="">
                        <!-- Formulario de busqueda -->
                        <form data-form="" action="" method="POST" autocomplete="off" enctype="multipart/form-data">
                            <div class="mdl-textfield mdl-js-textfield">
                                <article class="full-width tile-buscar">
                                    <div class="mdl-textfield--floating-label" style="display:inline-flex;">
                                        <select class="ksvmSelectDin" name="KsvmFiltro" id="KsvmFiltro"
                                            style="width:100%;">
                                            <option value="" selected="" disabled>Filtro</option>
                                            <option value="R">Rol</option>
                                            <option value="U">Usuario</option>
                                        </select>&nbsp;
                                        <input class="mdl-textfield__input" type="text" id="KsvmCriterioBq"
                                            name="KsvmCriterioBq" placeholder="Criterio">&nbsp;
                                        <label class="hide-on-tablet" for="KsvmFchInicio">Desde</label>
                                        <input class="mdl-textfield__input tcal" type="text" id="KsvmFchInicio"
                                            name="KsvmFchInicio" placeholder="Fecha Inicio" pattern="[0-9-]{10,10}">
                                            <span class="mdl-textfield__error">Fecha Inválida</span>
                                        <label class="hide-on-tablet" for="KsvmFchFin">Hasta</label>
                                        <input class="mdl-textfield__input tcal" type="text" id="KsvmFchFin"
                                            name="KsvmFchFin" placeholder="Fecha Fin" pattern="[0-9-]{10,10}">
                                            <span class="mdl-textfield__error">Fecha Inválida</span>&nbsp;
                                    </div>
                                    <button type="submit" style="float:right;" class="btn btn-info"
                                        for="KsvmBuscarBitacora">
                                        <i class="zmdi zmdi-search">&nbsp;<strong
                                                class="hide-on-tablet">BUSCAR</strong></i>
                                    </button>
                                </article>
                                <div class="mdl-textfield--expandable navBar-options-list">
                                    <a class="btn btn-sm btn-success mdl-shadow--8dp hide-on-tablet"
                                        href="<?php echo KsvmServUrl;?>Reportes/KsvmBitacoraPdf.php" target="_blank"><i
                                            class="zmdi zmdi-file">&nbsp;PDF</i></a>
                                </div>
                            </div>
                            <div class="RespuestaAjax"></div>
                        </form>
                    </div>

                    <!-- Método para mostrar la lista de Bitacora -->
                    <?php
                    require_once "./Controladores/KsvmBitacoraControlador.php";
                    $KsvmIniBit = new KsvmBitacoraControlador();
                    
                    if (isset($_POST['KsvmFchInicio']) && isset($_POST['KsvmFchFin']) && isset($_POST['KsvmFiltro'])) {

                        $_SESSION['KsvmFchInicio'] = $_POST['KsvmFchInicio'];
                        $_SESSION['KsvmFchFin'] = $_POST['KsvmFchFin'];
                        $_SESSION['KsvmFiltro'] = $_POST['KsvmFiltro'];
                        $_SESSION['KsvmCriterioBq'] = $_POST['KsvmCriterioBq'];
                        $KsvmPagina = explode("/", $_GET['Vistas']);
                        echo $KsvmIniBit -> __KsvmPaginador($KsvmPagina[1], KsvmNumPag, $_SESSION['KsvmFchInicio'], 
                        $_SESSION['KsvmFchFin'], $_SESSION['KsvmFiltro'], $_SESSION['KsvmCriterioBq']);
                    } else{

						$KsvmPagina = explode("/", $_GET['Vistas']);
						echo $KsvmIniBit -> __KsvmPaginador($KsvmPagina[1], KsvmNumPag, "", "", "", "");
				       }
				    ?>

                </div>
            </div>
        </div>
    </div>
</section>