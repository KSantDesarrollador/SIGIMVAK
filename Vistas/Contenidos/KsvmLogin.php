<!--
* Copyright 2019 Klever Santiago Vaca Muela
-->
<?php
	$KsvmPeticionAjax = false;
?>
<!-- Formulario de login -->
<div style="background-image: url('Vistas/assets/img/inicio.jpg'); width:100%;" class="img-responsive">
	<p class="text-center full-width" style="font-size: 40px;">
		<span><img src="Vistas/assets/img/medicamentos.png" alt="" height="65px"
				width="75px">&nbsp;<?php echo KsvmCompany;?></span>
	</p>
	<div class="container-login full-width">
		<p class="text-center" style="font-size: 120px;">
			<i class="zmdi zmdi-account"></i>
		</p>
		<p class="text-center text-condensedLight">Inicie sesión con su cuenta</p>
		<form action="" autocomplete="off" method="POST">
			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				<input class="mdl-textfield__input" type="text" id="KsvmDato1" name="KsvmUsuario"
					pattern="^([A-Z]+[0-9]{0,3}){5,12}$">
				<label class="mdl-textfield__label" for="KsvmDato1">Usuario</label>
				<span class="mdl-textfield__error">Usuario Inválido</span>
				<span id="KsvmError1" class="ValForm"><i class="zmdi zmdi-alert-triangle">&nbsp;Este campo es
						necesario</i></span>
			</div>
			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				<input class="mdl-textfield__input" type="password" id="KsvmDato2" name="KsvmContra"
					pattern="[A-Za-z0-9!?-]{8,16}">
				<label class="mdl-textfield__label" for="KsvmDato2">Contraseña</label>
				<span class="mdl-textfield__error">Contraseña Inválida</span>
				<span id="KsvmError2" class="ValForm"><i class="zmdi zmdi-alert-triangle">&nbsp;Este campo es
						necesario</i></span>
			</div>
			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				<a href="RecuperaContrasenia" class="" name="KsvmOlvidoContra">Olvidó su contraseña?</a>
			</div>
			<div id="SingIn">
				<input type="submit" value="Ingresar" class="mdl-button mdl-js-button mdl-js-ripple-effect" id="btnSave"
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

      if (isset($_POST['KsvmUsuario']) && isset($_POST['KsvmContra'])) {
      	   require_once "./Controladores/KsvmLoginControlador.php";
					 $KsvmLogin = new KsvmLoginControlador();
					 echo $KsvmLogin-> __KsvmIniciarSesionControlador();
      }
 ?>