<?php

  /**
   *Condicion para peticion Ajax
   */
   if ($KsvmPeticionAjax) {
       require_once "../Raiz/KsvmEstMaestra.php";
   } else {
       require_once "./Raiz/KsvmEstMaestra.php";
   }

   class KsvmBodegaModelo extends KsvmEstMaestra
   {
     /**
      *Función que permite ingresar una bodega
      */
     protected function __KsvmAgregarBodegaModelo($KsvmDataBodega)
     {
         $KsvmIngBodega = "INSERT INTO ksvmbodega05(UmdId, BdgCodBod, BdgDescBod, BdgTelfBod, BdgDirBod)
                                    VALUES(:KsvmUmdId, :KsvmCodBod, :KsvmDescBod, :KsvmTelfBod, :KsvmDirBod)";
         $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmIngBodega);
         $KsvmQuery->bindParam(":KsvmUmdId", $KsvmDataBodega['KsvmUmdId']);
         $KsvmQuery->bindParam(":KsvmCodBod", $KsvmDataBodega['KsvmCodBod']);
         $KsvmQuery->bindParam(":KsvmDescBod", $KsvmDataBodega['KsvmDescBod']);
         $KsvmQuery->bindParam(":KsvmTelfBod", $KsvmDataBodega['KsvmTelfBod']);
         $KsvmQuery->bindParam(":KsvmDirBod", $KsvmDataBodega['KsvmDirBod']);
         $KsvmQuery->execute();
         return $KsvmQuery;
     }
     /**
      *Función que permite inhabilitar una bodega
      */
      protected function __KsvmEliminarBodegaModelo($KsvmCodBodega)
      {
         $KsvmDelBodega = "UPDATE ksvmbodega05 SET BdgEstBod = 'X' WHERE BdgId = :KsvmCodBodega";
         $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmDelBodega);
         $KsvmQuery->bindParam(":KsvmCodBodega", $KsvmCodBodega);
         $KsvmQuery->execute();
         return $KsvmQuery;
      }
      /**
      *Función que permite editar una bodega
      */
      protected function __KsvmEditarBodegaModelo($KsvmCodBodega)
      {
          $KsvmEditBodega = "SELECT * FROM ksvmvistabodegas WHERE BdgId = :KsvmCodBodega";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmEditBodega);
          $KsvmQuery->bindParam(":KsvmCodBodega", $KsvmCodBodega);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
       /**
      *Función que permite contar una bodega
      */
      protected function __KsvmContarBodegaModelo($KsvmCodBodega)
      {
          $KsvmContarBodega = "SELECT BdgId FROM ksvmvistabodegas WHERE BdgEstBod = 'A'";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmContarBodega);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
     /**
      *Función que permite imprimir una Bodega
      */
      protected function __KsvmImprimirBodegaModelo()
      {
          $KsvmImprimirBodega = "SELECT * FROM ksvmvistabodegas";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->query($KsvmImprimirBodega);
          return $KsvmQuery;
      }
       /**
      *Función que permite actualizar una bodega
      */
      protected function __KsvmActualizarBodegaModelo($KsvmDataBodega)
      {
        $KsvmActBodega = "UPDATE ksvmbodega05 SET UmdId = :KsvmUmdId, BdgDescBod = :KsvmDescBod,
                            BdgTelfBod = :KsvmTelfBod, BdgDirBod = :KsvmDirBod
                            WHERE BdgId = :KsvmCodBodega";
         $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmActBodega);
         $KsvmQuery->bindParam(":KsvmUmdId", $KsvmDataBodega['KsvmUmdId']);
         $KsvmQuery->bindParam(":KsvmDescBod", $KsvmDataBodega['KsvmDescBod']);
         $KsvmQuery->bindParam(":KsvmTelfBod", $KsvmDataBodega['KsvmTelfBod']);
         $KsvmQuery->bindParam(":KsvmDirBod", $KsvmDataBodega['KsvmDirBod']);
         $KsvmQuery->bindParam(":KsvmCodBodega", $KsvmDataBodega['KsvmCodBodega']);
         $KsvmQuery->execute();
         return $KsvmQuery;
      }

   }
