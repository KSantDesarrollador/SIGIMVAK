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
			EDITAR-EMPLEADOS
            </p>
        </div>
    </section>
    <div class="full-width divider-menu-h"></div>
 <!-- Método para cargar datos en el formulario -->
 <?php 

        require_once "./Controladores/KsvmEmpleadoControlador.php";
        $KsvmIniEmp = new KsvmEmpleadoControlador();
			  
		  $KsvmPagina = explode("/", $_GET['Vistas']);
		  if ($KsvmPagina[1] != "") {
		  $KsvmDataEdit = $KsvmIniEmp->__KsvmEditarEmpleadoControlador($KsvmPagina[1]);

		  if ($KsvmDataEdit->rowCount() == 1) {
			  $KsvmLlenarForm = $KsvmDataEdit->fetch();

			  if ($KsvmLlenarForm['PrcJerqProc'] == "") {

				$KsvmPais = $KsvmLlenarForm['PrcNomProc'];
				$KsvmProvincia = "Sin Información";
				$KsvmCanton = "Sin Información";
				$KsvmParroquia = "Sin Información";
			  }else{
			  
			  $KsvmParroquia = $KsvmLlenarForm['PrcNomProc'];

			  require_once "./Controladores/KsvmProcedenciaControlador.php";
				$KsvmSelProc = new KsvmProcedenciaControlador();

				$KsvmCbxCan = $KsvmSelProc->__KsvmSeleccionaProcedencia($KsvmLlenarForm['PrcJerqProc']);
				$KsvmCanton = $KsvmCbxCan['PrcNomProc'];		
				
				$KsvmCbxProv = $KsvmSelProc->__KsvmSeleccionaProcedencia($KsvmCbxCan['PrcJerqProc']);
				$KsvmProvincia = $KsvmCbxProv['PrcNomProc'];	

				$KsvmCbxPais = $KsvmSelProc->__KsvmSeleccionaProcedencia($KsvmCbxProv['PrcJerqProc']);
				$KsvmPais = $KsvmCbxPais['PrcNomProc'];
			  }
			
			  if ($KsvmLlenarForm['EpoTipIdentEmp'] == "C") {
				  $KsvmTipo = "Cedula";
			  }else {
				 $KsvmTipo = "Pasaporte";
			  }

			  if ($KsvmLlenarForm['EpoEstCivEmp'] == "S") {
				  $KsvmCivil = "Soltero/a";
			  } elseif($KsvmLlenarForm['EpoEstCivEmp'] == "U") {
				  $KsvmCivil = "Union libre";
			  } elseif ($KsvmLlenarForm['EpoEstCivEmp'] == "C") {
				  $KsvmCivil = "Casado/a";
			  } elseif ($KsvmLlenarForm['EpoEstCivEmp'] == "D") {
				  $KsvmCivil = "Divorciado/a";  
			  } else {
				  $KsvmCivil = "Viudo/a";
			  }

			  if ($KsvmLlenarForm['EpoSexoEmp'] == "H") {
				  $KsvmSexo = "Hombre";
			  } else {
				  $KsvmSexo = "Mujer";
			  }

			  if ($KsvmLlenarForm['EpoGeneroEmp'] == "M") {
				$KsvmGenero = "Masculino";
			} elseif ($KsvmLlenarForm['EpoGeneroEmp'] == "F") {
				$KsvmGenero = "Femenino";
			}else{
				$KsvmGenero = "Indeterminado";
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
                echo '<a href="'.KsvmServUrl.'KsvmEmpleadosCrud/1/" id="btn-input"
                class="btn btn-sm btn-dark mdl-shadow--8dp btn-salir">VOLVER &nbsp;<i
                class="zmdi zmdi-arrow-left"></i>
                </a>';
               } else {
                echo '<a href="'.KsvmServUrl.'KsvmEmpleados/1/" id="btn-input"
                class="btn btn-sm btn-dark mdl-shadow--8dp btn-salir">VOLVER &nbsp;<i
                class="zmdi zmdi-arrow-left"></i>
                </a>';
               }
               
             ?>
            </div>
            <br>
             <div class="full-width panel mdl-shadow--8dp">
                 <div class="full-width  modal-header-edit text-center ">
                     Editar Empleado
                 </div>
                 <div class="full-width panel-content">
                 <form data-form="modificar" action="<?php echo KsvmServUrl; ?>Ajax/KsvmEmpleadoAjax.php"
							method="POST" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data"
							id="KsvmFormEmp">
							<input type="hidden" name="KsvmCodEdit" value="<?php echo $KsvmPagina[1]; ?>">
							<div class="mdl-grid">
								<div
									class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--6-col-desktop">
									<div class="mdl-textfield mdl-js-textfield">
											<select class="ksvmSelectDin" style="width:100%;" name="KsvmIdPais" id="KsvmCargaListaPais" required>
												<option value="<?php echo $KsvmLlenarForm['PrcId']?>" selected=""><?php echo $KsvmPais;?></option>
												<?php 
													echo $KsvmSelProc->__KsvmSeleccionarJerarquia();
												 ?>
											</select>
										</div>
										<div class="mdl-textfield mdl-js-textfield">
											<select class="ksvmSelectDin" style="width:100%;" id="KsvmCargaListaCanton">
												<option value="" selected=""><?php echo $KsvmCanton;?></option>
											</select>
										</div>
									<div class="mdl-textfield mdl-js-textfield">
										<select class="ksvmSelectDin" style="width:100%;" name="KsvmTipoIdent" id="KsvmDato1">
											<option value="<?php echo $KsvmLlenarForm['EpoTipIdentEmp'];?>"
												selected=""><?php echo $KsvmTipo;?>
											</option>
											<option value="C">Cédula</option>
											<option value="P">Pasaporte</option>
										</select>
										<span id="KsvmError1" class="ValForm"><i
													class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
													campo</i></span>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<input class="mdl-textfield__input" type="text" name="KsvmIdent"
											value="<?php echo $KsvmLlenarForm['EpoIdentEmp'];?>"
											pattern="[0-9]{10,13}" id="Ident" onkeyup="IdValido()">
										<label class="mdl-textfield__label" for="Ident">Identificación</label>
										<span id="KsvmErrorIdent" class=""></span>
										<span id="KsvmError2" class="ValForm"><i
													class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
													campo</i></span>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<input class="mdl-textfield__input" type="text" name="KsvmPrimApel"
											value="<?php echo $KsvmLlenarForm['EpoPriApeEmp'];?>"
											pattern="-?[A-Za-záéíóúÁÉÍÓÚ ]*(\.[0-9]+)?" id="KsvmDato3">
										<label class="mdl-textfield__label" for="KsvmDato3">Primer Apellido</label>
										<span class="mdl-textfield__error">Apellido Inválido</span>
										<span id="KsvmError3" class="ValForm"><i
													class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
													campo</i></span>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<input class="mdl-textfield__input" type="text" name="KsvmSegApel"
											value="<?php echo $KsvmLlenarForm['EpoSegApeEmp'];?>"
											pattern="-?[A-Za-záéíóúÁÉÍÓÚ ]*(\.[0-9]+)?" id="KsvmDato4">
										<label class="mdl-textfield__label" for="KsvmDato4">Segundo Apellido</label>
										<span class="mdl-textfield__error">Apellido Inválido</span>
										<span id="KsvmError4" class="ValForm"><i
													class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
													campo</i></span>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<input class="mdl-textfield__input" type="text" name="KsvmPrimNom"
											value="<?php echo $KsvmLlenarForm['EpoPriNomEmp'];?>"
											pattern="-?[A-Za-záéíóúÁÉÍÓÚ ]*(\.[0-9]+)?" id="KsvmDato5">
										<label class="mdl-textfield__label" for="KsvmDato5">Primer Nombre</label>
										<span class="mdl-textfield__error">Nombre Inválido</span>
										<span id="KsvmError5" class="ValForm"><i
													class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
													campo</i></span>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<input class="mdl-textfield__input" type="text" name="KsvmSegNom"
											value="<?php echo $KsvmLlenarForm['EpoSegNomEmp'];?>"
											pattern="-?[A-Za-záéíóúÁÉÍÓÚ ]*(\.[0-9]+)?" id="KsvmDato6">
										<label class="mdl-textfield__label" for="KsvmDato6">Segundo Nombre</label>
										<span class="mdl-textfield__error">Nombre Inválido</span>
										<span id="KsvmError6" class="ValForm"><i
													class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
													campo</i></span>
									</div>
									<div class="mdl-textfield mdl-js-textfield">
										<input type="text" class="mdl-textfield__input tcal" id="KsvmDato7" style="width:93%;"
											value="<?php echo $KsvmLlenarForm['EpoFchNacEmp'];?>" name="KsvmFchNac"
											placeholder="Fecha de nacimiento" pattern="[0-9-]{10,10}">
										<label class="mdl-textfield__label" for="KsvmDato7"></label>
										<span class="mdl-textfield__error">Fecha Inválida</span>
										<span id="KsvmError7" class="ValForm"><i
													class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
													campo</i></span>
									</div>
									<div class="">
                                     <label class="mdl-textfield"><img height="45px" width="45px" src="data:image/jpg;base64,<?php echo base64_encode($KsvmLlenarForm['EpoFotoEmp']);?>"/>&nbsp;
									 <input class="mdl-textfield__input" type="file" name="KsvmFotoEmp" id="KsvmFotoEmp">
									 Cambiar Imagen</label>
                                   </div>
								</div>
								<div
									class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--6-col-desktop">
									<div class="mdl-textfield mdl-js-textfield">
											<select class="ksvmSelectDin" style="width:100%;" id="KsvmCargaListaProvincia">
												<option value="" selected=""><?php echo $KsvmProvincia;?></option>
											</select>
										</div>
										<div class="mdl-textfield mdl-js-textfield">
											<select class="ksvmSelectDin" style="width:100%;" name="KsvmIdParroquia" id="KsvmCargaListaParroquia">
												<option value="<?php echo $KsvmLlenarForm['PrcId']?>" selected=""><?php echo $KsvmParroquia;?></option>
											</select>
										</div>
									<div class="mdl-textfield mdl-js-textfield">
									<select class="ksvmSelectDin" style="width:100%;" name="KsvmRol" id="KsvmDato8">
                                         <option value="<?php echo $KsvmLlenarForm['RrlId'];?>" selected="">
                                             <?php echo $KsvmLlenarForm['RrlNomRol'];?></option>
                                             <?php require_once "./Controladores/KsvmRolControlador.php";
											   $KsvmSelRol = new KsvmRolControlador();
											   echo $KsvmSelRol->__KsvmSeleccionarRol();
										     ?>
                                     </select>
									 <span id="KsvmError8" class="ValForm"><i
													class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
													campo</i></span>
									</div>
									<div class="mdl-textfield mdl-js-textfield">
									<select class="ksvmSelectDin" style="width:100%;" name="KsvmCargo" id="KsvmDato9">
                                         <option value="<?php echo $KsvmLlenarForm['CrgId'];?>" selected="">
                                             <?php echo $KsvmLlenarForm['CrgNomCar'];?></option>
                                             <?php require_once "./Controladores/KsvmCargoControlador.php";
											   $KsvmSelCargo = new KsvmCargoControlador();
											   echo $KsvmSelCargo->__KsvmSeleccionarCargo();
										     ?>
                                     </select>
									 <span id="KsvmError9" class="ValForm"><i
													class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
													campo</i></span>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<input class="mdl-textfield__input" type="text" name="KsvmDirc"
											value="<?php echo $KsvmLlenarForm['EpoDirEmp'];?>" 
											pattern="-?[A-Za-z0-9áéíóúÁÉÍÓÚñ- ]*(\.[0-9]+)?" id="KsvmDato10">
										<label class="mdl-textfield__label" for="KsvmDato10">Dirección</label>
										<span class="mdl-textfield__error">Dirección Inválida</span>
										<span id="KsvmError10" class="ValForm"><i
													class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
													campo</i></span>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<input class="mdl-textfield__input" type="tel" name="KsvmTelf"
											value="<?php echo $KsvmLlenarForm['EpoTelfEmp'];?>"
											pattern="[0-9+()- ]{7,10}" id="KsvmDato11">
										<label class="mdl-textfield__label" for="KsvmDato11">Teléfono</label>
										<span class="mdl-textfield__error">Número de teléfono Inválido</span>
										<span id="KsvmError11" class="ValForm"><i
													class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
													campo</i></span>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<input class="mdl-textfield__input" type="email" name="KsvmEmail"
											value="<?php echo $KsvmLlenarForm['EpoEmailEmp'];?>" 
											placeholder="^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$" id="KsvmDato12">
										<label class="mdl-textfield__label" for="KsvmDato12">E-mail</label>
										<span class="mdl-textfield__error">E-mail Inválido</span>
										<span id="KsvmError12" class="ValForm"><i
													class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
													campo</i></span>
									</div>
									<div class="mdl-textfield mdl-js-textfield">
										<select class="ksvmSelectDin" style="width:100%;" name="KsvmEstCiv" id="KsvmDato13">
											<option value="<?php echo $KsvmLlenarForm['EpoEstCivEmp'];?>"
												selected=""><?php echo $KsvmCivil;?></option>
											<option value="S">Soltero/a</option>
											<option value="U">Union Libre</option>
											<option value="C">Casado/a</option>
											<option value="D">Divorciado/a</option>
											<option value="V">Viudo/a</option>
										</select>
										<span id="KsvmError13" class="ValForm"><i
													class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
													campo</i></span>
									</div>
									<div class="mdl-textfield mdl-js-textfield">
										<select class="ksvmSelectDin" style="width:100%;" name="KsvmSexo" id="KsvmDato14">
											<option value="<?php echo $KsvmLlenarForm['EpoSexoEmp'];?>"
												selected="">
												<?php echo $KsvmSexo;?></option>
											<option value="H">Hombre</option>
											<option value="M">Mujer</option>
										</select>
										<span id="KsvmError14" class="ValForm"><i
													class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
													campo</i></span>
									</div>
									<div class="mdl-textfield mdl-js-textfield">
										<select class="ksvmSelectDin" style="width:100%;" name="KsvmGenero" id="KsvmDato15">
											<option value="<?php echo $KsvmLlenarForm['EpoGeneroEmp'];?>"
												selected="">
												<?php echo $KsvmGenero;?></option>
											<option value="M">Masculino</option>
											<option value="F">Femenino</option>
										</select>
										<span id="KsvmError15" class="ValForm"><i
													class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este
													campo</i></span>
									</div>
								</div>
							</div>
							<p class="text-center">
								<button type="submit"
									class="mdl-button mdl-js-button mdl-js-ripple-effect btn-primary mdl-shadow--4dp"
									id="btnSave">
									<i class="zmdi zmdi-save">&nbsp;Guardar</i>
								</button>
							</p>
							<div class="mdl-tooltip" for="btnSave">Editar empleado</div>
							<div class="RespuestaAjax"></div>
						</form>
					</div>
				</div>
			</div>
		</div>
        </div>
		<?php } }?>

 </section>