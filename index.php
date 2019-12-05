<!--
* Copyright 2019 Klever Santiago Vaca Muela
-->

<?php
require_once "./Raiz/KsvmConfiguracion.php";
require_once "./Controladores/KsvmVistaControlador.php";

$KsvmPlantilla = new KsvmVistaControlador();
$KsvmPlantilla->__KsvmCargarPlantillaControlador();
