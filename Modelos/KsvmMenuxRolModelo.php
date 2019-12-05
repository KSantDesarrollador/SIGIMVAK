<?php

  /**
   *Condicion para peticion Ajax
   */
   if ($KsvmPeticionAjax) {
       require_once "../Raiz/KsvmEstMaestra.php";
   } else {
       require_once "./Raiz/KsvmEstMaestra.php";
   }

   class KsvmMenuxRolModelo extends KsvmEstMaestra
   {
     /**
      *Función que permite ingresar un privilegio
      */
     protected function __KsvmAgregarMenuxRolModelo($KsvmDataMenuxRol)
     {
         $KsvmIngMenuxRol = "INSERT INTO ksvmmenuxrol18(RrlId, MnuId)
                                    VALUES(:KsvmRrlId, :KsvmMnuId)";
         $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmIngMenuxRol);
         $KsvmQuery->bindParam(":KsvmRrlId", $KsvmDataMenuxRol['KsvmRrlId']);
         $KsvmQuery->bindParam(":KsvmMnuId", $KsvmDataMenuxRol['KsvmMnuId']);
         $KsvmQuery->execute();
         return $KsvmQuery;
     }
     /**
      *Función que permite inhabilitar un privilegio
      */
      protected function __KsvmEliminarMenuxRolModelo($KsvmCodMenuxRol)
      {
         $KsvmDelMenuxRol = "DELETE FROM ksvmmenuxrol18 WHERE MxRId = :KsvmCodMenuxRol";
         $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmDelMenuxRol);
         $KsvmQuery->bindParam(":KsvmCodMenuxRol", $KsvmCodMenuxRol);
         $KsvmQuery->execute();
         return $KsvmQuery;
      }
      /**
      *Función que permite editar un privilegio
      */
      protected function __KsvmEditarMenuxRolModelo($KsvmCodMenuxRol)
      {
          $KsvmEditMenuxRol = "SELECT * FROM ksvmvistaasignaprivilegio WHERE MxRId = :KsvmCodMenuxRol";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmEditMenuxRol);
          $KsvmQuery->bindParam(":KsvmCodMenuxRol", $KsvmCodMenuxRol);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
       /**
      *Función que permite contar un privilegio
      */
      protected function __KsvmContarMenuxRolModelo($KsvmCodMenuxRol)
      {
          $KsvmContarMenuxRol = "SELECT MxRId FROM ksvmvistaasignaprivilegio WHERE RrlId != 1";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmContarMenuxRol);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
       /**
      *Función que permite actualizar un privilegio
      */
      protected function __KsvmActualizarMenuxRolModelo($KsvmDataMenuxRol)
      {
        $KsvmActMenuxRol = "UPDATE ksvmmenuxrol18 SET RrlId = :KsvmRrlId, MnuId = :KsvmMnuId
                            WHERE MxRId = :KsvmCodMenuxRol";
        $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmActMenuxRol);
        $KsvmQuery->bindParam(":KsvmRrlId", $KsvmDataMenuxRol['KsvmRrlId']);
         $KsvmQuery->bindParam(":KsvmMnuId", $KsvmDataMenuxRol['KsvmMnuId']);
         $KsvmQuery->bindParam(":KsvmCodMenuxRol", $KsvmDataMenuxRol['KsvmCodMenuxRol']);
         $KsvmQuery->execute();
         return $KsvmQuery;
      }

   }
