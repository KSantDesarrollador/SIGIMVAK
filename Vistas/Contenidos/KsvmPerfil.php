 <!--
* Copyright 2019 Klever Santiago Vaca Muela
-->

 <!-- pageContent -->
 <section class="full-width pageContent">
     <section class="full-width header-well">
         <div class="full-width header-well-icon">
             <i class="zmdi zmdi-account"></i>
         </div>
         <div class="full-width header-well-text">
             <p class="text-condensedLight">
                 PERFIL DE USUARIO
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
    $KsvmDataEdit = $KsvmIniUsu->__KsvmEditarPerfilControlador($KsvmPagina[1]);

    if ($KsvmDataEdit->rowCount() == 1) {
        $KsvmLlenarForm = $KsvmDataEdit->fetch();

        $KsvmCantra = $KsvmIniUsu->__KsvmDesencriptarPerfil($KsvmLlenarForm['UsrContraUsu']);
    
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
                 <br>
                 <div class="full-width panel mdl-shadow--8dp">
                     <div class="full-width  modal-header-edit text-center ">
                         Editar Perfil
                     </div>
                     <div class="full-width panel-content">
                         <form data-form="guardar" action="<?php echo KsvmServUrl; ?>Ajax/KsvmUsuarioAjax.php"
                             method="POST" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data"
                             id="KsvmFormUsuario">
                             <input type="hidden" name="KsvmCodEdit" value="<?php echo $KsvmPagina[1]; ?>">
                             <div class="mdl-grid">
                                 <div
                                     class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--4-col-desktop">
                                     <div class="">
                                         <label class="mdl-textfield"><img style="border-radius:7px;" height="250px"
                                                 width="70%"
                                                 src="data:image/jpg;base64,<?php echo base64_encode($KsvmLlenarForm['UsrImgUsu']);?>" />&nbsp;</label>
                                     </div>
                                 </div>
                                 <div
                                     class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--8-col-desktop">
                                     <div class="mdl-textfield mdl-js-textfield">
                                         <div class="mdl-textfield__input">
                                             <span><?php echo $KsvmLlenarForm['RrlNomRol'];?></span>
                                         </div>
                                     </div>
                                     <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                         <div class="mdl-textfield__input">
                                             <span><?php echo $KsvmLlenarForm['UsrNomUsu'];?></span>
                                         </div>
                                     </div>
                                     <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                         <input class="mdl-textfield__input" type="tel" name="KsvmTelf"
                                             value="<?php echo $KsvmLlenarForm['UsrTelfUsu'];?>"
                                             pattern="[0-9()]{7,10}" id="KsvmDato1">
                                         <label class="mdl-textfield__label" for="KsvmDato1">Teléfono</label>
                                         <span class="mdl-textfield__error">Teléfono Inválido</span>
                                         <span id="KsvmError1" class="ValForm"><i
                                                 class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
                                                 campo</i></span>
                                     </div>
                                     <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                         <input class="mdl-textfield__input" type="password" name="KsvmContra"
                                             value="<?php echo  $KsvmCantra;?>" id="KsvmDato2"
                                             pattern="[A-Za-z0-9!?-]{8,16}">
                                         <label class="mdl-textfield__label" for="KsvmDato2">Contraseña</label>
                                         <span class="mdl-textfield__error">Contraseña Inválida</span>
                                         <span id="KsvmError2" class="ValForm"><i
                                                 class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
                                                 campo</i></span>
                                     </div>
                                     <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                         <input class="mdl-textfield__input" type="password" name="KsvmConContra"
                                             value="<?php echo $KsvmCantra;?>" id="KsvmDato3"
                                             pattern="[A-Za-z0-9!?-]{8,16}">
                                         <label class="mdl-textfield__label" for="KsvmDato3">Confirmar
                                             Contraseña</label>
                                         <span class="mdl-textfield__error">Contraseña Inválida</span>
                                         <span id="KsvmError3" class="ValForm"><i
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
                             <div class="mdl-tooltip" for="btnSave">Actualizar Usuario</div>
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