 <!--
* Copyright 2019 Klever Santiago Vaca Muela
-->

<!-- pageContent -->
<section class="full-width pageContent">
    <section class="full-width header-well">
        <div class="full-width header-well-icon">
            <i class="zmdi zmdi-folder-star"></i>
        </div>
        <div class="full-width header-well-text">
            <p class="text-condensedLight">
            EDITAR-ALERTAS
            </p>
        </div>
    </section>
    <div class="full-width divider-menu-h"></div>
 <!-- Método para cargar datos en el formulario -->
 <?php 

    require_once "./Controladores/KsvmAlertaControlador.php";
    $KsvmIniAle = new KsvmAlertaControlador();
			  
    $KsvmPagina = explode("/", $_GET['Vistas']);
    if ($KsvmPagina[1] != "") {
    $KsvmDataEdit = $KsvmIniAle->__KsvmEditarAlertaControlador($KsvmPagina[1]);

    if ($KsvmDataEdit->rowCount() == 1) {
        $KsvmLlenarForm = $KsvmDataEdit->fetch();
            
?>

 <!-- Formulario para editar un Alerta -->
 <div class="mdl-tabs" id="KsvmActualizarAlerta">
     <div class="mdl-grid">
         <div
             class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--13-col-desktop mdl-cell--0-offset-desktop">
             <div class="navBar-options-button">
             <?php 
               if ($KsvmPagina[2] == 0) {
                echo '<a href="'.KsvmServUrl.'KsvmAlertasCrud/1/" id="btn-input"
                class="btn btn-sm btn-dark mdl-shadow--8dp btn-salir">VOLVER &nbsp;<i
                class="zmdi zmdi-arrow-left"></i>
                </a>';
               } else {
                echo '<a href="'.KsvmServUrl.'KsvmAlertas/1/" id="btn-input"
                class="btn btn-sm btn-dark mdl-shadow--8dp btn-salir">VOLVER &nbsp;<i
                class="zmdi zmdi-arrow-left"></i>
                </a>';
               }
               
             ?>
            </div>
            <br>
             <div class="full-width panel mdl-shadow--8dp">
                 <div class="full-width  modal-header-edit text-center ">
                     Editar Alerta
                 </div>
                 <div class="full-width panel-content">
                     <form data-form="guardar" action="<?php echo KsvmServUrl; ?>Ajax/KsvmAlertaAjax.php" method="POST"
                         class="FormularioAjax" autocomplete="off" enctype="multipart/form-data" id="KsvmFormAlerta">
                         <input type="hidden" name="KsvmCodEdit" value="<?php echo $KsvmPagina[1]; ?>">
                         <div class="mdl-grid">
                             <div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
                                 <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                     <input class="mdl-textfield__input" type="text" name="KsvmNomAle"
                                         value="<?php echo $KsvmLlenarForm['AltNomAle'];?>"
                                         pattern="-?[A-Za-záéíóúÁÉÍÓÚñ ]*(\.[0-9]+)?" id="KsvmDato1">
                                     <label class="mdl-textfield__label" for="KsvmDato1">Nombre</label>
                                     <span class="mdl-textfield__error">Nombre Inválido</span>
                                     <span id="KsvmError1" class="ValForm"><i class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este campo</i></span>
                                 </div>
                                 <br>
                                 <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                     <input class="mdl-textfield__input" type="color" name="KsvmColorAle"
                                         value="<?php echo $KsvmLlenarForm['AltColorAle'];?>"
                                          id="KsvmDato2">
                                     <label class="mdl-textfield__label" for="KsvmDato2">Color</label>
                                     <span class="mdl-textfield__error">Color Inválido</span>
                                     <span id="KsvmError2" class="ValForm"><i class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este campo</i></span>
                                 </div>
                                 <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                     <input class="mdl-textfield__input" type="text" name="KsvmDescAle"
                                         value="<?php echo  $KsvmLlenarForm['AltDescAle'];?>" 
                                         pattern="-?[A-Za-záéíóúÁÉÍÓÚñ ]*(\.[0-9]+)?" id="KsvmDato3">
                                     <label class="mdl-textfield__label" for="KsvmDato3">Descripción</label>
                                     <span class="mdl-textfield__error">Descripción Inválida</span>
                                     <span id="KsvmError3" class="ValForm"><i class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este campo</i></span>
                                 </div>
                             </div>
                         </div>
                         <br>
                         <p class="text-center">
                             <button type="submit"
                                 class="mdl-button mdl-js-button mdl-js-ripple-effect btn-primary mdl-shadow--4dp"
                                 id="btnSave">
                                 <i class="zmdi zmdi-save">&nbsp;Guardar</i>
                             </button>
                         </p>
                         <div class="mdl-tooltip" for="btnSave">Actualizar Alerta</div>
                         <div class="RespuestaAjax"></div>
                     </form>
                 </div>
             </div>
         </div>
     </div>
 </div>
 <?php 
    } }
 ?>

 </section>