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
                 EDITAR-MENÚ
             </p>
         </div>
     </section>
     <div class="full-width divider-menu-h"></div>
     <!-- Método para cargar datos en el formulario -->
     <?php 

    require_once "./Controladores/KsvmMenuControlador.php";
    $KsvmIniMenu = new KsvmMenuControlador();
			  
    $KsvmPagina = explode("/", $_GET['Vistas']);
    if ($KsvmPagina[1] != "") {
    $KsvmDataEdit = $KsvmIniMenu->__KsvmEditarMenuControlador($KsvmPagina[1]);

    if ($KsvmDataEdit->rowCount() == 1) {
        $KsvmLlenarForm = $KsvmDataEdit->fetch();
    
        if ($KsvmLlenarForm['MnuUrlMen'] == "") {
            $KsvmUrl = "Sin Información";
          }else{
            $KsvmUrl = $KsvmLlenarForm['MnuUrlMen'];
          }

          if ($KsvmLlenarForm['MnuNivelMen'] == 0) {
              $KsvmNivel = "Nivel 0";
          } else {
              $KsvmNivel = "Nivel 1";
          }
          
        
          $KsvmEstado = "";
          if ($KsvmLlenarForm['MnuEstMen'] == 'A') {
            $KsvmEstado = "Activo";
          }else {
            $KsvmEstado = "Inactivo";
          }
          
        $KsvmJerq = $KsvmLlenarForm['MnuJerqMen'];
        
        $KsvmMostrarJerq = new KsvmMenuModelo();
        $KsvmMenu = $KsvmMostrarJerq -> __KsvmMostrarJerarquiaModelo($KsvmJerq);

        if ($KsvmMenu->rowCount() == 1) {
            $KsvmJerarquia = $KsvmMenu->fetch();
            $KsvmNomJerq = $KsvmJerarquia['MnuNomMen'];
        }else {
            $KsvmNomJerq = "Es Menú padre";
        }
            
?>

     <!-- Formulario para editar un Menu -->
     <div class="mdl-tabs" id="KsvmActualizarMenu">
         <div class="mdl-grid">
             <div
                 class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--13-col-desktop mdl-cell--0-offset-desktop">
                 <div class="navBar-options-button">
                     <a href="<?php echo KsvmServUrl;?>KsvmMenuCrud/1/" id="btn-input"
                         class="btn btn-sm btn-dark mdl-shadow--8dp btn-salir">VOLVER &nbsp;<i
                             class="zmdi zmdi-arrow-left"></i></a>
                 </div>
                 <br>
                 <div class="full-width panel mdl-shadow--8dp">
                     <div class="full-width  modal-header-edit text-center ">
                         Editar Menu
                     </div>
                     <div class="full-width panel-content">
                         <form data-form="guardar" action="<?php echo KsvmServUrl; ?>Ajax/KsvmMenuAjax.php"
                             method="POST" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data"
                             id="KsvmFormMenu">
                             <input type="hidden" name="KsvmCodEdit" value="<?php echo $KsvmPagina[1]; ?>">
                             <div class="mdl-grid">
                                 <div
                                     class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
                                     <div class="mdl-textfield mdl-js-textfield">
                                         <select class="mdl-textfield__input" name="KsvmNivelMen" id="KsvmDato1">
                                             <option value="<?php echo $KsvmLlenarForm['MnuNivelMen'];?>">
                                                 <?php echo $KsvmNivel;?></option>
                                             <option value="0">Nivel 0</option>
                                             <option value="1">Nivel 1</option>
                                         </select>
                                         <span id="KsvmError1" class="ValForm"><i
                                                 class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
                                                 campo</i></span>
                                     </div>
                                     <div class="mdl-textfield mdl-js-textfield">
                                         <select class="mdl-textfield__input" name="KsvmJerqMen">
                                             <option value="<?php echo $KsvmLlenarForm['MnuJerqMen'];?>" selected="">
                                                 <?php echo $KsvmNomJerq;?></option>
                                             <?php require_once "./Controladores/KsvmMenuControlador.php";
													$KsvmSelUndMed = new KsvmMenuControlador();
													echo $KsvmSelUndMed->__KsvmSeleccionarMenu();
													?>
                                         </select>
                                     </div>
                                     <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                         <input class="mdl-textfield__input" type="text" name="KsvmNomMen"
                                             value="<?php echo $KsvmLlenarForm['MnuNomMen']?>"
                                             pattern="-?[A-Za-z0-9áéíóúÁÉÍÓÚ ]*(\.[0-9]+)?" id="KsvmDato2">
                                         <label class="mdl-textfield__label" for="KsvmDato2">Nombre</label>
                                         <span class="mdl-textfield__error">Nombre Inválido</span>
                                         <span id="KsvmError2" class="ValForm"><i
                                                 class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
                                                 campo</i></span>
                                     </div>
                                     <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                         <input class="mdl-textfield__input" type="text" name="KsvmIconMen"
                                             value="<?php echo $KsvmLlenarForm['MnuIconMen']?>" id="KsvmDato3">
                                         <label class="mdl-textfield__label" for="KsvmDato3">Ícono</label>
                                         <span class="mdl-textfield__error">Ícono Inválido</span>
                                         <span id="KsvmError3" class="ValForm"><i
                                                 class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
                                                 campo</i></span>
                                     </div>
                                     <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                         <input class="mdl-textfield__input" type="text" name="KsvmUrlMen"
                                             value="<?php echo $KsvmLlenarForm['MnuUrlMen']?>" id="KsvmUrlMen">
                                         <label class="mdl-textfield__label" for="KsvmUrlMen">Url</label>
                                         <span class="mdl-textfield__error">Url Inválida</span>
                                     </div>
                                     <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                         <input class="mdl-textfield__input" type="text" name="KsvmLeyendMen"
                                             value="<?php echo $KsvmLlenarForm['MnuLeyendMen']?>" id="KsvmDato4">
                                         <label class="mdl-textfield__label" for="KsvmDato4">Leyenda</label>
                                         <span class="mdl-textfield__error">Leyenda Inválida</span>
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
                             <div class="mdl-tooltip" for="btnSave">Actualizar Menu</div>
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