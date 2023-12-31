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
                 EDITAR-ROLES
             </p>
         </div>
     </section>
     <div class="full-width divider-menu-h"></div>
     <!-- Método para cargar datos en el formulario -->
     <?php 

    require_once "./Controladores/KsvmRolControlador.php";
    $KsvmIniRol = new KsvmRolControlador();
			  
    $KsvmPagina = explode("/", $_GET['Vistas']);
    if ($KsvmPagina[1] != "") {
    $KsvmDataEdit = $KsvmIniRol->__KsvmEditarRolControlador($KsvmPagina[1]);

    if ($KsvmDataEdit->rowCount() == 1) {
        $KsvmLlenarForm = $KsvmDataEdit->fetch();

        $KsvmEstado = "";
        if ($KsvmLlenarForm['RrlEstRol'] == 'A') {
            $KsvmEstado = "Activo";
        } else {
            $KsvmEstado = "Inactivo";
        }
            
?>

     <!-- Formulario para editar un Rol -->
     <div class="mdl-tabs" id="KsvmActualizarRol">
         <div class="mdl-grid">
             <div
                 class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--13-col-desktop mdl-cell--0-offset-desktop">
                 <div class="navBar-options-button">
                     <?php 
               if ($KsvmPagina[2] == 0) {
                echo '<a href="'.KsvmServUrl.'KsvmRolesCrud/1/" id="btn-input"
                class="btn btn-sm btn-dark mdl-shadow--8dp btn-salir">VOLVER &nbsp;<i
                class="zmdi zmdi-arrow-left"></i>
                </a>';
               } else {
                echo '<a href="'.KsvmServUrl.'KsvmRoles/1/" id="btn-input"
                class="btn btn-sm btn-dark mdl-shadow--8dp btn-salir">VOLVER &nbsp;<i
                class="zmdi zmdi-arrow-left"></i>
                </a>';
               }
               
             ?>
                 </div>
                 <br>
                 <div class="full-width panel mdl-shadow--8dp">
                     <div class="full-width  modal-header-edit text-center ">
                         Editar Rol
                     </div>
                     <div class="full-width panel-content">
                         <form data-form="guardar" action="<?php echo KsvmServUrl; ?>Ajax/KsvmRolAjax.php" method="POST"
                             class="FormularioAjax" autocomplete="off" enctype="multipart/form-data" id="KsvmFormRol">
                             <input type="hidden" name="KsvmCodEdit" value="<?php echo $KsvmPagina[1]; ?>">
                             <div class="mdl-grid">
                                 <div
                                     class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
                                     <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                         <input class="mdl-textfield__input" type="text" name="KsvmNomRol"
                                             value="<?php echo $KsvmLlenarForm['RrlNomRol'];?>"
                                             pattern="-?[A-Za-z0-9áéíóúÁÉÍÓÚñ ]*(\.[0-9]+)?" id="KsvmDato1">
                                         <label class="mdl-textfield__label" for="KsvmDato1">Nombre</label>
                                         <span class="mdl-textfield__error">Nombre Inválido</span>
                                         <span id="KsvmError1" class="ValForm"><i
                                                 class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
                                                 campo</i></span>
                                     </div>
                                     <br>
                                     <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                         <select class="mdl-textfield__input" name="KsvmEstRol" id="KsvmDato2">
                                             <option value="<?php echo $KsvmLlenarForm['RrlEstRol'];?>" selected="">
                                                 <?php echo $KsvmEstado;?></option>
                                             <option value="A">Activo</option>
                                             <option value="I">Inactivo</option>
                                         </select>
                                         <span id="KsvmError2" class="ValForm"><i
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
                             <div class="mdl-tooltip" for="btnSave">Actualizar Rol</div>
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