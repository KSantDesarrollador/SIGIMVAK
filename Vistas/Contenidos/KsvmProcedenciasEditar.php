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
                 EDITAR-PROCEDENCIAS
             </p>
         </div>
     </section>
     <div class="full-width divider-Procedencia-h"></div>
     <!-- Método para cargar datos en el formulario -->
     <?php 

    require_once "./Controladores/KsvmProcedenciaControlador.php";
    $KsvmIniProcedencia = new KsvmProcedenciaControlador();
			  
    $KsvmPagina = explode("/", $_GET['Vistas']);
    if ($KsvmPagina[1] != "") {
    $KsvmDataEdit = $KsvmIniProcedencia->__KsvmEditarProcedenciaControlador($KsvmPagina[1]);

    if ($KsvmDataEdit->rowCount() == 1) {
        $KsvmLlenarForm = $KsvmDataEdit->fetch();
    
        $KsvmEstado = "";
			  if ($KsvmLlenarForm['PrcEstProc'] == 'A') {
				$KsvmEstado = "Activo";
			  }else {
				$KsvmEstado = "Inactivo";
              }
              
              if ($KsvmLlenarForm['PrcNivProc'] == 0) {
                $KsvmNivel = "Nivel 0";
            } elseif ($KsvmLlenarForm['PrcNivProc'] == 1) {
                $KsvmNivel = "Nivel 1";
            } elseif ($KsvmLlenarForm['PrcNivProc'] == 2) {
                $KsvmNivel = "Nivel 2";
            } else {
                $KsvmNivel = "Nivel 3";
            }
			  
			$KsvmJerq = $KsvmLlenarForm['PrcJerqProc'];
			
			$KsvmProcedencia = $KsvmIniProcedencia->__KsvmMostrarJerarquia($KsvmJerq);

			if ($KsvmProcedencia->rowCount() == 1) {
				$KsvmJerarquia = $KsvmProcedencia->fetch();
				$KsvmNomJerq = $KsvmJerarquia['PrcNomProc'];
			}else {
				$KsvmNomJerq = "Es Menú padre";
			}
            
?>

     <!-- Formulario para editar un Procedencia -->
     <div class="mdl-tabs" id="KsvmActualizarProcedencia">
         <div class="mdl-grid">
             <div
                 class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--13-col-desktop mdl-cell--0-offset-desktop">
                 <div class="navBar-options-button">
                     <?php 
               if ($KsvmPagina[2] == 0) {
                echo '<a href="'.KsvmServUrl.'KsvmProcedenciaCrud/1/" id="btn-input"
                class="btn btn-sm btn-dark mdl-shadow--8dp btn-salir">VOLVER &nbsp;<i
                class="zmdi zmdi-arrow-left"></i>
                </a>';
               } else {
                echo '<a href="'.KsvmServUrl.'KsvmProcedencia/1/" id="btn-input"
                class="btn btn-sm btn-dark mdl-shadow--8dp btn-salir">VOLVER &nbsp;<i
                class="zmdi zmdi-arrow-left"></i>
                </a>';
               }
               
             ?>
                 </div>
                 <br>
                 <div class="full-width panel mdl-shadow--8dp">
                     <div class="full-width  modal-header-edit text-center ">
                         Editar Procedencia
                     </div>
                     <div class="full-width panel-content">
                         <form data-form="guardar" action="<?php echo KsvmServUrl; ?>Ajax/KsvmProcedenciaAjax.php"
                             method="POST" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data"
                             id="KsvmFormProcedencia">
                             <input type="hidden" name="KsvmCodEdit" value="<?php echo $KsvmPagina[1]; ?>">
                             <div class="mdl-grid">
                                 <div
                                     class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
                                     <div class="mdl-textfield mdl-js-textfield">
                                         <select class="ksvmSelectDin" name="KsvmNivProc" style="width:98%;"
                                             id="KsvmDato1">
                                             <option value="<?php echo $KsvmLlenarForm['PrcNivProc'];?>">
                                                 <?php echo $KsvmNivel;?></option>
                                             <option value="0">Nivel 0</option>
                                             <option value="1">Nivel 1</option>
                                             <option value="1">Nivel 2</option>
                                             <option value="1">Nivel 3</option>
                                         </select>
                                         <span id="KsvmError1" class="ValForm"><i
                                                 class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
                                                 campo</i></span>
                                     </div>
                                     <div class="mdl-textfield mdl-js-textfield">
                                         <select class="ksvmSelectDin" name="KsvmJerqMen" style="width:98%;">
                                             <option value="<?php echo $KsvmLlenarForm['PrcJerqProc'];?>" selected="">
                                                 <?php echo $KsvmNomJerq;?></option>
                                             <?php require_once "./Controladores/KsvmProcedenciaControlador.php";
													$KsvmSelProc = new KsvmProcedenciaControlador();
													echo $KsvmSelProc->__KsvmSeleccionarJerarquia();
													?>
                                         </select>
                                     </div>
                                     <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                         <input class="mdl-textfield__input" type="text" name="KsvmCodProc"
                                            pattern="-?[0-9]*(\.[0-9]+)?" min="0" max="1000"
                                             value="<?php echo $KsvmLlenarForm['PrcCodProc']?>" id="KsvmDato2">
                                         <label class="mdl-textfield__label" for="KsvmDato2">Código</label>
                                         <span class="mdl-textfield__error">Ícono Inválido</span>
                                         <span id="KsvmError2" class="ValForm"><i
                                                 class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
                                                 campo</i></span>
                                     </div>
                                     <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                         <input class="mdl-textfield__input" type="text" name="KsvmNomProc"
                                             value="<?php echo $KsvmLlenarForm['PrcNomProc']?>"
                                             pattern="-?[A-Za-záéíóúÁÉÍÓÚ ]*(\.[0-9]+)?" id="KsvmDato3">
                                         <label class="mdl-textfield__label" for="KsvmDato3">Nombre</label>
                                         <span class="mdl-textfield__error">Nombre Inválido</span>
                                         <span id="KsvmError3" class="ValForm"><i
                                                 class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
                                                 campo</i></span>
                                     </div>
                                     <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                         <input class="mdl-textfield__input" type="text" name="KsvmDescProc"
                                             value="<?php echo $KsvmLlenarForm['PrcDescProc']?>" id="KsvmDato4">
                                         <label class="mdl-textfield__label" for="KsvmDato4">Descripción</label>
                                         <span class="mdl-textfield__error">Descripción Inválida</span>
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
                             <div class="mdl-tooltip" for="btnSave">Actualizar Procedencia</div>
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