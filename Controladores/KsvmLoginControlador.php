<?php

/** Copyright 2019 Klever Santiago Vaca Muela*/

/**
 *Condicion para peticion Ajax
 */
 if ($KsvmPeticionAjax) {
     require_once "../Modelos/KsvmLoginModelo.php";
 } else {
     require_once "./Modelos/KsvmLoginModelo.php";
 }

class KsvmLoginControlador extends KsvmLoginModelo
{
  /**
   *Función que permite registrar datos de sesión en la bitacora e inicia sesión
   */
  public function __KsvmIniciarSesionControlador()
  {
     $KsvmUss = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmUsuario']);
     $KsvmCon = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmContra']);

    //  $KsvmCon = KsvmEstMaestra :: __KsvmEncriptacion($KsvmCon);

     $KsvmDataLogin = [
       "KsvmUsuario" => $KsvmUss,
       "KsvmContrasena" => $KsvmCon
     ];

     $KsvmDataUsuario = KsvmLoginModelo :: __KsvmIniciarSesionModelo($KsvmDataLogin);

     if ($KsvmDataUsuario -> rowCount() == 1) {

         $KsvmFilaUs = $KsvmDataUsuario->fetch();
         $KsvmFechaActual = date("Y-m-d");
         $KsvmAnioActual = date("Y");
         $KsvmHoraActual = date("h:i:s a");

         $KsvmBitacora = "SELECT  BtcId FROM ksvmbitacora20";
         $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmBitacora);
         $KsvmNum = ($KsvmQuery->rowCount())+1;

         $KsvmCodigo = KsvmEstMaestra :: __KsvmGeneraCodigoAleatorio("CU", 6, $KsvmNum);

         $KsvmRol = $KsvmFilaUs['RrlId'];
         $KsvmRolUsu = "SELECT RrlNomRol FROM ksvmrol02 WHERE RrlId = '$KsvmRol' ";
         $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmRolUsu);
         if ($KsvmQuery->rowCount() == 1) {
           $KsvmFilaRol = $KsvmQuery->fetch();
             $KsvmRolNom = $KsvmFilaRol['RrlNomRol'];
         }

         $KsvmUsu = $KsvmFilaUs['UsrId'];

         $KsvmDataBitacora = [
           "KsvmUsr" => $KsvmUsu,
            "KsvmCod" => $KsvmCodigo,
            "KsvmFecha" => $KsvmFechaActual,
            "KsvmHoraIni" => $KsvmHoraActual,
            "KsvmHoraFin" => "No registrado",
            "KsvmTipo" => $KsvmRolNom,
            "KsvmAnio" => $KsvmAnioActual
         ];

         $KsvmGuardarBitacora = KsvmEstMaestra :: __KsvmRegistrarBitacora($KsvmDataBitacora);
          if ($KsvmGuardarBitacora->rowCount() >= 1) {
                session_start(['name' => 'SIGIM']);
                $_SESSION['KsvmUsuId-SIGIM'] = $KsvmUsu;
                $_SESSION['KsvmUsuNom-SIGIM'] = $KsvmFilaUs['UsrNomUsu'];
                $_SESSION['KsvmRolId-SIGIM'] = $KsvmRol;
                $_SESSION['KsvmImg-SIGIM'] = $KsvmFilaUs['UsrImgUsu'];
                $_SESSION['KsvmRolNom-SIGIM'] = $KsvmRolNom;
                $_SESSION['KsvmCodBit-SIGIM'] = $KsvmCodigo;
                $_SESSION['KsvmToken-SIGIM'] = md5(uniqid(mt_rand(), true));

                if ($KsvmRolNom == "Administrador") {
                   $KsvmUrl = KsvmServUrl . "KsvmEscritorioAdmin/";
                } elseif ($KsvmRolNom == "Tecnico") {
                    $KsvmUrl = KsvmServUrl . "KsvmEscritorioTec/";
                } else{
                    $KsvmUrl = KsvmServUrl . "KsvmEscritorioUsu/";
                }
                return $KsvmUrlDireccion = '<script>window.location = " '.$KsvmUrl.' "</script>';

          } else {
            $KsvmAlerta = [
              "Alerta" => "simple",
              "Titulo" => "Ocurrió un error inesperado",
              "Cuerpo" => "No es posible iniciar sesión,  Por favor intentelo nuevamente",
              "Tipo" => "info"
               ];
               return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
          }


     } else {
         $KsvmAlerta = [
           "Alerta" => "simple",
           "Titulo" => "Ocurrió un error inesperado",
           "Cuerpo" => "Los Datos ingresados no son correctos ó su cuenta esta Inactiva,  Por favor Verifique los datos",
           "Tipo" => "info"
         ];
         return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
     }

  }
  /**
  *Función que permite cerrar la sesión
  */
  public function __KsvmCerrarSesionControlador()
  {
      session_start(['name' => 'SIGIM']);

      $KsvmTok  = KsvmEstMaestra :: __KsvmDesencriptacion($_GET['KsvmTok']);
      $KsvmHora = date("h:i:s a");
      $KsvmData = [
        "KsvmUsuario" => $_SESSION['KsvmUsuNom-SIGIM'],
        "KsvmTokenS" => $_SESSION['KsvmToken-SIGIM'],
        "KsvmToken" => $KsvmTok,
        "KsvmHora" => $KsvmHora,
        "KsvmCodigo" => $_SESSION['KsvmCodBit-SIGIM']
       ];

      return KsvmLoginModelo :: __KsvmCerrarSesionModelo($KsvmData);
  }
   /**
   *Función que permite forzar el cierre de sesión
   */
  public function __KsvmMatarSesion()
  {
      session_destroy();
      return header("Location: ". KsvmServUrl ."Login");
  }
}
