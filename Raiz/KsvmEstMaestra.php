<?php

  /**
   *Condicion para peticion Ajax
   */
   if ($KsvmPeticionAjax) {
       require_once "../Raiz/KsvmConfiguracionDb.php";
   } else {
       require_once "./Raiz/KsvmConfiguracionDb.php";
   }

  class KsvmEstMaestra
  {
    /**
     *Funcion que retorna la cadena de conexion
    */
    protected function __KsvmConexion()
    {
       $KsvmPuente = new PDO(KsvmSGBD, KsvmUSER, KsvmPASS);

       return $KsvmPuente;
    }
    /**
     *Funcion que permite realizar consultas simples
    */
    protected function __KsvmEjecutaConsulta($KsvmConsulta)
    {
        $KsvmRespuesta = self :: __KsvmConexion()->prepare($KsvmConsulta);
        $KsvmRespuesta->execute();
        return $KsvmRespuesta;
    }
    /**
     *Funcion que permite encriptar loe datos ingresados
    */
    public function __KsvmEncriptacion($Cadena)
    {
        $KsvmSalida = false;
        $KsvmLlave = hash('sha256', SECRET_KEY);
        $KsvmIV = substr(hash('sha256', SECRET_IV), 0, 16);
        $KsvmSalida = openssl_encrypt($Cadena, METHOD, $KsvmLlave, 0, $KsvmIV);
        $KsvmSalida = base64_encode($KsvmSalida);
        return $KsvmSalida;
    }
    /**
     *Funcion que permite desencriptar loe datos
    */
    protected function __KsvmDesencriptacion($Cadena)
    {
         $KsvmLlave = hash('sha256', SECRET_KEY);
         $KsvmIV = substr(hash('sha256', SECRET_IV), 0, 16);
         $KsvmSalida = openssl_decrypt(base64_decode($Cadena), METHOD, $KsvmLlave, 0, $KsvmIV);
         return $KsvmSalida;
    }
    /**
     *Funcion que permite construir codigos al azar
    */
    protected function __KsvmGeneraCodigoAleatorio($KsvmLetra, $KsvmLongitud, $KsvmNumero)
    {
         for ($i=1; $i <= $KsvmLongitud ; $i++) {
             $KsvmNum = rand(0,9);
             $KsvmLetra.= $KsvmNum;
         }
         return $KsvmLetra ."-". $KsvmNumero;
    }
    /**
     *Funcion que permite filtrar la informacion ingresada y evitar la inyeccion SQL
    */
    protected function __KsvmFiltrarCadena($KsvmTexto)
    {
        $KsvmTexto = trim($KsvmTexto);
        $KsvmTexto = stripslashes($KsvmTexto);
        $KsvmTexto = str_ireplace("<script>", "", $KsvmTexto);
        $KsvmTexto = str_ireplace("</script>", "", $KsvmTexto);
        $KsvmTexto = str_ireplace("<script src", "", $KsvmTexto);
        $KsvmTexto = str_ireplace("<script type=", "", $KsvmTexto);
        $KsvmTexto = str_ireplace("--", "", $KsvmTexto);
        $KsvmTexto = str_ireplace("^", "", $KsvmTexto);
        $KsvmTexto = str_ireplace("[", "", $KsvmTexto);
        $KsvmTexto = str_ireplace("]", "", $KsvmTexto);
        $KsvmTexto = str_ireplace("==", "", $KsvmTexto);
        $KsvmTexto = str_ireplace("{", "", $KsvmTexto);
        $KsvmTexto = str_ireplace("}", "", $KsvmTexto);
        $KsvmTexto = str_ireplace(";", "", $KsvmTexto);
        $KsvmTexto = str_ireplace("SELECT * FROM", "", $KsvmTexto);
        $KsvmTexto = str_ireplace("DELETE FROM", "", $KsvmTexto);
        $KsvmTexto = str_ireplace("INSERT INTO", "", $KsvmTexto);
        $KsvmTexto = str_ireplace("UPDATE", "", $KsvmTexto);
        return $KsvmTexto;
    }
    /**
     *Funcion que permite registrar una sesión en bitácora
    */
    protected function __KsvmRegistrarBitacora($KsvmSesion)
    {
      $KsvmRegBit = "INSERT INTO ksvmbitacora20(UsrId, BtcCodBit, BtcFchBit, BtcHoraInBit, BtcHoraFinBit, BtcTipoBit, BtcAnioBit)
                                          VALUES(:KsvmUsr, :KsvmCod, :KsvmFecha, :KsvmHoraIni, :KsvmHoraFin, :KsvmTipo, :KsvmAnio)";
      $KsvmQuery = self :: __KsvmConexion()->prepare($KsvmRegBit);
      $KsvmQuery->bindParam(":KsvmUsr", $KsvmSesion['KsvmUsr']);
      $KsvmQuery->bindParam(":KsvmCod", $KsvmSesion['KsvmCod']);
      $KsvmQuery->bindParam(":KsvmFecha", $KsvmSesion['KsvmFecha']);
      $KsvmQuery->bindParam(":KsvmHoraIni", $KsvmSesion['KsvmHoraIni']);
      $KsvmQuery->bindParam(":KsvmHoraFin", $KsvmSesion['KsvmHoraFin']);
      $KsvmQuery->bindParam(":KsvmTipo", $KsvmSesion['KsvmTipo']);
      $KsvmQuery->bindParam(":KsvmAnio", $KsvmSesion['KsvmAnio']);
      $KsvmQuery->execute();
      return $KsvmQuery;
    }
    /**
     *Funcion que permite actualizar una sesión en bitácora
    */
    protected function __KsvmActualizaBitacora($KsvmCod, $KsvmHora)
    {
      $KsvmActBit = "UPDATE ksvmbitacora20 SET BtcHoraFinBit = :KsvmHoraFin WHERE BtcCodBit = :KsvmCod";
      $KsvmQuery = self :: __KsvmConexion()->prepare($KsvmActBit);
      $KsvmQuery->bindParam(":KsvmHoraFin", $KsvmHora);
      $KsvmQuery->bindParam(":KsvmCod", $KsvmCod);
      $KsvmQuery->execute();
      return $KsvmQuery;
    }
    /**
     *Funcion que permite eliminar una sesión en bitácora
    */
    protected function __KsvmEliminaBitacora($KsvmCod)
    {
      $KsvmEliBit = "DELETE FROM ksvmbitacora20 WHERE KsvmUsr = :KsvmCod";
      $KsvmQuery = self :: __KsvmConexion()->prepare($KsvmEliBit);
      $KsvmQuery->bindParam(":KsvmCod", $KsvmSesion['KsvmCod']);
      $KsvmQuery->execute();
      return $KsvmQuery;
    }
    /**
     *Funcion que permite ingresar un nuevo usuario
    */
    protected function __KsvmAgregarUsuario($KsvmDataUsuario)
    {
        $KsvmIngUsu = "INSERT INTO ksvmusuario01(RrlId, UsrNomUsu, UsrContraUsu, UsrEmailUsu, UsrTelfUsu, UsrImgUsu)
                                            VALUES(:KsvmRrlId, :KsvmNomUsu, :KsvmContraUsu, :KsvmEmailUsu, :KsvmTelfUsu, :KsvmImgUsu)";
        $KsvmQuery = self :: __KsvmConexion()->prepare($KsvmIngUsu);
        $KsvmQuery->bindParam(":KsvmRrlId", $KsvmDataUsuario['KsvmRrlId']);
        $KsvmQuery->bindParam(":KsvmNomUsu", $KsvmDataUsuario['KsvmNomUsu']);
        $KsvmQuery->bindParam(":KsvmContraUsu", $KsvmDataUsuario['KsvmContraUsu']);
        $KsvmQuery->bindParam(":KsvmEmailUsu", $KsvmDataUsuario['KsvmEmailUsu']);
        $KsvmQuery->bindParam(":KsvmTelfUsu", $KsvmDataUsuario['KsvmUsrTelfUsu']);
        $KsvmQuery->bindParam(":UsrImgUsu", $KsvmDataUsuario['KsvmImgUsu']);
        $KsvmQuery->execute();
        return $KsvmQuery;
    }
    /**
      *Función que permite editar un usuario
      */
      protected function __KsvmEditarUsuario($KsvmCodUsuario)
      {
          $KsvmEditUsuario = "SELECT * FROM ksvmvistausuario WHERE UsrId = :KsvmCodUsuario";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmEditUsuario);
          $KsvmQuery->bindParam(":KsvmCodUsuario", $KsvmCodUsuario);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
       /**
      *Función que permite contar un usuario
      */
      protected function __KsvmContarUsuario($KsvmCodUsuario)
      {
          $KsvmContarUsuario = "SELECT UsrId FROM ksvmvistausuario WHERE UsrId != 1 AND UsrEstUsu = 'A'";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmContarUsuario);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
    /**
     *Funcion que permite actualizar un nuevo usuario
    */
    protected function __KsvmActualizarUsuario($KsvmDataUsuario)
    {
        $KsvmActUsu = "UPDATE ksvmusuario01 SET RrlId = :KsvmRrlId, UsrNomUsu = :KsvmNomUsu, UsrEmailUsu = :KsvmEmailUsu,
                       UsrTelfUsu = :KsvmTelfUsu, UsrImgUsu = :KsvmImgUsu WHERE UsrId = :KsvmCode";

        $KsvmQuery = self :: __KsvmConexion()->prepare($KsvmActUsu);
        $KsvmQuery->bindParam(":KsvmRrlId", $KsvmDataUsuario['KsvmRrlId']);
        $KsvmQuery->bindParam(":KsvmNomUsu", $KsvmDataUsuario['KsvmNomUsu']);
        $KsvmQuery->bindParam(":KsvmEmailUsu", $KsvmDataUsuario['KsvmEmailUsu']);
        $KsvmQuery->bindParam(":KsvmTelfUsu", $KsvmDataUsuario['KsvmTelfUsu']);
        $KsvmQuery->bindParam(":KsvmImgUsu", $KsvmDataUsuario['KsvmImgUsu']);
        $KsvmQuery->bindParam(":KsvmCode", $KsvmDataUsuario['KsvmCode']);
        $KsvmQuery->execute();
        return $KsvmQuery;
    }
   /**
    *Funcion que permite eliminar un nuevo usuario
   */
   protected function __KsvmEliminarUsuario($KsvmUsuario)
   {
       $KsvmEliUsu = "UPDATE KsvmUsuario01 SET UsrEstUsu = 'X' WHERE UsrId = :KsvmUsrId";
       $KsvmQuery = __KsvmConexion()->prepare($KsvmEliUsu);
       $KsvmQuery->bindParam(":KsvmUsrId", $KsvmUsuario['KsvmUsrId']);
       $KsvmQuery->execute();
        return $KsvmQuery;
   }

    /**
     *Funcion que permite mostrar diferentes alertas del sistema
    */
    public function __KsvmMostrarAlertas($KsvmInfo)
    {
        if ($KsvmInfo['Alerta'] == "simple") {
           $KsvmMensaje = "
                                               <script>
                                                   swal(
                                                    ' ".$KsvmInfo['Titulo']." ',
                                                    ' ".$KsvmInfo['Cuerpo']." ',
                                                    ' ".$KsvmInfo['Tipo']." ',
                                                  );
                                               </script>";
        } elseif ($KsvmInfo['Alerta'] == "Actualiza") {
            $KsvmMensaje = "
                                               <script>
                                                     swal({
                                                       title: ' ".$KsvmInfo['Titulo']." ',
                                                       text: ' ".$KsvmInfo['Cuerpo']." ',
                                                       type: ' ".$KsvmInfo['Tipo']." ',
                                                       confirmButtonText: 'Aceptar'
                                                     },function(){
                                                        location.reload();
                                                     });
                                               </script>";
        } elseif ($KsvmInfo['Alerta'] == "Limpia") {
            $KsvmMensaje = "
                                               <script>
                                                     swal({
                                                       title: ' ".$KsvmInfo['Titulo']." ',
                                                       text: ' ".$KsvmInfo['Cuerpo']." ',
                                                       type: ' ".$KsvmInfo['Tipo']." ',
                                                       confirmButtonText: 'Aceptar'
                                                     },function(){
                                                        $('.FormularioAjax')[0].reset();
                                                     });
                                               </script>";
       }
        return $KsvmMensaje;
    }

  }
