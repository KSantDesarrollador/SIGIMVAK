<?php

  /**
   *Condicion para peticion Ajax
   */
   if ($KsvmPeticionAjax) {
       require_once "../Raiz/KsvmEstMaestra.php";
   } else {
       require_once "./Raiz/KsvmEstMaestra.php";
   }

   class KsvmCompraModelo extends KsvmEstMaestra
   {
     /**
      *Función que permite ingresar una compra
      */
     protected function __KsvmAgregarCompraModelo($KsvmDataCompra)
     {
         $KsvmIngCompra = "INSERT INTO ksvmcompras14(UmdId, CmpNumOcp, PvdId, CmpFchElabOcp, CmpFchPagoOcp, CmpNumFactOcp, CmpPerElabOcp, CmpPerAprbOcp)
                                    VALUES(:KsvmUmdId, :KsvmNumOcp, :KsvmPvdId, :KsvmFchElabOcp, :KsvmFchPagoOcp, :KsvmNumFactOcp, :KsvmPerElabOcp, :KsvmPerAprbOcp)";
         $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmIngCompra);
         $KsvmQuery->bindParam(":KsvmUmdId", $KsvmDataCompra['KsvmUmdId']);
         $KsvmQuery->bindParam(":KsvmNumOcp", $KsvmDataCompra['KsvmNumOcp']);
         $KsvmQuery->bindParam(":KsvmPvdId", $KsvmDataCompra['KsvmPvdId']);
         $KsvmQuery->bindParam(":KsvmFchElabOcp", $KsvmDataCompra['KsvmFchElabOcp']);
         $KsvmQuery->bindParam(":KsvmFchPagoOcp", $KsvmDataCompra['KsvmFchPagoOcp']);
         $KsvmQuery->bindParam(":KsvmNumFactOcp", $KsvmDataCompra['KsvmNumFactOcp']);
         $KsvmQuery->bindParam(":KsvmPerElabOcp", $KsvmDataCompra['KsvmPerElabOcp']);
         $KsvmQuery->bindParam(":KsvmPerAprbOcp", $KsvmDataCompra['KsvmPerAprbOcp']);
         $KsvmQuery->execute();
         return $KsvmQuery;
     }
      /**
      *Función que permite ingresar un detalle de compra
      */
      protected function __KsvmAgregarDetalleCompraModelo($KsvmDataCompra)
      {
          $KsvmIngCompra = "INSERT INTO ksvmdetallecompras14(MdcId, DocCantOcp, DocValorUntOcp, DocValorTotOcp, DocObservOcp)
                                     VALUES(:KsvmMdcId, :KsvmCantOcp, :KsvmValorUntOcp, 
                                             :KsvmValorTotOcp, :KsvmObservOcp)";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmIngCompra);
          $KsvmQuery->bindParam(":KsvmMdcId", $KsvmDataCompra['KsvmMdcId']);
          $KsvmQuery->bindParam(":KsvmCantOcp", $KsvmDataCompra['KsvmCantOcp']);
          $KsvmQuery->bindParam(":KsvmValorUntOcp", $KsvmDataCompra['KsvmValorUntOcp']);
          $KsvmQuery->bindParam(":KsvmValorTotOcp", $KsvmDataCompra['KsvmValorTotOcp']);
          $KsvmQuery->bindParam(":KsvmObservOcp", $KsvmDataCompra['KsvmObservOcp']);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
     /**
      *Función que permite inhabilitar una compra
      */
      protected function __KsvmEliminarCompraModelo($KsvmCodCompra)
      {
         $KsvmDelCompra = "UPDATE ksvmcompras14 SET CmpEstOcp = 'I' WHERE CmpId = :KsvmCodCompra";
         $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmDelCompra);
         $KsvmQuery->bindParam(":KsvmCodCompra", $KsvmCodCompra);
         $KsvmQuery->execute();
         return $KsvmQuery;
      }
     /**
      *Función que permite eliminar una compra
      */
      protected function __KsvmEliminarCompra($KsvmCodCompra)
      {
         $KsvmDelCompra = "DELETE FROM ksvmdetallecompras14 WHERE DocId = :KsvmCodCompra";
         $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmDelCompra);
         $KsvmQuery->bindParam(":KsvmCodCompra", $KsvmCodCompra);
         $KsvmQuery->execute();
         return $KsvmQuery;
      }
            /**
      *Función que permite editar una compra
      */
      protected function __KsvmEditarCompraModelo($KsvmCodCompra)
      {
          $KsvmEditCompra = "SELECT * FROM ksvmvistacompras WHERE CmpId = :KsvmCodCompra";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmEditCompra);
          $KsvmQuery->bindParam(":KsvmCodCompra", $KsvmCodCompra);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
      /**
      *Función que permite editar una compra
      */
      protected function __KsvmEditarDetalleCompraModelo($KsvmCodCompra)
      {
          $KsvmEditCompra = "SELECT * FROM ksvmvistadetallecompras WHERE CmpId = :KsvmCodCompra";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmEditCompra);
          $KsvmQuery->bindParam(":KsvmCodCompra", $KsvmCodCompra);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
     /**
      *Función que permite editar una compra
      */
      protected function __KsvmCargarDataModelo($KsvmCodCompra)
      {
          $KsvmEditCompra = "SELECT * FROM ksvmvistadetallecompras WHERE DocId = :KsvmCodCompra";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmEditCompra);
          $KsvmQuery->bindParam(":KsvmCodCompra", $KsvmCodCompra);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
     /**
      *Función que permite contar una compra
      */
      protected function __KsvmContarCompraModelo()
      {
          $KsvmContarCompra = "SELECT CmpId FROM ksvmvistacompras WHERE CmpEstOcp != 'X'";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmContarCompra);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
     /**
      *Función que permite contar una compra
      */
      protected function __KsvmContarCompraSuperModelo()
      {
          $KsvmContarCompra = "SELECT CmpId FROM ksvmvistacompras WHERE CmpEstOcp = 'P'";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmContarCompra);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
     /**
      *Función que permite contar una compra
      */
      protected function __KsvmContarCompraTecniModelo()
      {
          $KsvmContarCompra = "SELECT CmpId FROM ksvmvistacompras WHERE CmpEstOcp = 'A'";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmContarCompra);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
     /**
      *Función que permite aprobar una compra
      */
      protected function __KsvmApruebaCompraModelo($KsvmDataCompra)
      {
          $KsvmApbrCompra = "UPDATE ksvmcompras14 SET CmpEstOcp = 'A' WHERE CmpId = :KsvmCodCompra";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmApbrCompra);
          $KsvmQuery->bindParam(":KsvmCodCompra", $KsvmDataCompra['KsvmCodCompra']);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
     /**
      *Función que permite negar una compra
      */
      protected function __KsvmNiegaCompraModelo($KsvmDataCompra)
      {
          $KsvmNiegaCompra = "UPDATE ksvmcompras14 SET CmpEstOcp = 'X' WHERE CmpId = :KsvmCodCompra";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmNiegaCompra);
          $KsvmQuery->bindParam(":KsvmCodCompra", $KsvmDataCompra['KsvmCodCompra']);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
     /**
      *Función que permite imprimir una Compra
      */
      protected function __KsvmImprimirCompraModelo()
      {
          $KsvmImprimirCompra = "SELECT * FROM ksvmvistacompras";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->query($KsvmImprimirCompra);
          return $KsvmQuery;
      }
       /**
      *Función que permite actualizar una compra
      */
      protected function __KsvmActualizarCompraModelo($KsvmDataCompra)
      {
        $KsvmActCompra = "UPDATE ksvmcompras14 SET UmdId = :KsvmUmdId, PvdId = :KsvmPvdId, CmpFchPagoOcp = :KsvmFchPagoOcp, 
                          CmpNumFactOcp = :KsvmNumFactOcp, CmpPerAprbOcp = :KsvmPerAprbOcp WHERE CmpId = :KsvmCodCompra";
        $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmActCompra);
         $KsvmQuery->bindParam(":KsvmUmdId", $KsvmDataCompra['KsvmUmdId']);
         $KsvmQuery->bindParam(":KsvmPvdId", $KsvmDataCompra['KsvmPvdId']);
         $KsvmQuery->bindParam(":KsvmFchPagoOcp", $KsvmDataCompra['KsvmFchPagoOcp']);
         $KsvmQuery->bindParam(":KsvmNumFactOcp", $KsvmDataCompra['KsvmNumFactOcp']);
         $KsvmQuery->bindParam(":KsvmPerAprbOcp", $KsvmDataCompra['KsvmPerAprbOcp']);
         $KsvmQuery->bindParam(":KsvmCodCompra", $KsvmDataCompra['KsvmCodCompra']);
         $KsvmQuery->execute();
         return $KsvmQuery;
      }
        /**
      *Función que permite actualizar un detalle de compra
      */
      protected function __KsvmActualizarDetalleCompraModelo($KsvmDataCompra)
      {
        $KsvmActCompra = "UPDATE ksvmdetallecompras14 SET MdcId = :KsvmMdcId, CmpCantOcp = :KsvmCantOcp, 
                            CmpValorUntOcp = :KsvmValorUntOcp, CmpValorTotOcp = :KsvmValorTotOcp, CmpObservOcp = :KsvmObservOcp WHERE CmpId = :KsvmCodCompra";
        $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmActCompra);
         $KsvmQuery->bindParam(":KsvmMdcId", $KsvmDataCompra['KsvmMdcId']);
         $KsvmQuery->bindParam(":KsvmCantOcp", $KsvmDataCompra['KsvmCantOcp']);
         $KsvmQuery->bindParam(":KsvmValorUntOcp", $KsvmDataCompra['KsvmValorUntOcp']);
         $KsvmQuery->bindParam(":KsvmValorTotOcp", $KsvmDataCompra['KsvmValorTotOcp']);
         $KsvmQuery->bindParam(":KsvmObservOcp", $KsvmDataCompra['KsvmObservOcp']);
         $KsvmQuery->bindParam(":KsvmCodCompra", $KsvmDataCompra['KsvmCodCompra']);
         $KsvmQuery->execute();
         return $KsvmQuery;
      }

   }
