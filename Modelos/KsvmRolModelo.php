<?php

  /**
   *Condicion para peticion Ajax
   */
   if ($KsvmPeticionAjax) {
       require_once "../Raiz/KsvmEstMaestra.php";
   } else {
       require_once "./Raiz/KsvmEstMaestra.php";
   }

   class KsvmRolModelo extends KsvmEstMaestra
   {
     /**
      *Función que permite ingresar un rol
      */
     protected function __KsvmAgregarRolModelo($KsvmDataRol)
     {
         $KsvmIngRol = "INSERT INTO ksvmrol02(RrlNomRol)
                                    VALUES(:KsvmNomRol)";
         $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmIngRol);
         $KsvmQuery->bindParam(":KsvmNomRol", $KsvmDataRol['KsvmNomRol']);
         $KsvmQuery->execute();
         return $KsvmQuery;
     }
     /**
      *Función que permite inhabilitar un rol
      */
      protected function __KsvmEliminarRolModelo($KsvmCodRol)
      {
         $KsvmDelRol = "UPDATE ksvmrol02 SET RrlEstRol = 'X' WHERE RrlId = :KsvmCodRol";
         $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmDelRol);
         $KsvmQuery->bindParam(":KsvmCodRol", $KsvmCodRol);
         $KsvmQuery->execute();
         return $KsvmQuery;
      }
      /**
      *Función que permite editar un rol
      */
      protected function __KsvmEditarRolModelo($KsvmCodRol)
      {
          $KsvmEditRol = "SELECT * FROM ksvmrol02 WHERE RrlId = :KsvmCodRol";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmEditRol);
          $KsvmQuery->bindParam(":KsvmCodRol", $KsvmCodRol);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
       /**
      *Función que permite contar un rol
      */
      protected function __KsvmContarRolModelo($KsvmCodRol)
      {
          $KsvmContarRol = "SELECT RrlId FROM ksvmrol02 WHERE RrlId != 1 AND RrlEstRol = 'A'";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmContarRol);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
       /**
      *Función que permite actualizar un rol
      */
      protected function __KsvmActualizarRolModelo($KsvmDataRol)
      {
        $KsvmActRol = "UPDATE ksvmrol02 SET RrlNomRol = :KsvmNomRol
                            WHERE RrlId = :KsvmCodRol";
        $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmActRol);
        $KsvmQuery->bindParam(":KsvmNomRol", $KsvmDataRol['KsvmNomRol']);
         $KsvmQuery->bindParam(":KsvmCodRol", $KsvmDataRol['KsvmCodRol']);
         $KsvmQuery->execute();
         return $KsvmQuery;
      }

   }
