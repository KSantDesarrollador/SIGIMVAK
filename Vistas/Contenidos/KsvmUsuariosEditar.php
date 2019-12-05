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
            EDITAR-USUARIOS
            </p>
        </div>
    </section>
    <div class="full-width divider-menu-h"></div>
 <!-- Método para cargar datos en el formulario -->
 <?php 

    require_once "./Controladores/KsvmUsuarioControlador.php";
    $KsvmIniUsu = new KsvmUsuarioControlador();
			  
    $KsvmPagina = explode("/", $_GET['Vistas']);
    if ($KsvmPagina[1] != "") {
    $KsvmDataEdit = $KsvmIniUsu->__KsvmEditarUsuarioControlador($KsvmPagina[1]);

    if ($KsvmDataEdit->rowCount() == 1) {
        $KsvmLlenarForm = $KsvmDataEdit->fetch();
    
        $KsvmEstado = "";
        if ($KsvmLlenarForm['UsrEstUsu'] == 'A') {
        $KsvmEstado = "Activo";
        }else {
        $KsvmEstado = "Inactivo";
        }
            
?>

 <!-- Formulario para editar un Usuario -->
 <div class="mdl-tabs" id="KsvmActualizarUsuario">
     <div class="mdl-grid">
         <div
             class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--13-col-desktop mdl-cell--0-offset-desktop">
             <div class="navBar-options-button">
             <?php 
               if ($KsvmPagina[2] == 0) {
                echo '<a href="'.KsvmServUrl.'KsvmUsuariosCrud/1/" id="btn-input"
                class="btn btn-sm btn-dark mdl-shadow--8dp btn-salir">VOLVER &nbsp;<i
                class="zmdi zmdi-arrow-left"></i>
                </a>';
               } else {
                echo '<a href="'.KsvmServUrl.'KsvmUsuarios/1/" id="btn-input"
                class="btn btn-sm btn-dark mdl-shadow--8dp btn-salir">VOLVER &nbsp;<i
                class="zmdi zmdi-arrow-left"></i>
                </a>';
               }
               
             ?>
            </div>
            <br>
             <div class="full-width panel mdl-shadow--8dp">
                 <div class="full-width  modal-header-edit text-center ">
                     Editar Usuario
                 </div>
                 <div class="full-width panel-content">
                     <form data-form="guardar" action="<?php echo KsvmServUrl; ?>Ajax/KsvmUsuarioAjax.php" method="POST"
                         class="FormularioAjax" autocomplete="off" enctype="multipart/form-data" id="KsvmFormUsuario">
                         <input type="hidden" name="KsvmCodEdit" value="<?php echo $KsvmPagina[1]; ?>">
                         <div class="mdl-grid">
                             <div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--6-col-desktop">
                                 <div class="mdl-textfield mdl-js-textfield">
                                 <select class="mdl-textfield__input" name="KsvmRol">
                                         <option value="<?php echo $KsvmLlenarForm['RrlId'];?>" selected="">
                                             <?php echo $KsvmLlenarForm['RrlNomRol'];?></option>
                                             <?php require_once "./Controladores/KsvmRolControlador.php";
											   $KsvmSelRol = new KsvmRolControlador();
											   echo $KsvmSelRol->__KsvmSeleccionarRol();
										     ?>
                                 </div>
                                 <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                     <input class="mdl-textfield__input" type="tel" name="KsvmTelf"
                                         value="<?php echo $KsvmLlenarForm['UsrTelfUsu'];?>"
                                         pattern="-?[0-9+()-]*(\.[0-9]+)?" id="KsvmTelf">
                                     <label class="mdl-textfield__label" for="KsvmTelf">Teléfono</label>
                                     <span class="mdl-textfield__error">Teléfono Inválido</span>
                                 </div>
                                 <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                     <input class="mdl-textfield__input" type="email" name="KsvmEmail"
                                         value="<?php echo $KsvmLlenarForm['UsrEmailUsu'];?>" id="KsvmEmail">
                                     <label class="mdl-textfield__label" for="KsvmEmail">E-mail</label>
                                     <span class="mdl-textfield__error">E-mail Inválido</span>
                                 </div>
                                 <div class="">
                                     <label class="mdl-textfield"><img height="33px" width="45px" src="data:image/jpg;base64,<?php echo base64_encode($KsvmLlenarForm['UsrImgUsu']);?>"/>&nbsp;Cambiar Imagen</label>
                                     <input class="mdl-textfield__input" type="file" name="KsvmImgUsu" id="KsvmImgUsu" value="<?php echo base64_encode($KsvmLlenarForm['UsrImgUsu']);?>">
                                   </div>
                             </div>
                             <div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--6-col-desktop">
                                 <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                     <input class="mdl-textfield__input" type="text" name="KsvmNomUsu"
                                         value="<?php echo $KsvmLlenarForm['UsrNomUsu'];?>"
                                         pattern="-?[A-Za-z0-9áéíóúÁÉÍÓÚ]*(\.[0-9]+)?" id="KsvmNomUsu">
                                     <label class="mdl-textfield__label" for="KsvmNomUsu">Usuario</label>
                                     <span class="mdl-textfield__error">Usuario Inválido</span>
                                 </div>
                                 <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                     <input class="mdl-textfield__input" type="password" name="KsvmContra"
                                         value="<?php echo  $KsvmLlenarForm['UsrContraUsu'];?>" id="KsvmContra" disabled>
                                     <label class="mdl-textfield__label" for="KsvmContra">Contraseña</label>
                                     <span class="mdl-textfield__error">Contraseña Inválida</span>
                                 </div>
                                 <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                     <input class="mdl-textfield__input" type="password" name="KsvmConContra"
                                         value="<?php echo $KsvmLlenarForm['UsrContraUsu'];?>" id="KsvmConContra" disabled>
                                     <label class="mdl-textfield__label" for="KsvmConContra">Confirmar
                                         Contraseña</label>
                                     <span class="mdl-textfield__error">Contraseña Inválida</span>
                                 </div>
                             </div>
                         </div>
                         <br>
                         <p class="text-center">
                             <button type="submit"
                                 class="mdl-button mdl-js-button mdl-js-ripple-effect btn-primary mdl-shadow--4dp"
                                 id="btn-ActualizarUsuario">
                                 <i class="zmdi zmdi-save">&nbsp;Guardar</i>
                             </button>
                         </p>
                         <div class="mdl-tooltip" for="btn-ActualizarUsuario">Actualizar Usuario</div>
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