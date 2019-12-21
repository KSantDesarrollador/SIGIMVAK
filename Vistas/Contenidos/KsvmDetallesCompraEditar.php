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
			EDITAR-COMPRAS
            </p>
        </div>
    </section>
    <div class="full-width divider-menu-h"></div>
 <!-- Método para cargar datos en el formulario -->
 <?php 

        require_once "./Controladores/KsvmCompraControlador.php";
        $KsvmIniOcp = new KsvmCompraControlador();
			  
		  $KsvmPagina = explode("/", $_GET['Vistas']);
		  if ($KsvmPagina[1] != "") {
		  $KsvmDataEdit = $KsvmIniOcp->__KsvmEditarDataCompraControlador($KsvmPagina[1]);

		  if ($KsvmDataEdit->rowCount() == 1) {
              $KsvmLlenarForm = $KsvmDataEdit->fetch();
			  
	    ?>

 <!-- Formulario para editar un Usuario -->
 <div class="mdl-tabs" id="KsvmActualizarUsuario">
     <div class="mdl-grid">
         <div
             class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--13-col-desktop mdl-cell--0-offset-desktop">
             <div class="navBar-options-button">
             <?php 
               if ($KsvmPagina[2] == 0) {
                echo '<a href="'.KsvmServUrl.'KsvmComprasCrud/1/" id="btn-input"
                class="btn btn-sm btn-dark mdl-shadow--8dp btn-salir">VOLVER &nbsp;<i
                class="zmdi zmdi-arrow-left"></i>
                </a>';
			} elseif($KsvmPagina[2] == 1) {
                echo '<a href="'.KsvmServUrl.'KsvmCompras/1/" id="btn-input"
                class="btn btn-sm btn-dark mdl-shadow--8dp btn-salir">VOLVER &nbsp;<i
                class="zmdi zmdi-arrow-left"></i>
                </a>';
               }else {
                echo '<a href="'.KsvmServUrl.'KsvmSuperCompras/1/" id="btn-input"
                class="btn btn-sm btn-dark mdl-shadow--8dp btn-salir">VOLVER &nbsp;<i
                class="zmdi zmdi-arrow-left"></i>
                </a>';
			   }
               
             ?>
            </div>
            <br>
             <div class="full-width panel mdl-shadow--8dp">
                 <div class="full-width  modal-header-edit text-center ">
                     Editar Detalle de Compra
                 </div>
                 <div class="full-width panel-content">
                 <form data-form="modificar" action="<?php echo KsvmServUrl; ?>Ajax/KsvmCompraAjax.php"
							method="POST" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data"
							id="KsvmFormOcp">
							<input type="hidden" name="KsvmCodEdit" value="<?php echo $KsvmPagina[1]; ?>">
							<div class="mdl-grid">
								<div
									class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
                                    <div class="mdl-textfield mdl-js-textfield">
									<select class="mdl-textfield__input" name="KsvmMdcId" id="KsvmDato1">
                                         <option value="<?php echo $KsvmLlenarForm['MdcId'];?>" selected="">
                                             <?php echo $KsvmLlenarForm['MdcDescMed'].' '.$KsvmLlenarForm['MdcConcenMed'];?></option>
                                             <?php require_once "./Controladores/KsvmMedicamentoControlador.php";
											   $KsvmSelMedic = new KsvmMedicamentoControlador();
											   echo $KsvmSelMedic->__KsvmSeleccionarMedicamento();
										     ?>
									 </select>
									 <span id="KsvmError1" class="ValForm"><i class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este campo</i></span>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<input class="mdl-textfield__input" type="text" name="KsvmValorUntOcp"
											value="<?php echo $KsvmLlenarForm['DocValorUntOcp'];?>"
											pattern="-?[0-9.]*[A-Za-záéíóúÁÉÍÓÚ ]?" id="KsvmDato2">
										<label class="mdl-textfield__label" for="KsvmDato2">Valor Und</label>
										<span class="mdl-textfield__error">Valor Und Inválido</span>
										<span id="KsvmError2" class="ValForm"><i class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este campo</i></span>
									</div>
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<input class="mdl-textfield__input" type="number" name="KsvmCantOcp"
											value="<?php echo $KsvmLlenarForm['DocCantOcp'];?>"
											pattern="-?[0-9]*(\.[0-9]+)?" id="KsvmDato3">
										<label class="mdl-textfield__label" for="KsvmDato3">Cantidad</label>
										<span class="mdl-textfield__error">Cantidad Inválida</span>
										<span id="KsvmError3" class="ValForm"><i class="zmdi zmdi-alert-triangle">&nbsp;Por favor llene este campo</i></span>
									</div>
                                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<input class="mdl-textfield__input" type="text" name="KsvmObservOcp"
											value="<?php echo $KsvmLlenarForm['DocObservOcp'];?>"
											pattern="-?[A-Za-záéíóúÁÉÍÓÚ ]*(\.[0-9]+)?" id="KsvmObservOcp">
										<label class="mdl-textfield__label" for="KsvmObservOcp">Observación</label>
										<span class="mdl-textfield__error">Observación Inválida</span>
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
							<div class="mdl-tooltip" for="btnSave">Editar Compra</div>
							<div class="RespuestaAjax"></div>
						</form>
					</div>
				</div>
			</div>
		</div>
        </div>
		<?php } }?>

 </section>