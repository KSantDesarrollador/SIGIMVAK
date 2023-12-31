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
                 EDITAR-PARÁMETROS
             </p>
         </div>
     </section>
     <div class="full-width divider-menu-h"></div>
     <!-- Método para cargar datos en el formulario -->
     <?php 

    require_once "./Controladores/KsvmParametrosControlador.php";
    $KsvmIniAle = new KsvmParametrosControlador();
			  
    $KsvmPagina = explode("/", $_GET['Vistas']);
    if ($KsvmPagina[1] != "") {
    $KsvmDataEdit = $KsvmIniAle->__KsvmEditarParametrosControlador($KsvmPagina[1]);

    if ($KsvmDataEdit->rowCount() == 1) {
        $KsvmLlenarForm = $KsvmDataEdit->fetch();
            
?>

     <!-- Formulario para editar un Parametros -->
     <div class="mdl-tabs" id="KsvmActualizarParametros">
         <div class="mdl-grid">
             <div
                 class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--13-col-desktop mdl-cell--0-offset-desktop">
                 <div class="navBar-options-button">
                     <?php 
               if ($KsvmPagina[2] == 0) {
                echo '<a href="'.KsvmServUrl.'KsvmParametrosCrud/1/" id="btn-input"
                class="btn btn-sm btn-dark mdl-shadow--8dp btn-salir">VOLVER &nbsp;<i
                class="zmdi zmdi-arrow-left"></i>
                </a>';
               } else {
                echo '<a href="'.KsvmServUrl.'KsvmParametros/1/" id="btn-input"
                class="btn btn-sm btn-dark mdl-shadow--8dp btn-salir">VOLVER &nbsp;<i
                class="zmdi zmdi-arrow-left"></i>
                </a>';
               }
               
             ?>
                 </div>
                 <br>
                 <div class="full-width panel mdl-shadow--8dp">
                     <div class="full-width  modal-header-edit text-center ">
                         Editar Parámetros
                     </div>
                     <div class="full-width panel-content">
                         <form data-form="guardar" action="<?php echo KsvmServUrl; ?>Ajax/KsvmParametrosAjax.php"
                             method="POST" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data"
                             id="KsvmFormParametros">
                             <input type="hidden" name="KsvmCodEdit" value="<?php echo $KsvmPagina[1]; ?>">
                             <div class="mdl-grid">
                                 <div
                                     class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
                                     <div class="mdl-textfield mdl-js-textfield">
                                         <select class="ksvmSelectDin" name="KsvmMdcId" id="KsvmDato1"
                                             style="width:98%;">
                                             <option value="<?php echo $KsvmLlenarForm['MdcId']; ?>" selected="">
                                                 <?php echo $KsvmLlenarForm['MdcDescMed'].' '.$KsvmLlenarForm['MdcConcenMed']; ?>
                                             </option>
                                             <?php require_once "./Controladores/KsvmMedicamentoControlador.php";
													$KsvmSelExt = new KsvmMedicamentoControlador();
													echo $KsvmSelExt->__KsvmSeleccionarMedicamento();
													?>
                                         </select>
                                         <span id="KsvmError1" class="ValForm"><i
                                                 class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
                                                 campo</i></span>
                                     </div>
                                     <div class="mdl-textfield mdl-js-textfield">
                                         <select class="ksvmSelectDin" name="KsvmAltId" id="KsvmDato2"
                                             style="width:98%;">
                                             <option value="<?php echo $KsvmLlenarForm['AltId']; ?>" selected="">
                                                 <?php echo $KsvmLlenarForm['AltNomAle']?></option>
                                             <?php require_once "./Controladores/KsvmAlertaControlador.php";
													$KsvmSelAle = new KsvmAlertaControlador();
													echo $KsvmSelAle->__KsvmSeleccionarAlerta();
													?>
                                         </select>
                                         <span id="KsvmError2" class="ValForm"><i
                                                 class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
                                                 campo</i></span>
                                     </div>
                                     <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                         <input class="mdl-textfield__input" type="number" name="KsvmMinPar"
                                            pattern="-?[0-9]*(\.[0-9]+)?" min="1" max="10000"
                                             value="<?php echo $KsvmLlenarForm['PmtMinPar']; ?>" id="KsvmDato3">
                                         <label class="mdl-textfield__label" for="KsvmDato3">Valor Mínimo</label>
                                         <span class="mdl-textfield__error">Valor Inválido</span>
                                         <span id="KsvmError3" class="ValForm"><i
                                                 class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
                                                 campo</i></span>
                                     </div>
                                     <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                         <input class="mdl-textfield__input" type="number" name="KsvmMaxPar"
                                            pattern="-?[0-9]*(\.[0-9]+)?" min="1" max="10000"
                                             value="<?php echo $KsvmLlenarForm['PmtMaxPar']; ?>" id="KsvmDato4">
                                         <label class="mdl-textfield__label" for="KsvmDato4">Valor Máximo</label>
                                         <span class="mdl-textfield__error">Valor Inválida</span>
                                         <span id="KsvmError4" class="ValForm"><i
                                                 class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
                                                 campo</i></span>
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
                             <div class="mdl-tooltip" for="btnSave">Actualizar Parametro</div>
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