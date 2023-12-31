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
         $KsvmIngInventario = "INSERT INTO ksvminventario11(BdgId, IvtCodInv, IvtPerElabInv, IvtFchElabInv, IvtHoraInv, IvtDuracionInv, UsrId)
                                    VALUES(:KsvmBdgId, :KsvmCodInv, :KsvmPerElabInv, :KsvmFchElabInv, :KsvmHoraInv, :KsvmDuracionInv, :KsvmUsrId)";
         $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmIngInventario);
         $KsvmQuery->bindParam(":KsvmBdgId", $KsvmDataInventario['KsvmBdgId']);
         $KsvmQuery->bindParam(":KsvmCodInv", $KsvmDataInventario['KsvmCodInv']);
         $KsvmQuery->bindParam(":KsvmPerElabInv", $KsvmDataInventario['KsvmPerElabInv']);
         $KsvmQuery->bindParam(":KsvmFchElabInv", $KsvmDataInventario['KsvmFchElabInv']);
         $KsvmQuery->bindParam(":KsvmHoraInv", $KsvmDataInventario['KsvmHoraInv']);
         $KsvmQuery->bindParam(":KsvmDuracionInv", $KsvmDataInventario['KsvmDuracionInv']);
         $KsvmQuery->bindParam(":KsvmUsrId", $KsvmDataInventario['KsvmUsrId']);
         $KsvmQuery->execute();
         return $KsvmQuery;
     }
     /**
      *Función que permite ingresar un detalle de inventario
      */
      protected function __KsvmAgregarDetalleInventarioModelo($KsvmDataInventario)
      {
          $KsvmIngInventario = "INSERT INTO ksvmdetalleinventario11(ExtId, DivNuevoStockInv, DivStockInv, DivContFisInv, DivDifInv, DivObservInv)
                                     VALUES(:KsvmExtId, :KsvmNuevoStockInv, :KsvmStockInv, :KsvmContFisInv, :KsvmDifInv, :KsvmObservInv)";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmIngInventario);
          $KsvmQuery->bindParam(":KsvmExtId", $KsvmDataInventario['KsvmExtId']);
          $KsvmQuery->bindParam(":KsvmNuevoStockInv", $KsvmDataInventario['KsvmNuevoStockInv']);
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
         $KsvmDelInventario = "UPDATE ksvminventario11 SET IvtEstInv = 'I' WHERE IvtId = :KsvmCodInventario";
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
      protected function __KsvmSeleccionarStock($KsvmCodInventario, $KsvmBodega)
      {
        $KsvmStockInventario = "SELECT * FROM ksvmvistadetalleinventario WHERE ExtId = :KsvmCodInventario AND BdgId = :KsvmCodBodega";
        $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmStockInventario);
        $KsvmQuery->bindParam(":KsvmCodInventario", $KsvmCodInventario);
        $KsvmQuery->bindParam(":KsvmCodBodega", $KsvmBodega);
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
      *Función que permite contar una Inventario
      */
      protected function __KsvmContarInventarioModelo()
      {
          $KsvmContarInventario = "SELECT IvtId FROM ksvmvistainventarios WHERE IvtEstInv != 'X'";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmContarInventario);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
     /**
      *Función que permite contar un inventario
      */
      protected function __KsvmContarInventarioSupervisor()
      {
          $KsvmContarInventario = "SELECT IvtId FROM ksvmvistainventarios WHERE IvtEstInv = 'P'";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmContarInventario);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
     /**
      *Función que permite contar un inventario
      */
      protected function __KsvmContarInventarioTecnico()
      {
          $KsvmContarInventario = "SELECT IvtId FROM ksvmvistainventarios WHERE IvtEstInv = 'A'";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmContarInventario);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
       /**
      *Función que permite contar un inventario
      */
      protected function __KsvmContarInventarioUsuario()
      {
          $KsvmContarInventario = "SELECT IvtId FROM ksvmvistainventarios WHERE IvtEstInv = 'A'";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmContarInventario);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
     /**
      *Función que permite aprobar una inventario
      */
      protected function __KsvmApruebaInventarioModelo($KsvmDataInventario)
      {
          $KsvmApbrInventario = "UPDATE ksvminventario11 SET IvtEstInv = 'A' WHERE IvtId = :KsvmCodInventario";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmApbrInventario);
          $KsvmQuery->bindParam(":KsvmCodInventario", $KsvmDataInventario['KsvmCodInventario']);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
     /**
      *Función que permite imprimir un Inventario
      */
      protected function __KsvmImprimirInventarioModelo()
      {
          $KsvmImprimirInventario = "SELECT * FROM ksvmvistainventarios";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->query($KsvmImprimirInventario);
          return $KsvmQuery;
      }
     /**
      *Función que permite actualizar un inventario
      */
      protected function __KsvmActualizarInventarioModelo($KsvmDataInventario)
      {
        $KsvmActInventario = "UPDATE ksvminventario11 SET IvtHoraInv = :KsvmHoraInv, IvtDuracionInv = :KsvmDuracionInv, UsrId = :KsvmUsrId, 
                              IvtEstInv = :KsvmEstInv WHERE IvtId = :KsvmCodInventario";
        $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmActInventario);
        $KsvmQuery->bindParam(":KsvmHoraInv", $KsvmDataInventario['KsvmHoraInv']);
        $KsvmQuery->bindParam(":KsvmDuracionInv", $KsvmDataInventario['KsvmDuracionInv']);
        $KsvmQuery->bindParam(":KsvmUsrId", $KsvmDataInventario['KsvmUsrId']);
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
