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
			EDITAR-TRANSACCIONES
            </p>
        </div>
    </section>
    <div class="full-width divider-menu-h"></div>
 <!-- Método para cargar datos en el formulario -->
 <?php 

        require_once "./Controladores/KsvmTransaccionControlador.php";
        $KsvmIniTran = new KsvmTransaccionControlador();
			  
		  $KsvmPagina = explode("/", $_GET['Vistas']);
		  if ($KsvmPagina[1] != "") {
		  $KsvmDataEdit = $KsvmIniTran->__KsvmEditarTransaccionControlador($KsvmPagina[1]);

		  if ($KsvmDataEdit->rowCount() == 1) {
              $KsvmLlenarForm = $KsvmDataEdit->fetch();
              
              $KsvmEstado = "";
				if ($KsvmLlenarForm['TsnEstTran'] == 'N') {
				    $KsvmEstado = "Nuevo";
				} elseif ($KsvmLlenarForm['TsnEstTran'] == 'P') {
					$KsvmEstado = "En proceso";
				} elseif ($KsvmLlenarForm['TsnEstTran'] == 'A') {
					$KsvmEstado = "Aprobado";
				} else {
				    $KsvmEstado = "Negado";
				}
			  
	    ?>

 <!-- Formulario para editar un Usuario -->
 <div class="mdl-tabs" id="KsvmActualizarTransaccion">
     <div class="mdl-grid">
         <div
             class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--13-col-desktop mdl-cell--0-offset-desktop">
             <div class="navBar-options-button">
             <?php 
               if ($KsvmPagina[2] == 0) {
                echo '<a href="'.KsvmServUrl.'KsvmTransaccionesCrud/1/" id="btn-input"
                class="btn btn-sm btn-dark mdl-shadow--8dp btn-salir">VOLVER &nbsp;<i
                class="zmdi zmdi-arrow-left"></i>
                </a>';
               } elseif ($KsvmPagina[2] == 1) {
				echo '<a href="'.KsvmServUrl.'KsvmIngresos/1/" id="btn-input"
                class="btn btn-sm btn-dark mdl-shadow--8dp btn-salir">VOLVER &nbsp;<i
                class="zmdi zmdi-arrow-left"></i>
                </a>';
			   } else {
                echo '<a href="'.KsvmServUrl.'KsvmEgresos/1/" id="btn-input"
                class="btn btn-sm btn-dark mdl-shadow--8dp btn-salir">VOLVER &nbsp;<i
                class="zmdi zmdi-arrow-left"></i>
                </a>';
               }
               
             ?>
            </div>
            <br>
             <div class="full-width panel mdl-shadow--8dp">
                 <div class="full-width  modal-header-edit text-center ">
                     Editar Transacción
                 </div>
                 <div class="full-width panel-content">
                 <form data-form="modificar" action="<?php echo KsvmServUrl; ?>Ajax/KsvmTransaccionAjax.php"
							method="POST" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data"
							id="KsvmFormOcp">
							<input type="hidden" name="KsvmCodEdit" value="<?php echo $KsvmPagina[1]; ?>">
							<div class="mdl-grid">
								<div
									class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--6-col-desktop">
									<div class="mdl-textfield mdl-js-textfield">
									<select class="mdl-textfield__input" id="KsvmBdgReq" name="KsvmDestinoTran">
                                         <option value="<?php echo $KsvmLlenarForm['TsnDestinoTran'];?>" selected="">
                                            <?php echo $KsvmLlenarForm['TsnDestinoTran'];?></option>
                                             <?php require_once "./Controladores/KsvmBodegaControlador.php";
													$KsvmSelBod = new KsvmBodegaControlador();
													echo $KsvmSelBod->__KsvmSeleccionarBodega();
													?>
                                     </select>
                                    </div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" id="KsvmNomMedTran">
										<input class="mdl-textfield__input" type="number" name="KsvmNomMedTran"
											value="<?php echo $KsvmLlenarForm['TsnNomMedTran'];?>">
										<label class="mdl-textfield__label" for="KsvmNomMedTran">Medicamento</label>
										<span class="mdl-textfield__error">Medicamento Inválido</span>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<input class="mdl-textfield__input" type="number" name="KsvmNumTran"
											value="<?php echo $KsvmLlenarForm['TsnNumTran'];?>"
											pattern="-?[0-9]*(\.[0-9]+)?" id="KsvmNumTran">
										<label class="mdl-textfield__label" for="KsvmNumTran">Num.Transacción</label>
										<span class="mdl-textfield__error">Num.Transacción Inválido</span>
									</div>
                                    <div class="mdl-textfield mdl-js-textfield">
										<input type="date" class="mdl-textfield__input" id="KsvmFchElabTran"
											value="<?php echo $KsvmLlenarForm['TsnFchReaTran'];?>" name="KsvmFchReaTran">
										<label class="mdl-textfield__label" for="KsvmFchElabTran"
											style="text-align:right;">Fecha de
											Elaboración</label>
									</div>
                                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<input class="mdl-textfield__input" type="text" name="KsvmPerReaTran"
											value="<?php echo $KsvmLlenarForm['TsnPerReaTran'];?>"
											pattern="-?[A-Za-záéíóúÁÉÍÓÚ ]*(\.[0-9]+)?" id="KsvmPerElabTran">
										<label class="mdl-textfield__label" for="KsvmPerElabTran">Persona que Elabora</label>
										<span class="mdl-textfield__error">Nombre Inválido</span>
                                    </div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<input class="mdl-textfield__input" type="text" name="KsvmObservTran"
											value="<?php echo $KsvmLlenarForm['TsnObservTran'];?>"
											pattern="-?[A-Za-záéíóúÁÉÍÓÚ ]*(\.[0-9]+)?" id="KsvmObservTran">
										<label class="mdl-textfield__label" for="KsvmObservTran">Observación</label>
										<span class="mdl-textfield__error">Observación Inválida</span>
									</div>
								</div>
								<div
									class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--6-col-desktop">
                                    <div class="mdl-textfield mdl-js-textfield">
									<select class="mdl-textfield__input" name="KsvmRqcId" id="KsvmRqcId">
                                    <option value="<?php echo $KsvmLlenarForm['RqcId'];?>" selected="">
                                      <?php echo $KsvmLlenarForm['RqcNumReq'];?></option>
                                     </select>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<input class="mdl-textfield__input" type="number" name="KsvmCantTran"
											value="<?php echo $KsvmLlenarForm['TsnCantTran'];?>"
											pattern="-?[0-9]*(\.[0-9]+)?" id="KsvmCantTran">
										<label class="mdl-textfield__label" for="KsvmCantTran">Cantidad</label>
										<span class="mdl-textfield__error">Cantidad Inválida</span>
									</div>
                                    <div class="mdl-textfield mdl-js-textfield">
										<select class="mdl-textfield__input" name="KsvmEstTran">
											<option value="<?php echo $KsvmLlenarForm['TsnTipoTran'];?>"
												selected=""><?php echo $KsvmLlenarForm['TsnTipoTran'];;?></option>
											<option value="Ingreso">Ingreso</option>
											<option value="Egreso">Egreso</option>
										</select>
									</div>
                                    <div class="mdl-textfield mdl-js-textfield">
										<input type="date" class="mdl-textfield__input" id="KsvmFchRevTran"
											value="<?php echo $KsvmLlenarForm['TsnFchRevTran'];?>" name="KsvmFchRevTran">
										<label class="mdl-textfield__label" for="KsvmFchRevTran"
											style="text-align:right;">Fecha de
											Revisión</label>
									</div>
                                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<input class="mdl-textfield__input" type="text" name="KsvmPerRevTran"
											value="<?php echo $KsvmLlenarForm['TsnPerRevTran'];?>"
											pattern="-?[A-Za-záéíóúÁÉÍÓÚ ]*(\.[0-9]+)?" id="KsvmPerRevTran">
										<label class="mdl-textfield__label" for="KsvmPerRevTran">Persona que Revisa</label>
										<span class="mdl-textfield__error">Nombre Inválido</span>
                                    </div>
                                    <div class="mdl-textfield mdl-js-textfield">
										<select class="mdl-textfield__input" name="KsvmEstTran">
											<option value="<?php echo $KsvmLlenarForm['TsnEstTran'];?>"
												selected=""><?php echo $KsvmEstado;?></option>
											<option value="N">Nuevo</option>
											<option value="P">En proceso</option>
											<option value="A">Aprobado</option>
											<option value="X">Negado</option>
										</select>
									</div>
								</div>
							</div>
							<p class="text-center">
								<button type="submit"
									class="mdl-button mdl-js-button mdl-js-ripple-effect btn-primary mdl-shadow--4dp"
									id="btn-EditarTransaccion">
									<i class="zmdi zmdi-save">&nbsp;Guardar</i>
								</button>
							</p>
							<div class="mdl-tooltip" for="btn-EditarTransaccion">Editar Transaccion</div>
							<div class="RespuestaAjax"></div>
						</form>
					</div>
				</div>
			</div>
		</div>
        </div>
		<?php } }?>

 </section>