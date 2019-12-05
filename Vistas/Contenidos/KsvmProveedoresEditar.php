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
			EDITAR-PROVEEDORES
            </p>
        </div>
    </section>
    <div class="full-width divider-menu-h"></div>
 <!-- Método para cargar datos en el formulario -->
 <?php 

        require_once "./Controladores/KsvmProveedorControlador.php";
        $KsvmIniProv = new KsvmProveedorControlador();
			  
		  $KsvmPagina = explode("/", $_GET['Vistas']);
		  if ($KsvmPagina[1] != "") {
		  $KsvmDataEdit = $KsvmIniProv->__KsvmEditarProveedorControlador($KsvmPagina[1]);

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


            if ($KsvmLlenarForm['PvdTipProv'] == "N") {
                $KsvmTipo = "Persona Natural";
            } else {
                $KsvmTipo = "Persona Juridica";
            }
            
                

              $KsvmEstado = "";
				if ($KsvmLlenarForm['PvdEstProv'] == 'A') {
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
                echo '<a href="'.KsvmServUrl.'KsvmProveedoresCrud/1/" id="btn-input"
                class="btn btn-sm btn-dark mdl-shadow--8dp btn-salir">VOLVER &nbsp;<i
                class="zmdi zmdi-arrow-left"></i>
                </a>';
               } else {
                echo '<a href="'.KsvmServUrl.'KsvmProveedores/1/" id="btn-input"
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
                 <form data-form="modificar" action="<?php echo KsvmServUrl; ?>Ajax/KsvmProveedorAjax.php"
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
													?>
												<option value="<?php echo $rows['PrcId'];?>"><?php echo $rows['PrcNomProc'];?></option>
												<?php }?>
											</select>
										</div>
										<div class="mdl-textfield mdl-js-textfield">
											<select class="mdl-textfield__input" id="KsvmCargaListaCanton">
												<option value="" selected=""><?php echo $KsvmCanton;?></option>
											</select>
										</div>
										<div class="mdl-textfield mdl-js-textfield">
												<select class="mdl-textfield__input" name="KsvmTipProv">
													<option value="<?php echo $KsvmLlenarForm['PvdTipProv']?>" selected=""><?php echo $KsvmTipo;?>
													</option>
													<option value="N">Persona Natural</option>
													<option value="J">Persona Juridica</option>
												</select>
											</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="text" name="KsvmRazSocProv"
                                                value="<?php echo $KsvmLlenarForm['PvdRazSocProv']?>"
												pattern="-?[A-Za-z0-9áéíóúÁÉÍÓÚ ]*(\.[0-9]+)?" id="KsvmRazSocProv">
											<label class="mdl-textfield__label" for="KsvmRazSocProv">Razón Social</label>
											<span class="mdl-textfield__error">Razón Social Inválida</span>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="text" name="KsvmDirProv"
                                                value="<?php echo $KsvmLlenarForm['PvdDirProv']?>" id="KsvmDirProv">
											<label class="mdl-textfield__label" for="KsvmDirProv">Dirección</label>
											<span class="mdl-textfield__error">Dirección Inválida</span>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="text" name="KsvmPerContProv"
                                              value="<?php echo $KsvmLlenarForm['PvdPerContProv']?>" 
                                              pattern="-?[A-Za-z0-9áéíóúÁÉÍÓÚ ]*(\.[0-9]+)?" id="KsvmPerContProv">
											<label class="mdl-textfield__label" for="KsvmPerContProv">Persona de Contacto</label>
											<span class="mdl-textfield__error">Nombre Inválido</span>
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
											<input class="mdl-textfield__input" type="text" name="KsvmIdentProv"
                                            v   alue="<?php echo $KsvmLlenarForm['PvdIdentProv']?>"
											    pattern="-?[0-9+()-]*(\.[0-9]+)?" id="KsvmIdentProv">
											<label class="mdl-textfield__label" for="KsvmIdentProv">Identidad</label>
											<span class="mdl-textfield__error">Identidad Inválida</span>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="telf" name="KsvmTelfProv"
                                                value="<?php echo $KsvmLlenarForm['PvdTelfProv']?>"
											    pattern="-?[0-9+()-]*(\.[0-9]+)?" id="KsvmTelfProv">
											<label class="mdl-textfield__label" for="KsvmTelfProv">Teléfono</label>
											<span class="mdl-textfield__error">Teléfono Inválido</span>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="email" name="KsvmEmailProv"
                                                value="<?php echo $KsvmLlenarForm['PvdEmailProv']?>" id="KsvmEmailProv">
											<label class="mdl-textfield__label" for="KsvmEmailProv">Email</label>
											<span class="mdl-textfield__error">Email Inválida</span>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="text" name="KsvmCarContProv"
                                                value="<?php echo $KsvmLlenarForm['PvdCarContProv']?>"
												pattern="-?[A-Za-z0-9áéíóúÁÉÍÓÚ ]*(\.[0-9]+)?" id="KsvmCarContProv">
											<label class="mdl-textfield__label" for="KsvmCarContProv">Cargo Persona Contacto</label>
											<span class="mdl-textfield__error">Descripción Inválida</span>
										</div>
									</div>	
								</div>
							<p class="text-center">
								<button type="submit"
									class="mdl-button mdl-js-button mdl-js-ripple-effect btn-primary mdl-shadow--4dp"
									id="btn-EditarProveedor">
									<i class="zmdi zmdi-save">&nbsp;Guardar</i>
								</button>
							</p>
							<div class="mdl-tooltip" for="btn-EditarProveedor">Editar Proveedor</div>
							<div class="RespuestaAjax"></div>
						</form>
					</div>
				</div>
			</div>
		</div>
        </div>
		<?php } }?>

 </section>