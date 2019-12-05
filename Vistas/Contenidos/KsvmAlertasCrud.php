<!--
* Copyright 2019 Klever Santiago Vaca Muela
-->

<?php
   if ($_SESSION['KsvmRolNom-SIGIM'] != "Administrador") {
      echo $CerrarSesion->__KsvmMatarSesion();
   }
 ?>

	<!-- pageContent -->
	<section class="full-width pageContent">
		<section class="full-width header-well">
			<div class="full-width header-well-icon">
				<i class="zmdi zmdi-folder-star"></i>
			</div>
			<div class="full-width header-well-text">
				<p class="text-condensedLight">
					CRUD-ALERTAS
				</p>
			</div>
		</section>
		<div class="full-width divider-menu-h"></div>
		<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
		<div class="mdl-tabs__panel is-active" id="KsvmListaAlerta">
			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
                         <!-- Formulario de busqueda -->
						<form data-form="" action="" method="POST" autocomplete="off" enctype="multipart/form-data">
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable">
								<label class="mdl-button mdl-js-button mdl-button--icon" for="KsvmBuscarAle">
									<i class="zmdi zmdi-search"></i>
								</label>
								<div class="mdl-textfield__expandable-holder">
									<input class="mdl-textfield__input" type="text" id="KsvmBuscarAle"
										name="KsvmBuscarAle">
									<label class="mdl-textfield__label"></label>
								</div>
								<div class="mdl-textfield--expandable navBar-options-list">
									<a class="btn btn-sm btn-success mdl-shadow--8dp mdl-tabs__tab">PDF</a>
									<a href="#KsvmNuevoAlerta" id="btn-input" 
										class="btn btn-sm btn-warning mdl-shadow--8dp mdl-tabs__tab">NUEVO &nbsp;<i
											class="zmdi zmdi-plus-circle"></i></a>
								</div>
							</div>
							<div class="RespuestaAjax"></div>
						</form>

                    <!-- Método para mostrar la lista de Alertas -->
					<?php
                    require_once "./Controladores/KsvmAlertaControlador.php";
					$KsvmIniAle = new KsvmAlertaControlador();

					if (isset($_POST['KsvmBuscarAle'])) {

						$_SESSION['KsvmBuscarAle'] = $_POST['KsvmBuscarAle'];
                        $KsvmPagina = explode("/", $_GET['Vistas']);
						echo $KsvmIniAle -> __KsvmPaginador($KsvmPagina[1], KsvmNumPag, $_SESSION['KsvmRolId-SIGIM'], 
						0, $_SESSION['KsvmBuscarAle']);
					}else{

						$KsvmPagina = explode("/", $_GET['Vistas']);
						echo $KsvmIniAle -> __KsvmPaginador($KsvmPagina[1], KsvmNumPag, $_SESSION['KsvmRolId-SIGIM'], 
						0, "");
				       }
				?>

				</div>
			</div>
		</div>
		 
        <!-- Método para cargar datos en el formulario -->
		<?php 
			  
		  $KsvmPagina = explode("/", $_GET['Vistas']);
		  if ($KsvmPagina[2] != "") {
		  $KsvmDataDetail = $KsvmIniAle->__KsvmEditarAlertaControlador($KsvmPagina[2]);

		  if ($KsvmDataDetail->rowCount() == 1) {
			  $KsvmLlenarForm = $KsvmDataDetail->fetch();
			  
	    ?>
		<script>
			window.onload = function () {

				$("#KsvmFormAlerta").trigger("reset");
				$(".modal-title").text("Detalles Alerta");
				$("#KsvmDetallesAlerta").modal({
					show: true
				});
			}
		</script>

        <!-- Formulario de Detalles del Alerta -->
           
		<div class="modal fade" id="KsvmDetallesAlerta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
			aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content ">
					<div class="modal-header ">
						<button class="close close-edit" type="button" data-dismiss="modal"
							aria-hidden="true" id="KsvmBtnExit">&times;</button>
						<h5 class="modal-title text-center"></h5>
					</div>
					<div class="modal-body" id="">
					<form method="POST" action="">
						<input type="hidden" name="KsvmCodEdit" value="<?php echo $KsvmPagina[1]; ?>">
						<div class="mdl-grid">
							<div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
								<div class="mdl-textfield mdl-js-textfield">
									<div class="mdl-textfield__input"><strong>Nombre :</strong>&nbsp; &nbsp;<?php echo $KsvmLlenarForm['AltNomAle'];?></div>
								</div>
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
									<div class="mdl-textfield__input"><strong>Color :</strong>&nbsp; &nbsp;<button class="btn btn-md" style="border-color:#000; background-color:<?php echo $KsvmLlenarForm['AltColorAle'];?>;"></button></div>
								</div>
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
									<div class="mdl-textfield__input"><strong>Descripción :</strong>&nbsp; &nbsp;<?php echo $KsvmLlenarForm['AltDescAle'];?></div>
								</div>
							</div>
						</div>
						<br>
					</form>
				</div>
			</div>
		</div>
		</div>
		<script type="text/javascript"> 
		 $(document).ready(function(){
          $('#KsvmBtnExit').on('click', function () {
			  window.location.href="localhost:90/SIGIMVAK/KsvmAlertasCrud/1/";
		  });

		 }):
		</script>
		<?php } }?>
		  
		<!-- Formulario para ingresar un nuevo Alerta -->

		<div class="mdl-tabs__panel" id="KsvmNuevoAlerta" >
			<div class="mdl-grid">
				<div
					class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--13-col-desktop mdl-cell--0-offset-desktop">
					<div class="" style="float:right;">
						<a href="<?php echo KsvmServUrl;?>KsvmAlertasCrud/1/" id="btn-input"
							class="btn btn-sm btn-dark mdl-shadow--8dp btn-salir">VOLVER &nbsp;<i
							class="zmdi zmdi-arrow-left"></i></a>
					</div>
					<br><br>
					<div class="full-width panel mdl-shadow--8dp">
						<div class="full-width modal-header-input text-center">
							Nueva Alerta
						</div>
						<div class="full-width panel-content">
							<form data-form="guardar" action="<?php echo KsvmServUrl; ?>Ajax/KsvmAlertaAjax.php"
								method="POST" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data"
								id="KsvmFormAlerta">
								<div class="mdl-grid">
									<div
										class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="text" name="KsvmNomAle"
											pattern="-?[A-Za-záéíóúÁÉÍÓÚñ ]*(\.[0-9]+)?" id="KsvmNomAle">
											<label class="mdl-textfield__label" for="KsvmNomAle">Nombre</label>
											<span class="mdl-textfield__error">Nombre Inválido</span>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="color" name="KsvmColorAle"
												id="KsvmColorAle">
											<label class="mdl-textfield__label" for="KsvmColorAle">Color</label>
											<span class="mdl-textfield__error">Color Inválida</span>
										</div>
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input class="mdl-textfield__input" type="text" name="KsvmDescAle"
											pattern="-?[A-Za-záéíóúÁÉÍÓÚñ ]*(\.[0-9]+)?" id="KsvmDescAle">
											<label class="mdl-textfield__label" for="KsvmDescAle">Descripción</label>
											<span class="mdl-textfield__error">Descripción Inválida</span>
										</div>
									</div>
								</div>
								<br>
								<p class="text-center">
									<button type="submit"
										class="mdl-button mdl-js-button mdl-js-ripple-effect btn-warning mdl-shadow--4dp"
										id="btn-NuevaAlerta">
										<i class="zmdi zmdi-save">&nbsp;Guardar</i>
									</button>
								</p>
								<div class="mdl-tooltip" for="btn-NuevaAlerta">Agregar Alerta</div>
								<div class="RespuestaAjax"></div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	</section>
