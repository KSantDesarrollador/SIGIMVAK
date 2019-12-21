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
                 EDITAR-MEDICAMENTOS
             </p>
         </div>
     </section>
     <div class="full-width divider-menu-h"></div>
     <!-- Método para cargar datos en el formulario -->
     <?php 

        require_once "./Controladores/KsvmMedicamentoControlador.php";
        $KsvmIniMed = new KsvmMedicamentoControlador();
			  
		  $KsvmPagina = explode("/", $_GET['Vistas']);
		  if ($KsvmPagina[1] != "") {
		  $KsvmDataEdit = $KsvmIniMed->__KsvmEditarMedicamentoControlador($KsvmPagina[1]);

		  if ($KsvmDataEdit->rowCount() == 1) {
              $KsvmLlenarForm = $KsvmDataEdit->fetch();

              $KsvmViaAdmin = $KsvmLlenarForm['MdcViaAdmMed'];

              switch ($KsvmViaAdmin) {
                case 'P':
                $KsvmViaAdmin = "P";
                break;
                case 'O':
                $KsvmViaAdmin = "O";
                break;
                case 'T':
                $KsvmViaAdmin = "T";
                break;
                case 'N':
                $KsvmViaAdmin = "N";
                break;
                case 'R':
                $KsvmViaAdmin = "R";
                break;
                case 'I':
                $KsvmViaAdmin = "I";
                break;
                case 'Oc':
                $KsvmViaAdmin = "Oc";
                break;
                case 'O/v':
                $KsvmViaAdmin = "O/v";
                break;
                case 'IT':
                $KsvmViaAdmin = "IT";
                break;
                case 'P/MI':
                $KsvmViaAdmin = "P/MI";
                break;
                case 'P/IV':
                $KsvmViaAdmin = "P/IV";
                break;
                case 'P(IM)':
                $KsvmViaAdmin = "P(IM)";
                break;
                case 'P(IV)':
                $KsvmViaAdmin = "P(IV)";
                break;
                case 'SC':
                $KsvmViaAdmin = "SC";
                break;
                      
                default;
                break;
              }
              

              $KsvmNivPresc = $KsvmLlenarForm['MdcNivPrescMed'];
              switch ($KsvmNivPresc) {
                case 'E':
                $KsvmNivPresc = "E";
                break;
                case 'H':
                $KsvmNivPresc = "H";
                break;
                case 'HE':
                $KsvmNivPresc = "HE";
                break;
                case 'E(p)':
                $KsvmNivPresc = "E(p)";
                break;
                case 'H(p)':
                $KsvmNivPresc = "H(p)";
                break;
                case 'HE(p)':
                $KsvmNivPresc = "HE(p)";
                break;
                case '(p)':
                $KsvmNivPresc = "(p)";
                break;

                default:
                break;
                }
                

              $KsvmEstado = "";
				if ($KsvmLlenarForm['MdcEstMed'] == 'A') {
				    $KsvmEstado = "Activo";
				} else {
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
                echo '<a href="'.KsvmServUrl.'KsvmMedicamentosCrud/1/" id="btn-input"
                class="btn btn-sm btn-dark mdl-shadow--8dp btn-salir">VOLVER &nbsp;<i
                class="zmdi zmdi-arrow-left"></i>
                </a>';
               } else {
                echo '<a href="'.KsvmServUrl.'KsvmCatalogoMedicamentos/1/" id="btn-input"
                class="btn btn-sm btn-dark mdl-shadow--8dp btn-salir">VOLVER &nbsp;<i
                class="zmdi zmdi-arrow-left"></i>
                </a>';
               }
               
             ?>
                 </div>
                 <br>
                 <div class="full-width panel mdl-shadow--8dp">
                     <div class="full-width  modal-header-edit text-center ">
                         Editar Medicamento
                     </div>
                     <div class="full-width panel-content">
                         <form data-form="modificar" action="<?php echo KsvmServUrl; ?>Ajax/KsvmMedicamentoAjax.php"
                             method="POST" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data"
                             id="KsvmFormMed">
                             <input type="hidden" name="KsvmCodEdit" value="<?php echo $KsvmPagina[1]; ?>">
                             <div class="mdl-grid">
                                 <!-- <input type="HIDDEN" name="dest-exists-action" value="overwrite"/> -->
                                 <div class="mdl-textfield mdl-js-textfield">
                                     <select class="mdl-textfield__input" name="KsvmCtgId" id="KsvmDato1">
                                         <option value="<?php echo $KsvmLlenarForm['CtgId'];?>" selected="">
                                             <?php echo $KsvmLlenarForm['CtgNomCat'];?></option>
                                         <?php require_once "./Controladores/KsvmCategoriaControlador.php";
											   $KsvmSelCat = new KsvmCategoriaControlador();
											   echo $KsvmSelCat->__KsvmSeleccionarCategoria();
										     ?>
                                     </select>
                                     <span id="KsvmError1" class="ValForm"><i class="zmdi zmdi-alert-triangle">&nbsp;Por
                                             favor llene este
                                             campo</i></span>
                                 </div>
                                 <div
                                     class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--6-col-desktop">
                                     <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                         <input class="mdl-textfield__input" type="text" name="KsvmCodMed"
                                             value="<?php echo $KsvmLlenarForm['MdcCodMed'];?>" id="KsvmDato2">
                                         <label class="mdl-textfield__label" for="KsvmDato2">Código</label>
                                         <span class="mdl-textfield__error">Código Inválido</span>
                                         <span id="KsvmError2" class="ValForm"><i
                                                 class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
                                                 campo</i></span>
                                     </div>
                                     <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                         <input class="mdl-textfield__input" type="text" name="KsvmPresenMed"
                                             value="<?php echo $KsvmLlenarForm['MdcPresenMed'];?>"
                                             pattern="-?[A-Za-záéíóúÁÉÍÓÚ ]*(\.[0-9]+)?" id="KsvmDato3">
                                         <label class="mdl-textfield__label" for="KsvmDato3">Presentación</label>
                                         <span class="mdl-textfield__error">Presentación Inválida</span>
                                         <span id="KsvmError3" class="ValForm"><i
                                                 class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
                                                 campo</i></span>
                                     </div>
                                     <div class="mdl-textfield mdl-js-textfield">
                                         <select class="mdl-textfield__input" name="KsvmNivPrescMed" id="KsvmDato4">
                                             <option value="<?php echo $KsvmLlenarForm['MdcNivPrescMed'];?>"
                                                 selected=""><?php echo $KsvmNivPresc;?></option>
                                             <option value="E">E</option>
                                             <option value="H">H</option>
                                             <option value="HE">HE</option>
                                             <option value="E(p)">E(P)</option>
                                             <option value="H(p)">H(p)</option>
                                             <option value="HE(p)">HE(p)</option>
                                             <option value="(p)">(p)</option>
                                         </select>
                                         <span id="KsvmError4" class="ValForm"><i
                                                 class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
                                                 campo</i></span>
                                     </div>
                                     <div class="mdl-textfield mdl-js-textfield">
                                         <select class="mdl-textfield__input" name="KsvmViaAdmMed" id="KsvmDato5">
                                             <option value="<?php echo $KsvmLlenarForm['MdcViaAdmMed'];?>" selected="">
                                                 <?php echo $KsvmViaAdmin;?></option>
                                             <option value="P">P</option>
                                             <option value="O">O</option>
                                             <option value="T">T</option>
                                             <option value="N">N</option>
                                             <option value="R">R</option>
                                             <option value="I">I</option>
                                             <option value="Oc">Oc</option>
                                             <option value="O/V">O/v</option>
                                             <option value="IT">IT</option>
                                             <option value="P/MI">P/MI</option>
                                             <option value="P/IV">P/IV</option>
                                             <option value="P(MI)">P(MI)</option>
                                             <option value="P(IV)">P(IV)</option>
                                             <option value="SC">SC</option>
                                         </select>
                                         <span id="KsvmError5" class="ValForm"><i
                                                 class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
                                                 campo</i></span>
                                     </div>

                                 </div>
                                 <div
                                     class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--6-col-desktop">
                                     <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                         <input class="mdl-textfield__input" type="text" name="KsvmDescMed"
                                             value="<?php echo $KsvmLlenarForm['MdcDescMed'];?>"
                                             pattern="-?[A-Za-záéíóúÁÉÍÓÚ ]*(\.[0-9]+)?" id="KsvmDato6">
                                         <label class="mdl-textfield__label" for="KsvmDato6">Descripción</label>
                                         <span class="mdl-textfield__error">Descripción Inválida</span>
                                         <span id="KsvmError6" class="ValForm"><i
                                                 class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
                                                 campo</i></span>
                                     </div>
                                     <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                         <input class="mdl-textfield__input" type="text" name="KsvmConcenMed"
                                             value="<?php echo $KsvmLlenarForm['MdcConcenMed'];?>" id="KsvmDato7">
                                         <label class="mdl-textfield__label" for="KsvmDato7">Concentración</label>
                                         <span class="mdl-textfield__error">Concentración Inválida</span>
                                         <span id="KsvmError7" class="ValForm"><i
                                                 class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
                                                 campo</i></span>
                                     </div>
                                     <div class="mdl-textfield mdl-js-textfield">
                                         <select class="mdl-textfield__input" name="KsvmNivAtencMed" id="KsvmDato8">
                                             <option value="<?php echo $KsvmLlenarForm['MdcNivAtencMed'];?>"
                                                 selected=""><?php echo $KsvmLlenarForm['MdcNivAtencMed'];?></option>
                                             <option value="I">Nivel 1</option>
                                             <option value="II">Nivel 2</option>
                                             <option value="III">Nivel 3</option>
                                             <option value="I-II">Nivel 1-2</option>
                                             <option value="I-III">Nivel 1-3</option>
                                             <option value="II-III">Nivel 2-3</option>
                                             <option value="I-II-III">Nivel 1-2-3</option>
                                         </select>
                                         <span id="KsvmError8" class="ValForm"><i
                                                 class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
                                                 campo</i></span>
                                     </div>
                                     <div class="">
                                         <label class="mdl-textfield"><img height="40px" width="45px"
                                                 src="data:image/png;base64,<?php echo base64_encode($KsvmLlenarForm['MdcFotoMed']);?>" />&nbsp;Cambiar
                                             Imagen</label>
                                         <input class="mdl-textfield__input" type="file" name="KsvmFotoMed"
                                             id="KsvmFotoMed">
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
                             <div class="mdl-tooltip" for="btnSave">Editar Medicamento</div>
                             <div class="RespuestaAjax"></div>
                         </form>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <?php } }?>

 </section>