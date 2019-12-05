<!--
* Copyright 2019 Klever Santiago Vaca Muela
-->
<html>

<!-- Formulario de login -->
<div style="background-image: url('Vistas/assets/img/inicio.jpg');" class="img-responsive">
	<p class="text-center full-width" style="font-size: 40px;">
		<span><img src="Vistas/assets/img/logo.png" alt="">&nbsp;<?php echo KsvmCompany;?></span>
	</p>
	<div class="container-login full-width">
		<p class="text-center" style="font-size: 120px;">
			<i class="zmdi zmdi-account"></i>
		</p>
		<p class="text-center text-condensedLight">Inicie sesión con su cuenta</p>
		<form action="" autocomplete="off" method="POST">
			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				<input required class="mdl-textfield__input" type="text" id="KsvmUsuario" name="KsvmUsuario">
				<label class="mdl-textfield__label" for="KsvmUsuario">Usuario</label>
			</div>
			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				<input required class="mdl-textfield__input" type="password" id="KsvmContra" name="KsvmContra">
				<label class="mdl-textfield__label" for="KsvmContra">Contraseña</label>
			</div>
			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				<a href="" class="mdl-textfield__input">Olvidó su contraseña?</a>
			</div>
			<div id="SingIn">
				<input type="submit" value="Ingresar" class="mdl-button mdl-js-button mdl-js-ripple-effect" style="color: #000; float:right;">
			</div>
		</form>
	</div>
<div style="margin-top: 42%;" class="text-center hide-on-tablet"><strong>SIGIMVAK&copy; 2019-2020.</strong> Todos los derechos reservados.</div>
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
</html>