<?php

  /**
   *Condicion para peticion Ajax
   */
   if ($KsvmPeticionAjax) {
       require_once "../Raiz/KsvmEstMaestra.php";
   } else {
       require_once "./Raiz/KsvmEstMaestra.php";
   }

   class KsvmAlertaModelo extends KsvmEstMaestra
   {
     /**
      *Función que permite ingresar una alerta
      */
     protected function __KsvmAgregarAlertaModelo($KsvmDataAlerta)
     {
         $KsvmIngAlerta = "INSERT INTO ksvmalerta15(AltNomAle, AltColorAle, AltDescAle)
                                    VALUES(:KsvmNomAle, :KsvmColorAle, :KsvmDescAle)";
         $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmIngAlerta);
         $KsvmQuery->bindParam(":KsvmNomAle", $KsvmDataAlerta['KsvmNomAle']);
         $KsvmQuery->bindParam(":KsvmColorAle", $KsvmDataAlerta['KsvmColorAle']);
         $KsvmQuery->bindParam(":KsvmDescAle", $KsvmDataAlerta['KsvmDescAle']);
         $KsvmQuery->execute();
         return $KsvmQuery;
     }
     /**
      *Función que permite eliminar una alerta
      */
      protected function __KsvmEliminarAlertaModelo($KsvmCodAlerta)
      {
         $KsvmDelAlerta = "DELETE FROM ksvmalerta15 WHERE AltId = :KsvmCodAlerta";
         $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmDelAlerta);
         $KsvmQuery->bindParam(":KsvmCodAlerta", $KsvmCodAlerta);
         $KsvmQuery->execute();
         return $KsvmQuery;
      }
      /**
      *Función que permite editar una alerta
      */
      protected function __KsvmEditarAlertaModelo($KsvmCodAlerta)
      {
          $KsvmEditAlerta = "SELECT * FROM ksvmalerta15 WHERE AltId = :KsvmCodAlerta";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmEditAlerta);
          $KsvmQuery->bindParam(":KsvmCodAlerta", $KsvmCodAlerta);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
       /**
      *Función que permite contar una alerta
      */
      protected function __KsvmContarAlertaModelo($KsvmCodAlerta)
      {
          $KsvmContarAlerta = "SELECT AltId FROM ksvmalerta15";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmContarAlerta);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
     /**
      *Función que permite imprimir una alerta
      */
      protected function __KsvmImprimirAlertaModelo()
      {
          $KsvmImprimirAlerta = "SELECT * FROM ksvmalerta15";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->query($KsvmImprimirAlerta);
          return $KsvmQuery;
      }
       /**
      *Función que permite actualizar una alerta
      */
      protected function __KsvmActualizarAlertaModelo($KsvmDataAlerta)
      {
        $KsvmActAlerta = "UPDATE ksvmalerta15 SET AltNomAle = :KsvmNomAle, AltColorAle = :KsvmColorAle, AltDescAle = :KsvmDescAle
                            WHERE AltId = :KsvmCodAlerta";
         $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmActAlerta);
         $KsvmQuery->bindParam(":KsvmNomAle", $KsvmDataAlerta['KsvmNomAle']);
         $KsvmQuery->bindParam(":KsvmColorAle", $KsvmDataAlerta['KsvmColorAle']);
         $KsvmQuery->bindParam(":KsvmDescAle", $KsvmDataAlerta['KsvmDescAle']);
         $KsvmQuery->bindParam(":KsvmCodAlerta", $KsvmDataAlerta['KsvmCodAlerta']);
         $KsvmQuery->execute();
         return $KsvmQuery;
      }

   }
