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
                $KsvmViaAdmin = "";
                break;
                case 'O':
                $KsvmViaAdmin = "";
                break;
                case 'T':
                $KsvmViaAdmin = "";
                break;
                case 'N':
                $KsvmViaAdmin = "";
                break;
                case 'R':
                $KsvmViaAdmin = "";
                break;
                case 'I':
                $KsvmViaAdmin = "";
                break;
                case 'Oc':
                $KsvmViaAdmin = "";
                break;
                case 'O/v':
                $KsvmViaAdmin = "";
                break;
                case 'IT':
                $KsvmViaAdmin = "";
                break;
                case 'P/MI':
                $KsvmViaAdmin = "";
                break;
                case 'P/IV':
                $KsvmViaAdmin = "";
                break;
                case 'P(IM)':
                $KsvmViaAdmin = "";
                break;
                case 'P(IV)':
                $KsvmViaAdmin = "";
                break;
                case 'SC':
                $KsvmViaAdmin = "";
                break;
                      
                default;
                break;
              }
              

              $KsvmNivPresc = $KsvmLlenarForm['MdcNivPrescMed'];
              switch ($KsvmNivPresc) {
                case 'E':
                $KsvmNivPresc = "";
                break;
                case 'H':
                $KsvmNivPresc = "";
                break;
                case 'HE':
                $KsvmNivPresc = "";
                break;
                case 'E(p)':
                $KsvmNivPresc = "";
                break;
                case 'H(p)':
                $KsvmNivPresc = "";
                break;
                case 'HE(p)':
                $KsvmNivPresc = "";
                break;
                case '(p)':
                $KsvmNivPresc = "";
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
                            <input type="HIDDEN" name="dest-exists-action" value="overwrite"/>
                            <div class="mdl-textfield mdl-js-textfield">
									<select class="mdl-textfield__input" name="KsvmCtgId">
                                         <option value="<?php echo $KsvmLlenarForm['CtgId'];?>" selected="">
                                             <?php echo $KsvmLlenarForm['CtgNomCat'];?></option>
                                             <?php require_once "./Controladores/KsvmCategoriaControlador.php";
											   $KsvmSelCat = new KsvmCategoriaControlador();
											   echo $KsvmSelCat->__KsvmSeleccionarCategoria();
										     ?>
                                     </select>
                                    </div>
								<div
									class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--6-col-desktop">
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<input class="mdl-textfield__input" type="text" name="KsvmCodMed"
											value="<?php echo $KsvmLlenarForm['MdcCodMed'];?>"
											 id="KsvmCodMed">
										<label class="mdl-textfield__label" for="KsvmCodMed">Código</label>
										<span class="mdl-textfield__error">Código Inválido</span>
                                    </div>
                                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<input class="mdl-textfield__input" type="text" name="KsvmPresenMed"
											value="<?php echo $KsvmLlenarForm['MdcPresenMed'];?>"
											pattern="-?[A-Za-záéíóúÁÉÍÓÚ ]*(\.[0-9]+)?" id="KsvmPresenMed">
										<label class="mdl-textfield__label" for="KsvmPresenMed">Presentación</label>
										<span class="mdl-textfield__error">Presentación Inválida</span>
									</div>
									<div class="mdl-textfield mdl-js-textfield">
										<select class="mdl-textfield__input" name="KsvmNivPrescMed">
											<option value="<?php echo $KsvmLlenarForm['MdcNivPrescMed'];?>"
												selected=""><?php echo $KsvmNivPresc;?></option>
											<option value="E">?</option>
											<option value="H">?</option>
											<option value="HE">?</option>
                                            <option value="E(p)">?</option>
                                            <option value="H(p)">?</option>
                                            <option value="HE(p)">?</option>
                                            <option value="(p)">?</option>
										</select>
									</div>
									<div class="mdl-textfield mdl-js-textfield">
										<select class="mdl-textfield__input" name="KsvmViaAdmMed">
											<option value="<?php echo $KsvmLlenarForm['MdcViaAdmMed'];?>"
												selected=""><?php echo $KsvmViaAdmin;?></option>
                                            <option value="P">?</option>
											<option value="O">?</option>
											<option value="T">?</option>
                                            <option value="N">?</option>
                                            <option value="R">?</option>
                                            <option value="I">?</option>
                                            <option value="Oc">?</option>
                                            <option value="O/V">?</option>
                                            <option value="IT">?</option>
                                            <option value="P/MI">?</option>
                                            <option value="P/IV">?</option>
                                            <option value="P(MI)">?</option>
                                            <option value="P(IV)">?</option>
                                            <option value="SC">?</option>
										</select>
									</div>
										
								</div>
								<div
									class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--6-col-desktop">	
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<input class="mdl-textfield__input" type="text" name="KsvmDescMed"
											value="<?php echo $KsvmLlenarForm['MdcDescMed'];?>"
											pattern="-?[A-Za-záéíóúÁÉÍÓÚ ]*(\.[0-9]+)?" id="KsvmDescMed">
										<label class="mdl-textfield__label" for="KsvmDescMed">Descripción</label>
										<span class="mdl-textfield__error">Descripción Inválida</span>
                                    </div>
                                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<input class="mdl-textfield__input" type="text" name="KsvmConcenMed"
											value="<?php echo $KsvmLlenarForm['MdcConcenMed'];?>"
											 id="KsvmConcenMed">
										<label class="mdl-textfield__label" for="KsvmConcenMed">Concentración</label>
										<span class="mdl-textfield__error">Concentración Inválida</span>
                                    </div>
                                    <div class="mdl-textfield mdl-js-textfield">
										<select class="mdl-textfield__input" name="KsvmNivAtencMed">
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
                                    </div>
                                    <div class="">
                                     <label class="mdl-textfield"><img height="33px" width="45px" src="data:image/png;base64,<?php echo base64_encode($KsvmLlenarForm['MdcFotoMed']);?>"/>&nbsp;Cambiar Imagen</label>
                                     <input class="mdl-textfield__input" type="file" name="KsvmFotoMed" id="KsvmFotoMed">
                                   </div>
								</div>
							</div>
                            <br>
							<p class="text-center">
								<button type="submit"
									class="mdl-button mdl-js-button mdl-js-ripple-effect btn-primary mdl-shadow--4dp"
									id="btn-NuevoMedicamento">
									<i class="zmdi zmdi-save">&nbsp;Guardar</i>
								</button>
							</p>
							<div class="mdl-tooltip" for="btn-NuevoMedicamento">Editar Medicamento</div>
							<div class="RespuestaAjax"></div>
						</form>
					</div>
				</div>
			</div>
		</div>
        </div>
		<?php } }?>

 </section>