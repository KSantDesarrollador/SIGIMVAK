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
			EDITAR-UNIDAD-MÉDICA
            </p>
        </div>
    </section>
    <div class="full-width divider-menu-h"></div>
 <!-- Método para cargar datos en el formulario -->
 <?php 

        require_once "./Controladores/KsvmUnidadMedicaControlador.php";
        $KsvmIniUndMed = new KsvmUnidadMedicaControlador();
			  
		  $KsvmPagina = explode("/", $_GET['Vistas']);
		  if ($KsvmPagina[1] != "") {
		  $KsvmDataEdit = $KsvmIniUndMed->__KsvmEditarUnidadMedicaControlador($KsvmPagina[1]);

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
  

              $KsvmEstado = "";
				if ($KsvmLlenarForm['UmdEstUdm'] == 'A') {
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
                echo '<a href="'.KsvmServUrl.'KsvmUnidadesMedicasCrud/1/" id="btn-input"
                class="btn btn-sm btn-dark mdl-shadow--8dp btn-salir">VOLVER &nbsp;<i
                class="zmdi zmdi-arrow-left"></i>
                </a>';
               } else {
                echo '<a href="'.KsvmServUrl.'KsvmUnidadesMedicas/1/" id="btn-input"
                class="btn btn-sm btn-dark mdl-shadow--8dp btn-salir">VOLVER &nbsp;<i
                class="zmdi zmdi-arrow-left"></i>
                </a>';
               }
               
             ?>
            </div>
            <br>
             <div class="full-width panel mdl-shadow--8dp">
                 <div class="full-width  modal-header-edit text-center ">
                     Editar Unidad Médica
                 </div>
                 <div class="full-width panel-content">
                 <form data-form="modificar" action="<?php echo KsvmServUrl; ?>Ajax/KsvmUnidadMedicaAjax.php"
							method="POST" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data"
							id="KsvmFormOcp">
							<input type="hidden" name="KsvmCodEdit" value="<?php echo $KsvmPagina[1]; ?>">
							<div class="mdl-grid">
									<div
										class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--6-col-desktop">
										<div class="mdl-textfield mdl-js-textfield">
											<select class="mdl-textfield__input" name="KsvmIdPais" id="">
												<option value="<?php echo $KsvmLlenarForm['PrcId']?>" selected=""><?php echo $KsvmPais;?></option>
												<?php 
													$KsvmCbxProc = $KsvmSelProc->__KsvmSeleccionaProcedencia("");
													foreach ($KsvmCbxProc as $rows) {
													?>name
												<option value="<?php echo $rows['PrcId'];?>"><?php echo $rows['PrcNomProc'];?></option>
												<?php }?>
											</select>
										</div>
										<div class="mdl-textfield mdl-js-textfield">
											<select class="mdl-textfield__input" id="KsvmCargaListaCanton">
												<option value="" selected=""><?php echo $KsvmCanton;?></option>
											</select>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="text" name="KsvmNomUdm"
                                                value="<?php echo $KsvmLlenarForm['UmdNomUdm']?>"
												pattern="-?[A-Za-z0-9áéíóúÁÉÍÓÚ ]*(\.[0-9]+)?" id="KsvmNomUdm">
											<label class="mdl-textfield__label" for="KsvmNomUdm">Razón Social</label>
											<span class="mdl-textfield__error">Razón Social Inválida</span>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="text" name="KsvmDirUdm"
                                                value="<?php echo $KsvmLlenarForm['UmdDirUdm']?>" id="KsvmDirUdm">
											<label class="mdl-textfield__label" for="KsvmDirUdm">Dirección</label>
											<span class="mdl-textfield__error">Dirección Inválida</span>
										</div>
									</div>
									<div
										class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--6-col-desktop">
										<div class="mdl-textfield mdl-js-textfield">
											<select class="mdl-textfield__input" id="KsvmCargaListaProvincia">
												<option value="" selected=""><?php echo $KsvmProvincia;?></option>
											</select>
										</div>
										<div class="mdl-textfield mdl-js-textfield">
											<select class="mdl-textfield__input" name="KsvmIdParroquia" id="KsvmCargaListaParroquia">
												<option value="<?php echo $KsvmLlenarForm['PrcId']?>" selected=""><?php echo $KsvmParroquia;?></option>
											</select>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="text" name="KsvmIdentUdm"
                                                value="<?php echo $KsvmLlenarForm['UmdIdentUdm']?>"
											    pattern="-?[0-9+()-]*(\.[0-9]+)?" id="KsvmIdentUdm">
											<label class="mdl-textfield__label" for="KsvmIdentUdm">Identidad</label>
											<span class="mdl-textfield__error">Identidad Inválida</span>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="telf" name="KsvmTelfUdm"
                                                value="<?php echo $KsvmLlenarForm['UmdTelfUdm']?>"
											    pattern="-?[0-9+()-]*(\.[0-9]+)?" id="KsvmTelfUdm">
											<label class="mdl-textfield__label" for="KsvmTelfUdm">Teléfono</label>
											<span class="mdl-textfield__error">Teléfono Inválido</span>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="email" name="KsvmEmailUdm"
                                                value="<?php echo $KsvmLlenarForm['UmdEmailUdm']?>" id="KsvmEmailUdm">
											<label class="mdl-textfield__label" for="KsvmEmailUdm">Email</label>
											<span class="mdl-textfield__error">Email Inválido</span>
										</div>
									</div>	
								</div>
							<p class="text-center">
								<button type="submit"
									class="mdl-button mdl-js-button mdl-js-ripple-effect btn-primary mdl-shadow--4dp"
									id="btn-EditarUnidadMedica">
									<i class="zmdi zmdi-save">&nbsp;Guardar</i>
								</button>
							</p>
							<div class="mdl-tooltip" for="btn-EditarUnidadMedica">Editar UnidadMedica</div>
							<div class="RespuestaAjax"></div>
						</form>
					</div>
				</div>
			</div>
		</div>
        </div>
		<?php } }?>

 </section>