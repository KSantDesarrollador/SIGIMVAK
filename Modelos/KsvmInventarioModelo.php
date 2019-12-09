<?php

  /**
   *Condicion para peticion Ajax
   */
   if ($KsvmPeticionAjax) {
       require_once "../Raiz/KsvmEstMaestra.php";
   } else {
       require_once "./Raiz/KsvmEstMaestra.php";
   }

   class KsvmInventarioModelo extends KsvmEstMaestra
   {
     /**
      *Función que permite ingresar un inventario
      */
     protected function __KsvmAgregarInventarioModelo($KsvmDataInventario)
     {
         $KsvmIngInventario = "INSERT INTO ksvminventario11(BdgId, IvtCodInv, IvtPerElabInv, IvtFchElabInv, IvtHoraInv, IvtDuracionInv)
                                    VALUES(:KsvmBdgId, :KsvmCodInv, :KsvmPerElabInv, :KsvmFchElabInv, :KsvmHoraInv, :KsvmDuracionInv)";
         $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmIngInventario);
         $KsvmQuery->bindParam(":KsvmBdgId", $KsvmDataInventario['KsvmBdgId']);
         $KsvmQuery->bindParam(":KsvmCodInv", $KsvmDataInventario['KsvmCodInv']);
         $KsvmQuery->bindParam(":KsvmPerElabInv", $KsvmDataInventario['KsvmPerElabInv']);
         $KsvmQuery->bindParam(":KsvmFchElabInv", $KsvmDataInventario['KsvmFchElabInv']);
         $KsvmQuery->bindParam(":KsvmHoraInv", $KsvmDataInventario['KsvmHoraInv']);
         $KsvmQuery->bindParam(":KsvmDuracionInv", $KsvmDataInventario['KsvmDuracionInv']);
         $KsvmQuery->execute();
         return $KsvmQuery;
     }
     /**
      *Función que permite ingresar un detalle de inventario
      */
      protected function __KsvmAgregarDetalleInventarioModelo($KsvmDataInventario)
      {
          $KsvmIngInventario = "INSERT INTO ksvmdetalleinventario11(ExtId, DivStockInv, DivContFisInv, DivDifInv, DivObservInv)
                                     VALUES(:KsvmExtId, :KsvmStockInv, :KsvmContFisInv, :KsvmDifInv, :KsvmObservInv)";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmIngInventario);
          $KsvmQuery->bindParam(":KsvmExtId", $KsvmDataInventario['KsvmExtId']);
          $KsvmQuery->bindParam(":KsvmStockInv", $KsvmDataInventario['KsvmStockInv']);
          $KsvmQuery->bindParam(":KsvmContFisInv", $KsvmDataInventario['KsvmContFisInv']);
          $KsvmQuery->bindParam(":KsvmDifInv", $KsvmDataInventario['KsvmDifInv']);
          $KsvmQuery->bindParam(":KsvmObservInv", $KsvmDataInventario['KsvmObservInv']);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
     /**
      *Función que permite inhabilitar un inventario
      */
      protected function __KsvmEliminarInventarioModelo($KsvmCodInventario)
      {
         $KsvmDelInventario = "UPDATE ksvminventario11 SET IvtEstInv = 'X' WHERE IvtId = :KsvmCodInventario";
         $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmDelInventario);
         $KsvmQuery->bindParam(":KsvmCodInventario", $KsvmCodInventario);
         $KsvmQuery->execute();
         return $KsvmQuery;
      }
      /**
      *Función que permite eliminar un inventario
      */
      protected function __KsvmEliminarInventario($KsvmCodInventario)
      {
         $KsvmDelInventario = "DELETE FROM ksvmdetalleinventario11 WHERE DivId = :KsvmCodInventario";
         $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmDelInventario);
         $KsvmQuery->bindParam(":KsvmCodInventario", $KsvmCodInventario);
         $KsvmQuery->execute();
         return $KsvmQuery;
      }
     /**
      *Función que permite eliminar un inventario
      */
      protected function __KsvmSeleccionarStock($KsvmCodInventario)
      {
         $KsvmStockInventario = "SELECT * FROM ksvmvistadetalleinventario WHERE ExtId = :KsvmCodInventario";
         $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmStockInventario);
         $KsvmQuery->bindParam(":KsvmCodInventario", $KsvmCodInventario);
         $KsvmQuery->execute();
         return $KsvmQuery;
      }
      /**
      *Función que permite editar un inventario
      */
      protected function __KsvmEditarInventarioModelo($KsvmCodInventario)
      {
          $KsvmEditInventario = "SELECT * FROM ksvmvistainventarios WHERE IvtId = :KsvmCodInventario";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmEditInventario);
          $KsvmQuery->bindParam(":KsvmCodInventario", $KsvmCodInventario);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
            /**
      *Función que permite editar un detalle de Inventario
      */
      protected function __KsvmEditarDetalleInventarioModelo($KsvmCodInventario)
      {
          $KsvmEditInventario = "SELECT * FROM ksvmvistadetalleinventario WHERE IvtId = '$KsvmCodInventario'";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmEditInventario);
          $KsvmQuery->bindParam(":KsvmCodInventario", $KsvmCodInventario);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
     /**
      *Función que permite editar una Inventario
      */
      protected function __KsvmCargarDataModelo($KsvmCodInventario)
      {
          $KsvmEditInventario = "SELECT * FROM ksvmvistadetalleinventario WHERE DivId = '$KsvmCodInventario'";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmEditInventario);
          $KsvmQuery->bindParam(":KsvmCodInventario", $KsvmCodInventario);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
       /**
      *Función que permite contar un inventario
      */
      protected function __KsvmContarInventarioModelo($KsvmCodInventario)
      {
          $KsvmContarInventario = "SELECT IvtId FROM ksvmvistainventarios WHERE IvtEstInv != 'X'";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmContarInventario);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
       /**
      *Función que permite actualizar un inventario
      */
      protected function __KsvmActualizarInventarioModelo($KsvmDataInventario)
      {
        $KsvmActInventario = "UPDATE ksvminventario11 SET IvtHoraInv = :KsvmHoraInv, IvtDuracionInv = :KsvmDuracionInv, IvtEstInv = :KsvmEstInv
                              WHERE IvtId = :KsvmCodInventario";
        $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmActInventario);
        $KsvmQuery->bindParam(":KsvmHoraInv", $KsvmDataInventario['KsvmHoraInv']);
        $KsvmQuery->bindParam(":KsvmDuracionInv", $KsvmDataInventario['KsvmDuracionInv']);
        $KsvmQuery->bindParam(":KsvmEstInv", $KsvmDataInventario['KsvmEstInv']);
        $KsvmQuery->bindParam(":KsvmCodInventario", $KsvmDataInventario['KsvmCodInventario']);
        $KsvmQuery->execute();
        return $KsvmQuery;
      }
     /**
      *Función que permite actualizar un detalle de requisición
      */
      protected function __KsvmActualizarDetalleInventarioModelo($KsvmDataInventario)
      {
        $KsvmActInventario = "UPDATE ksvmdetalleInventario13 SET ExtId = :KsvmExtId, DivStockInv = :KsvmStockInv, DivContFisInv = :KsvmContFisInv, 
                              DivDifInv = :KsvmDifInv, DivObservInv = KsvmObservInv WHERE DivId = :KsvmCodInventario";
        $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmActInventario);
        $KsvmQuery->bindParam(":KsvmExtId", $KsvmDataInventario['KsvmExtId']);
        $KsvmQuery->bindParam(":KsvmStockInv", $KsvmDataInventario['KsvmStockInv']);
        $KsvmQuery->bindParam(":KsvmContFisInv", $KsvmDataInventario['KsvmContFisInv']);
        $KsvmQuery->bindParam(":KsvmDifInv", $KsvmDataInventario['KsvmDifInv']);
        $KsvmQuery->bindParam(":KsvmObservInv", $KsvmDataInventario['KsvmObservInv']);
         $KsvmQuery->bindParam(":KsvmCodInventario", $KsvmDataInventario['KsvmCodInventario']);
         $KsvmQuery->execute();
         return $KsvmQuery;
      }

   }
