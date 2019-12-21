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
            EDITAR-BODEGAS
            </p>
        </div>
    </section>
    <div class="full-width divider-menu-h"></div>
 <!-- Método para cargar datos en el formulario -->
 <?php 

    require_once "./Controladores/KsvmBodegaControlador.php";
    $KsvmIniBod = new KsvmBodegaControlador();
			  
    $KsvmPagina = explode("/", $_GET['Vistas']);
    if ($KsvmPagina[1] != "") {
    $KsvmDataEdit = $KsvmIniBod->__KsvmEditarBodegaControlador($KsvmPagina[1]);

    if ($KsvmDataEdit->rowCount() == 1) {
        $KsvmLlenarForm = $KsvmDataEdit->fetch();
    
        $KsvmEstado = "";
        if ($KsvmLlenarForm['BdgEstBod'] == 'A') {
        $KsvmEstado = "Activo";
        }else {
        $KsvmEstado = "Inactivo";
        }
            
?>

 <!-- Formulario para editar un Bodega -->
 <div class="mdl-tabs" id="KsvmActualizarBodega">
     <div class="mdl-grid">
         <div
             class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--13-col-desktop mdl-cell--0-offset-desktop">
             <div class="navBar-options-button">
             <?php 
               if ($KsvmPagina[2] == 0) {
                echo '<a href="'.KsvmServUrl.'KsvmBodegasCrud/1/" id="btn-input"
                class="btn btn-sm btn-dark mdl-shadow--8dp btn-salir">VOLVER &nbsp;<i
                class="zmdi zmdi-arrow-left"></i>
                </a>';
               } else {
                echo '<a href="'.KsvmServUrl.'KsvmBodegas/1/" id="btn-input"
                class="btn btn-sm btn-dark mdl-shadow--8dp btn-salir">VOLVER &nbsp;<i
                class="zmdi zmdi-arrow-left"></i>
                </a>';
               }
               
             ?>
            </div>
            <br>
             <div class="full-width panel mdl-shadow--8dp">
                 <div class="full-width  modal-header-edit text-center ">
                     Editar Bodega
                 </div>
                 <div class="full-width panel-content">
                     <form data-form="guardar" action="<?php echo KsvmServUrl; ?>Ajax/KsvmBodegaAjax.php" method="POST"
                         class="FormularioAjax" autocomplete="off" enctype="multipart/form-data" id="KsvmFormBodega">
                         <input type="hidden" name="KsvmCodEdit" value="<?php echo $KsvmPagina[1]; ?>">
                         <div class="mdl-grid">
                             <div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
                                 <div class="mdl-textfield mdl-js-textfield">
                                     <select class="mdl-textfield__input" name="KsvmUmdId" id="KsvmDato1">
                                         <option value="<?php echo $KsvmLlenarForm['UmdId'];?>" selected="">
                                             <?php echo $KsvmLlenarForm['UmdNomUdm'];?></option>
                                             <?php require_once "./Controladores/KsvmUnidadMedicaControlador.php";
											   $KsvmSelUndMed = new KsvmUnidadMedicaControlador();
											   echo $KsvmSelUndMed->__KsvmSeleccionarUndMedica();
										     ?>
                                     </select>
                                     <span id="KsvmError1" class="ValForm"><i class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este campo</i></span>
                                 </div>
                                 <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                     <input class="mdl-textfield__input" type="text" name="KsvmDescBod"
                                         value="<?php echo $KsvmLlenarForm['BdgDescBod'];?>"
                                         pattern="-?[A-Za-z0-9áéíóúÁÉÍÓÚ ]*(\.[0-9]+)?" id="KsvmDato2">
                                     <label class="mdl-textfield__label" for="KsvmDato2">Descripción</label>
                                     <span class="mdl-textfield__error">Descripción Inválido</span>
                                     <span id="KsvmError2" class="ValForm"><i class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este campo</i></span>
                                 </div>
                                 <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                     <input class="mdl-textfield__input" type="tel" name="KsvmTelfBod"
                                         value="<?php echo $KsvmLlenarForm['BdgTelfBod'];?>" 
                                         pattern="-?[0-9+()-]*(\.[0-9]+)?" id="KsvmDato3">
                                     <label class="mdl-textfield__label" for="KsvmDato3">Teléfono</label>
                                     <span class="mdl-textfield__error">Teléfono Inválido</span>
                                     <span id="KsvmError3" class="ValForm"><i class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este campo</i></span>
                                 </div>
                                 <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                     <input class="mdl-textfield__input" type="text" name="KsvmDirBod"
                                         value="<?php echo $KsvmLlenarForm['BdgDirBod'];?>"
                                          id="KsvmDato4">
                                     <label class="mdl-textfield__label" for="KsvmDato4">Dirección</label>
                                     <span class="mdl-textfield__error">Dirección Inválido</span>
                                     <span id="KsvmError4" class="ValForm"><i class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este campo</i></span>
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
                         <div class="mdl-tooltip" for="btnSave">Actualizar Bodega</div>
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