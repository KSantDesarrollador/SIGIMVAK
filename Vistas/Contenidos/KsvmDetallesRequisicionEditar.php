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
			EDITAR-PEDIDOS
            </p>
        </div>
    </section>
    <div class="full-width divider-menu-h"></div>
 <!-- Método para cargar datos en el formulario -->
 <?php 

        require_once "./Controladores/KsvmRequisicionControlador.php";
        $KsvmIniReq = new KsvmRequisicionControlador();
			  
		  $KsvmPagina = explode("/", $_GET['Vistas']);
		  if ($KsvmPagina[1] != "") {
		  $KsvmDataEdit = $KsvmIniReq->__KsvmEditarDataRequisicionControlador($KsvmPagina[1]);

		  if ($KsvmDataEdit->rowCount() == 1) {
              $KsvmLlenarForm = $KsvmDataEdit->fetch();
              
              $KsvmEstado = "";
				if ($KsvmLlenarForm['RqcEstReq'] == 'N') {
				    $KsvmEstado = "Nuevo";
				} elseif ($KsvmLlenarForm['RqcEstReq'] == 'P') {
					$KsvmEstado = "En proceso";
				} elseif ($KsvmLlenarForm['RqcEstReq'] == 'A') {
					$KsvmEstado = "Aprobado";
				} else {
				    $KsvmEstado = "Negado";
				}
			  
	    ?>

 <!-- Formulario para editar un Usuario -->
 <div class="mdl-tabs" id="KsvmActualizarRequisicion">
     <div class="mdl-grid">
         <div
             class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--13-col-desktop mdl-cell--0-offset-desktop">
             <div class="navBar-options-button">
             <?php 
               if ($KsvmPagina[2] == 0) {
                echo '<a href="'.KsvmServUrl.'KsvmRequisicionesCrud/1/" id="btn-input"
                class="btn btn-sm btn-dark mdl-shadow--8dp btn-salir">VOLVER &nbsp;<i
                class="zmdi zmdi-arrow-left"></i>
                </a>';
               } else {
                echo '<a href="'.KsvmServUrl.'KsvmRequisiciones/1/" id="btn-input"
                class="btn btn-sm btn-dark mdl-shadow--8dp btn-salir">VOLVER &nbsp;<i
                class="zmdi zmdi-arrow-left"></i>
                </a>';
               }
               
             ?>
            </div>
            <br>
             <div class="full-width panel mdl-shadow--8dp">
                 <div class="full-width  modal-header-edit text-center ">
                     Editar Pedido
                 </div>
                 <div class="full-width panel-content">
                 <form data-form="modificar" action="<?php echo KsvmServUrl; ?>Ajax/KsvmRequisicionAjax.php"
							method="POST" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data"
							id="KsvmFormOcp">
							<input type="hidden" name="KsvmCodEdit" value="<?php echo $KsvmPagina[1]; ?>">
							<div class="mdl-grid">
								<div
									class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
									<div class="mdl-textfield mdl-js-textfield">
									<select class="mdl-textfield__input" id="KsvmExtId" name="KsvmExtId">
                                         <option value="<?php echo $KsvmLlenarForm['ExtId'];?>" selected="">
                                            <?php echo $KsvmLlenarForm['MdcDescMed'].' '.$KsvmLlenarForm['MdcConcenMed'];?></option>
                                             <?php require_once "./Controladores/KsvmExistenciaControlador.php";
													$KsvmSelExt = new KsvmExistenciaControlador();
													echo $KsvmSelExt->__KsvmSeleccionExistencia();
													?>
                                     </select>
                                    </div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" id="KsvmStockReq">
										<input class="mdl-textfield__input" type="number" name="KsvmStockReq"
											value="<?php echo $KsvmLlenarForm['DrqStockReq'];?>"
											pattern="-?[0-9]*(\.[0-9]+)?">
										<label class="mdl-textfield__label" for="KsvmStockReq">Stock</label>
										<span class="mdl-textfield__error">Stock Inválido</span>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<input class="mdl-textfield__input" type="number" name="KsvmCantReq"
											value="<?php echo $KsvmLlenarForm['DrqCantReq'];?>"
											pattern="-?[0-9]*(\.[0-9]+)?" id="KsvmCantReq">
										<label class="mdl-textfield__label" for="KsvmCantReq">Cantidad</label>
										<span class="mdl-textfield__error">Cantidad Inválida</span>
									</div>
                                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<input class="mdl-textfield__input" type="text" name="KsvmObservReq"
											value="<?php echo $KsvmLlenarForm['DrqObservReq'];?>"
											pattern="-?[A-Za-záéíóúÁÉÍÓÚ ]*(\.[0-9]+)?" id="KsvmObservReq">
										<label class="mdl-textfield__label" for="KsvmObservReq">Observación</label>
										<span class="mdl-textfield__error">Observación Inválida</span>
									</div>
								</div>
							</div>
							<p class="text-center">
								<button type="submit"
									class="mdl-button mdl-js-button mdl-js-ripple-effect btn-primary mdl-shadow--4dp"
									id="btn-EditarRequisicion">
									<i class="zmdi zmdi-save">&nbsp;Guardar</i>
								</button>
							</p>
							<div class="mdl-tooltip" for="btn-EditarRequisicion">Editar Requisicion</div>
							<div class="RespuestaAjax"></div>
						</form>
					</div>
				</div>
			</div>
		</div>
        </div>
		<?php } }?>

 </section>