<?php

/** Copyright 2019 Klever Santiago Vaca Muela*/

/**
 *Condicion para peticion Ajax
 */
 if ($KsvmPeticionAjax === "R") {
   require_once "../../Raiz/KsvmEstMaestra.php";
 }elseif ($KsvmPeticionAjax){
   require_once "../Raiz/KsvmEstMaestra.php";
 } else {
     require_once "./Raiz/KsvmEstMaestra.php";
 }

class KsvmLoginModelo extends KsvmEstMaestra
{
  /**
   *Función que permite iniciar sesión
   */
  protected function __KsvmIniciarSesionModelo($KsvmData)
  {
      $KsvmLogin = "SELECT * FROM ksvmvistausuario WHERE UsrNomUsu = :KsvmUsuario AND UsrContraUsu = :KsvmContrasena AND UsrEstUsu = 'A' ";
      $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmLogin);

      $KsvmQuery->bindParam(':KsvmUsuario', $KsvmData['KsvmUsuario']);
      $KsvmQuery->bindParam(':KsvmContrasena', $KsvmData['KsvmContrasena']);
      $KsvmQuery->execute();
      return $KsvmQuery;
  }
  /**
   *Función que permite cerrar sesión
   */
  protected function __KsvmCerrarSesionModelo($KsvmData)
  {
      $KsvmUssNom = $KsvmData['KsvmUsuario'];
      $KsvmCod = $KsvmData['KsvmCodigo'];
      $KsvmHora = $KsvmData['KsvmHora'];
      $KsvmTokenS = $KsvmData['KsvmTokenS'];
      $KsvmToken = $KsvmData['KsvmToken'];

      if ($KsvmUssNom != "" && $KsvmTokenS == $KsvmToken) {
         $KsvmRegSalida = KsvmEstMaestra :: __KsvmActualizaBitacora($KsvmCod, $KsvmHora);
         if ($KsvmRegSalida->rowCount() >= 1) {
            session_unset();
            session_destroy();
            $KsvmSalida = "true";
         } else {
            $KsvmSalida = "false";
         }

      } else {
         $KsvmSalida = "false";
      }
      return $KsvmSalida;
  }
}
