<?php

  /**
   *Condicion para peticion Ajax
   */
   if ($KsvmPeticionAjax) {
       require_once "../Raiz/KsvmEstMaestra.php";
   } else {
       require_once "./Raiz/KsvmEstMaestra.php";
   }

   class KsvmCargoModelo extends KsvmEstMaestra
   {
     /**
      *Función que permite ingresar un cargo
      */
     protected function __KsvmAgregarCargoModelo($KsvmDataCargo)
     {
         $KsvmIngCargo = "INSERT INTO ksvmcargo08(UmdId, CrgNomCar)
                                    VALUES(:KsvmUmdId, :KsvmNomCar)";
         $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmIngCargo);
         $KsvmQuery->bindParam(":KsvmUmdId", $KsvmDataCargo['KsvmUmdId']);
         $KsvmQuery->bindParam(":KsvmNomCar", $KsvmDataCargo['KsvmNomCar']);
         $KsvmQuery->execute();
         return $KsvmQuery;
     }
     /**
      *Función que permite eliminar un cargo
      */
      protected function __KsvmEliminarCargoModelo($KsvmCodCargo)
      {
         $KsvmDelCargo = "UPDATE ksvmcargo08 SET CrgEstCar = 'X' WHERE CrgId = :KsvmCodCargo";
         $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmDelCargo);
         $KsvmQuery->bindParam(":KsvmCodCargo", $KsvmCodCargo);
         $KsvmQuery->execute();
         return $KsvmQuery;
      }
      /**
      *Función que permite editar un cargo
      */
      protected function __KsvmEditarCargoModelo($KsvmCodCargo)
      {
          $KsvmEditCargo = "SELECT * FROM ksvmvistacargos WHERE CrgId = :KsvmCodCargo";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmEditCargo);
          $KsvmQuery->bindParam(":KsvmCodCargo", $KsvmCodCargo);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
       /**
      *Función que permite contar un cargo
      */
      protected function __KsvmContarCargoModelo($KsvmCodCargo)
      {
          $KsvmContarCargo = "SELECT CrgId FROM ksvmvistacargos WHERE CrgEstCar = 'A'";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmContarCargo);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
       /**
      *Función que permite actualizar un cargo
      */
      protected function __KsvmActualizarCargoModelo($KsvmDataCargo)
      {
        $KsvmActCargo = "UPDATE ksvmcargo08 SET UmdId = :KsvmUmdId, CrgNomCar = :KsvmNomCar
                            WHERE CrgId = :KsvmCodCargo";
        $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmActCargo);
        $KsvmQuery->bindParam(":KsvmUmdId", $KsvmDataCargo['KsvmUmdId']);
         $KsvmQuery->bindParam(":KsvmNomCar", $KsvmDataCargo['KsvmNomCar']);
         $KsvmQuery->bindParam(":KsvmCodCargo", $KsvmDataCargo['KsvmCodCargo']);
         $KsvmQuery->execute();
         return $KsvmQuery;
      }

   }
