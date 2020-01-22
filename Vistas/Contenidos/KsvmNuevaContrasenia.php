 <!--
* Copyright 2019 Klever Santiago Vaca Muela
-->

 <!-- pageContent -->
 <?php 
    require_once "../../Raiz/KsvmConfiguracion.php";
    require_once '../Compartido/KsvmCabecera.php';

    if (isset($_GET['Cod'])) {
	$KsvmPeticionAjax = "R";

            
?>

 <!--
* Copyright 2019 Klever Santiago Vaca Muela
-->

 <!-- Formulario de login -->
 <div style="background-image: url('<?php echo KsvmServUrl;?>Vistas/assets/img/inicio.jpg'); width:100%;"
 	class="img-responsive">
 	<p class="text-center full-width" style="font-size: 40px;">
 		<span><img src="<?php echo KsvmServUrl;?>Vistas/assets/img/medicamentos.png" alt="" height="65px"
 				width="75px">&nbsp;<?php echo KsvmCompany;?></span>
 	</p>
 	<div class="container-login full-width">
 		<p class="text-center" style="font-size: 70px;">
 			<i class="zmdi zmdi-account"></i>
 		</p>
 		<p class="text-center text-condensedLight">Por favor ingrese su nueva contraseña</p>
 		<form action="" autocomplete="off" method="POST">
 			<div>
 				<input type="hidden" value="<?php echo $_GET['Cod'];?>" name="KsvmEmail">
 			</div>
 			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
 				<input class="mdl-textfield__input" type="password" id="KsvmDato1" name="KsvmNuevaContra"
 					pattern="[A-Za-z0-9!?-]{8,16}">
 				<label class="mdl-textfield__label" for="KsvmDato2">Nueva Contraseña</label>
 				<span class="mdl-textfield__error">Contraseña Inválida</span>
 				<span id="KsvmError1" class="ValForm"><i class="zmdi zmdi-alert-triangle">&nbsp;Este campo es
 						necesario</i></span>
 			</div>
 			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
 				<input class="mdl-textfield__input" type="password" id="KsvmDato2" name="KsvmConContra"
 					pattern="[A-Za-z0-9!?-]{8,16}">
 				<label class="mdl-textfield__label" for="KsvmDato2">Confirmar Contraseña</label>
 				<span class="mdl-textfield__error">Contraseña Inválida</span>
 				<span id="KsvmError2" class="ValForm"><i class="zmdi zmdi-alert-triangle">&nbsp;Este campo es
 						necesario</i></span>
 			</div>
 			<div id="SingIn">
 				<input type="submit" value="Cambiar" class="mdl-button mdl-js-button mdl-js-ripple-effect" id="btnSave"
 					style="color: #000; float:right;">
 			</div>
 		</form>
 	</div>
 	<div style="margin-top: 42%;" class="text-center hide-on-tablet"><strong>SIGIMVAK&copy; 2019-2020.</strong> Todos
 		los derechos reservados.</div>
 	<br>
 </div>
 <!-- Redireccionando datos al controlador -->
 <?php
    }

      if (isset($_POST['KsvmNuevaContra']) && isset($_POST['KsvmConContra'])) {
      	   require_once "../../Controladores/KsvmLoginControlador.php";
                     $KsvmLogin = new KsvmLoginControlador();
					 echo $KsvmLogin-> __KsvmCambioClaveControlador();
      }
 ?>