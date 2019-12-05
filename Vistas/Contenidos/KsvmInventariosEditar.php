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
                EDITAR-INVENTARIOS
            </p>
        </div>
    </section>
    <div class="full-width divider-menu-h"></div>
 <!-- Método para cargar datos en el formulario -->
 <?php 

        require_once "./Controladores/KsvmInventarioControlador.php";
        $KsvmIniExt = new KsvmInventarioControlador();
			  
		  $KsvmPagina = explode("/", $_GET['Vistas']);
		  if ($KsvmPagina[1] != "") {
		  $KsvmDataEdit = $KsvmIniExt->__KsvmEditarInventarioControlador($KsvmPagina[1]);

		  if ($KsvmDataEdit->rowCount() == 1) {
              $KsvmLlenarForm = $KsvmDataEdit->fetch();

              $KsvmEstado = "";
				if ($KsvmLlenarForm['IvtEstInv'] == 'N') {
				    $KsvmEstado = "Nuevo";
				} elseif ($KsvmLlenarForm['IvtEstInv'] == 'P') {
					$KsvmEstado = "En Proceso";
				} else {
				    $KsvmEstado = "Terminado";
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
                echo '<a href="'.KsvmServUrl.'KsvmInventariosCrud/1/" id="btn-input"
                class="btn btn-sm btn-dark mdl-shadow--8dp btn-salir">VOLVER &nbsp;<i
                class="zmdi zmdi-arrow-left"></i>
                </a>';
               } else {
                echo '<a href="'.KsvmServUrl.'KsvmInventarios/1/" id="btn-input"
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
                 <form data-form="modificar" action="<?php echo KsvmServUrl; ?>Ajax/KsvmInventarioAjax.php"
							method="POST" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data"
							id="KsvmFormOcp">
							<input type="hidden" name="KsvmCodEdit" value="<?php echo $KsvmPagina[1]; ?>">
							<div class="mdl-grid">
								<div
									class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
									<div class="mdl-textfield mdl-js-textfield">
									<select class="mdl-textfield__input" name="KsvmBdgId" id="KsvmBdgExt">
                                         <option value="" selected="" >
                                             <?php echo $KsvmLlenarForm['BdgDescBod'];?></option>
											 <?php require_once "./Controladores/KsvmBodegaControlador.php";
                                                    $KsvmSelBod = new KsvmBodegaControlador();
                                                    echo $KsvmSelBod->__KsvmSeleccionarBodega();
                                                    ?>
                                     </select>
                                    </div>
									<div class="mdl-textfield mdl-js-textfield">
									<select class="mdl-textfield__input" name="KsvmExtId" id="KsvmExtId">
                                         <option value="<?php echo $KsvmLlenarForm['ExtId'];?>" selected="">
                                             <?php echo $KsvmLlenarForm['MdcDescMed'].' '.$KsvmLlenarForm['ExtLoteEx'];?></option>
                                     </select>
                                    </div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" id="KsvmStockInv">
										<input class="mdl-textfield__input" type="text" name="KsvmStockInv"
											value="<?php echo $KsvmLlenarForm['IvtStockInv'];?>"
											pattern="-?[0-9]*(\.[0-9]+)?" id="KsvmStockInv">
										<label class="mdl-textfield__label" for="KsvmStockInv">Stock</label>
										<span class="mdl-textfield__error">Stock Inválido</span>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<input class="mdl-textfield__input" type="text" name="KsvmContFisInv"
											value="<?php echo $KsvmLlenarForm['IvtContFisInv'];?>"
											pattern="-?[0-9]*(\.[0-9]+)?" id="KsvmContFisInv">
										<label class="mdl-textfield__label" for="KsvmContFisInv">Conteo Físico</label>
										<span class="mdl-textfield__error">Conteo Inválido</span>
									</div>
                                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<input class="mdl-textfield__input" type="time" name="KsvmDuracionInv"
											value="<?php echo $KsvmLlenarForm['IvtDuracionInv'];?>"
											pattern="-?[0-9]*(\.[0-9]+)?" id="KsvmDuracionInv">
										<label class="mdl-textfield__label" for="KsvmDuracionInv">Duración</label>
										<span class="mdl-textfield__error">Duración Inválido</span>
									</div>
                                    <div class="mdl-textfield mdl-js-textfield">
										<select class="mdl-textfield__input" name="KsvmEstInv">
											<option value="<?php echo $KsvmLlenarForm['IvtEstInv'];?>"s
												selected=""><?php echo $KsvmEstado;?></option>
											<option value="N">Nuevo</option>
											<option value="P">En proceso</option>
											<option value="T">Terminado</option>
										</select>
									</div>
								</div>
							</div>
							<p class="text-center">
								<button type="submit"
									class="mdl-button mdl-js-button mdl-js-ripple-effect btn-primary mdl-shadow--4dp"
									id="btn-NuevoInventario">
									<i class="zmdi zmdi-save">&nbsp;Guardar</i>
								</button>
							</p>
							<div class="mdl-tooltip" for="btn-NuevoInventario">Editar Inventario</div>
							<div class="RespuestaAjax"></div>
						</form>
					</div>
				</div>
			</div>
		</div>
        </div>
		<?php } }?>

 </section>