<?php

  /**
   *Condicion para peticion Ajax
   */
   if ($KsvmPeticionAjax) {
       require_once "../Raiz/KsvmEstMaestra.php";
   } else {
       require_once "./Raiz/KsvmEstMaestra.php";
   }

   class KsvmBodxUsuModelo extends KsvmEstMaestra
   {
     /**
      *Función que permite ingresar una bodega por usuario
      */
     protected function __KsvmAgregarBodxUsuModelo($KsvmDataBodxUsu)
     {
         $KsvmIngBodUsu = "INSERT INTO ksvmbodegaxusuario12(UsrId, BdgId)
                                    VALUES(:KsvmUsrId, :KsvmBdgId)";
         $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmIngBodUsu);
         $KsvmQuery->bindParam(":KsvmUsrId", $KsvmDataBodxUsu['KsvmUsrId']);
         $KsvmQuery->bindParam(":KsvmBdgId", $KsvmDataBodxUsu['KsvmBdgId']);
         $KsvmQuery->execute();
         return $KsvmQuery;
     }
     /**
      *Función que permite eliminar una bodega por usuario
      */
      protected function __KsvmEliminarBodxUsuModelo($KsvmCodBodUsu)
      {
         $KsvmDelBodUsu = "DELETE FROM ksvmbodegaxusuario12 WHERE BxUId = :KsvmCodBodUsu";
         $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmDelBodUsu);
         $KsvmQuery->bindParam(":KsvmCodBodUsu", $KsvmCodBodUsu);
         $KsvmQuery->execute();
         return $KsvmQuery;
      }
      /**
      *Función que permite editar una bodega por usuario
      */
      protected function __KsvmEditarBodxUsuModelo($KsvmCodBodUsu)
      {
          $KsvmEditBodUsu = "SELECT * FROM ksvmvistaasignabodega WHERE BxUId = :KsvmCodBodUsu";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmEditBodUsu);
          $KsvmQuery->bindParam(":KsvmCodBodUsu", $KsvmCodBodUsu);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
       /**
      *Función que permite contar una bodega por usuario
      */
      protected function __KsvmContarBodxUsuModelo($KsvmCodBodUsu)
      {
          $KsvmContarBodUsu = "SELECT BxUId FROM ksvmvistaasignabodega WHERE UsrId != 1";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmContarBodUsu);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
       /**
      *Función que permite actualizar una bodega por usuario
      */
      protected function __KsvmActualizarBodxUsuModelo($KsvmDataBodxUsu)
      {
        $KsvmActEmpleado = "UPDATE ksvmbodegaxusuario12 SET UsrId = :KsvmUsrId, BdgId = :KsvmBdgId
                            WHERE BxUId = :KsvmCodBodUsu";
        $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmActEmpleado);
         $KsvmQuery->bindParam(":KsvmUsrId", $KsvmDataBodxUsu['KsvmUsrId']);
         $KsvmQuery->bindParam(":KsvmBdgId", $KsvmDataBodxUsu['KsvmBdgId']);
         $KsvmQuery->bindParam(":KsvmCodBodUsu", $KsvmDataBodxUsu['KsvmCodBodUsu']);
         $KsvmQuery->execute();
         return $KsvmQuery;
      }

   }
