<?php

/** Copyright 2019 Klever Santiago Vaca Muela*/

/**
 *Condicion para peticion Ajax
 */
  if ($KsvmPeticionAjax === "R") {
    require_once "../../Modelos/KsvmLoginModelo.php";
  } elseif ($KsvmPeticionAjax){
    require_once "../Modelos/KsvmLoginModelo.php";
  }elseif (!$KsvmPeticionAjax) {
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

     $KsvmCon = KsvmEstMaestra :: __KsvmEncriptacion($KsvmCon);

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
          if ($KsvmGuardarBitacora->rowCount() == 1) {

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
                } elseif ($KsvmRolNom == "Supervisor") {
                    $KsvmUrl = KsvmServUrl . "KsvmEscritorioSup/";
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
  *Función que permite recuperar la contrasenia
  */
  public function __KsvmRecuperaContrasenia()
  {
    $KsvmEmail = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmEmail']);

  if ($KsvmEmail != "") {
      $KsvmEmailQ = "UPDATE ksvmusuario01 SET UsrTokkenRecUsu = 1 WHERE UsrEmailUsu ='$KsvmEmail'";
      $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmEmailQ);
      
      $KsvmEmailQ = "SELECT UsrEmailUsu FROM ksvmusuario01 WHERE UsrEmailUsu ='$KsvmEmail'";
      $KsvmQuery = KsvmEstMaestra :: __KsvmEjecutaConsulta($KsvmEmailQ);
      $KsvmEmaEm = $KsvmQuery->rowCount();
  }else{
      $KsvmEmaEm = 0;
  }

    if ($KsvmEmaEm == 1) {

    require_once 'Mail/PHPMailerAutoload.php';
    require_once 'Mail/class.smtp.php';
    require_once 'Mail/class.phpmailer.php';


    $mail = new PHPMailer();

        //Server settings
        $mail->SMTPDebug = 0;                     
        $mail->isSMTP();                                    
        $mail->Host       = 'smtp.gmail.com';                  
        $mail->SMTPAuth   = true;                                 
        $mail->Username   = 'santy.vak69@gmail.com';                     
        $mail->Password   = 'santy1330dark';                            
        $mail->SMTPSecure = 'tls';        
        $mail->Port       = 587;                              
    
        if ($KsvmQuery->rowCount() == 1) {
          $KsvmCorreo = $KsvmQuery->fetch();
        }
        //Recipients
        $mail->setFrom('santy.vak69@gmail.com', KsvmCompany);
        $mail->addAddress($KsvmCorreo['UsrEmailUsu'], $KsvmCorreo['UsrEmailUsu']);      
    
        // Content
        $mail->isHTML(true);                                 
        $mail->Subject = 'Recuperar Clave';
        $mail->Body    = 'Por favor siga el enlace para registrar una nueva clave:'.' '.KsvmServUrl.'Vistas/Contenidos/KsvmNuevaContrasenia.php?Cod='
        .KsvmEstMaestra :: __KsvmEncriptacion($KsvmCorreo['UsrEmailUsu']).'';

    
       if (!$mail->send()) {
        $KsvmAlerta = [
          "Alerta" => "simple",
          "Titulo" => "Error inesperado",
          "Cuerpo" => "El Email no pudo ser enviado, Por favor intentelo de nuevo",
          "Tipo" => "info"
         ];
        echo "El Email no pudo ser enviado: {$mail->ErrorInfo}";
        return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);

       } else {
        $KsvmAlerta = [
          "Alerta" => "simple",
          "Titulo" => "En hora buena",
          "Cuerpo" => "Se ha enviado un correo al email ingresado, Por favor revise su correo",
          "Tipo" => "info"
         ];
       }
      }else{
        $KsvmAlerta = [
          "Alerta" => "simple",
          "Titulo" => "Error inesperado",
          "Cuerpo" => "El Email ingresado no se encuentra registrado, Por favor ingrese un Email válido",
          "Tipo" => "info"
         ];
      }
      return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
  }

    /**
   * Función que permite editar un usuario 
   */
  public function __KsvmCambioClaveControlador()
  {
      $KsvmEmail = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmEmail']);
      $KsvmNuevaContra = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmNuevaContra']);
      $KsvmConContra = KsvmEstMaestra :: __KsvmFiltrarCadena($_POST['KsvmConContra']);

      if ($KsvmNuevaContra != $KsvmConContra) {
        $KsvmAlerta = [
          "Alerta" => "simple",
          "Titulo" => "Error inesperado",
          "Cuerpo" => "Las contraseñas ingresadas no coinciden, Por favor Intentelo de nuevo",
          "Tipo" => "error"
        ];
        return KsvmEstMaestra :: __KsvmMostrarAlertas($KsvmAlerta);
      }else{

      $KsvmCodEmail = KsvmEstMaestra :: __KsvmDesencriptacion($KsvmEmail);
      echo $KsvmCodEmail;
      $KsvmTokken = 1;
      $KsvmCon = KsvmEstMaestra :: __KsvmEncriptacion($KsvmNuevaContra);

      $KsvmData = [
        "KsvmCon" => $KsvmCon,
        "KsvmTokken" => $KsvmTokken,
        "KsvmCodEmail" => $KsvmCodEmail

      ];

      $KsvmConfirmacion = KsvmEstMaestra :: __KsvmCambioClave($KsvmData);

      if ($KsvmConfirmacion->rowCount() >= 1) {
        echo '<script>window.location="'.KsvmServUrl.'Login";</script>';
        } else {
            $KsvmAlerta = [
            "Alerta" => "simple",
            "Titulo" => "Error inesperado",
            "Cuerpo" => "No se ha podido actualizar la contraseña",
            "Tipo" => "info"
            ];
        }
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
