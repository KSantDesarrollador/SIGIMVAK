<!--
* Copyright 2019 Klever Santiago Vaca Muela
-->

<!-- Formulario de recuperarción de contrasenia -->
<div style="background-image: url('Vistas/assets/img/inicio.jpg'); width:100%;" class="img-responsive">
	<p class="text-center full-width" style="font-size: 40px;">
		<span><img src="Vistas/assets/img/medicamentos.png" alt="" height="65px"
				width="75px">&nbsp;<?php echo KsvmCompany;?></span>
	</p>
	<div class="container-login full-width">
		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
			<a href="Login" class="" name="KsvmOlvidoContra">Iniciar Sesión</a>
		</div>
		<br>
		<p class="text-center" style="font-size: 75px;">
			<i class="zmdi zmdi-email"></i>
		</p>
		<p class="text-center text-condensedLight">Ingrese su Correo para recuperar su clave</p>
		<form action="" autocomplete="off" method="POST">
			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				<input class="mdl-textfield__input" type="text" id="KsvmDato1" name="KsvmEmail"
					pattern="^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$">
				<label class="mdl-textfield__label" for="KsvmDato1">E-Mail</label>
				<span class="mdl-textfield__error">Email Inválido</span>
				<span id="KsvmError1" class="ValForm"><i class="zmdi zmdi-alert-triangle">&nbsp;Este campo es
						necesario</i></span>
			</div>
			<div id="SingIn">
				<input type="submit" value="Enviar" class="mdl-button mdl-js-button mdl-js-ripple-effect" id="btnSave"
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
      if (isset($_POST['KsvmEmail'])) {
      	   require_once "./Controladores/KsvmLoginControlador.php";
					 $KsvmLogin = new KsvmLoginControlador();
					 echo $KsvmLogin-> __KsvmRecuperaContrasenia();
      }
 ?>