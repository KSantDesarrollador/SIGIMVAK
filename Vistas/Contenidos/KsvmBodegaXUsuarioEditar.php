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
            EDITAR-ASIGNA-BODEGA
            </p>
        </div>
    </section>
    <div class="full-width divider-menu-h"></div>
 <!-- Método para cargar datos en el formulario -->
 <?php 

    require_once "./Controladores/KsvmBodxUsuControlador.php";
    $KsvmIniBodUsu = new KsvmBodxUsuControlador();
			  
    $KsvmPagina = explode("/", $_GET['Vistas']);
    if ($KsvmPagina[1] != "") {
    $KsvmDataEdit = $KsvmIniBodUsu->__KsvmEditarBodxUsuControlador($KsvmPagina[1]);

    if ($KsvmDataEdit->rowCount() == 1) {
        $KsvmLlenarForm = $KsvmDataEdit->fetch();
            
?>

 <!-- Formulario para editar un BodegaXUsuario -->
 <div class="mdl-tabs" id="KsvmActualizarBodegaXUsuario">
     <div class="mdl-grid">
         <div
             class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--13-col-desktop mdl-cell--0-offset-desktop">
             <div class="navBar-options-button">
             <?php 
               if ($KsvmPagina[2] == 0) {
                echo '<a href="'.KsvmServUrl.'KsvmBodegaXUsuarioCrud/1/" id="btn-input"
                class="btn btn-sm btn-dark mdl-shadow--8dp btn-salir">VOLVER &nbsp;<i
                class="zmdi zmdi-arrow-left"></i>
                </a>';
               } else {
                echo '<a href="'.KsvmServUrl.'KsvmBodegaXUsuario/1/" id="btn-input"
                class="btn btn-sm btn-dark mdl-shadow--8dp btn-salir">VOLVER &nbsp;<i
                class="zmdi zmdi-arrow-left"></i>
                </a>';
               }
               
             ?>
            </div>
            <br>
             <div class="full-width panel mdl-shadow--8dp">
                 <div class="full-width  modal-header-edit text-center ">
                     Editar Asignación Bodega
                 </div>
                 <div class="full-width panel-content">
                     <form data-form="guardar" action="<?php echo KsvmServUrl; ?>Ajax/KsvmBodegaXUsuarioAjax.php" method="POST"
                         class="FormularioAjax" autocomplete="off" enctype="multipart/form-data" id="KsvmFormBodegaXUsuario">
                         <input type="hidden" name="KsvmCodEdit" value="<?php echo $KsvmPagina[1]; ?>">
                         <div class="mdl-grid">
                             <div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
                                 <div class="mdl-textfield mdl-js-textfield">
                                     <select class="mdl-textfield__input" name="KsvmUsrId">
                                         <option value="<?php echo $KsvmLlenarForm['UsrId'];?>" selected="">
                                             <?php echo $KsvmLlenarForm['UsrNomUsu'];?></option>
                                             <?php require_once "./Controladores/KsvmUsuarioControlador.php";
											   $KsvmSelUsu = new KsvmUsuarioControlador();
											   echo $KsvmSelUsu->__KsvmSeleccionarUsuario();
										     ?>
                                     </select>
                                 </div>
                                 <div class="mdl-textfield mdl-js-textfield">
                                     <select class="mdl-textfield__input" name="KsvmBdgId">
                                         <option value="<?php echo $KsvmLlenarForm['BdgId'];?>" selected="">
                                             <?php echo $KsvmLlenarForm['BdgDescBod'];?></option>
                                             <?php require_once "./Controladores/KsvmBodegaControlador.php";
											   $KsvmSelBod = new KsvmBodegaControlador();
											   echo $KsvmSelBod->__KsvmSeleccionarBodega();
										 ?>
                                     </select>
                                 </div>
                             </div>
                         </div>
                         <br>
                         <p class="text-center">
                             <button type="submit"
                                 class="mdl-button mdl-js-button mdl-js-ripple-effect btn-primary mdl-shadow--4dp"
                                 id="btn-ActualizarBodegaXUsuario">
                                 <i class="zmdi zmdi-save">&nbsp;Guardar</i>
                             </button>
                         </p>
                         <div class="mdl-tooltip" for="btn-ActualizarBodegaXUsuario">Actualizar Asigna Bodega</div>
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