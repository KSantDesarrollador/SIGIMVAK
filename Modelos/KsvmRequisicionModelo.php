<?php

  /**
   *Condicion para peticion Ajax
   */
   if ($KsvmPeticionAjax) {
       require_once "../Raiz/KsvmEstMaestra.php";
   } else {
       require_once "./Raiz/KsvmEstMaestra.php";
   }

   class KsvmRequisicionModelo extends KsvmEstMaestra
   {
     /**
      *Función que permite ingresar una requisición
      */
     protected function __KsvmAgregarRequisicionModelo($KsvmDataRequisicion)
     {
         if ($KsvmDataRequisicion['KsvmIvtId'] == 0) {
            $KsvmIngRequisicion = "INSERT INTO ksvmrequisicion13(RqcNumReq, RqcOrigenReq, RqcFchElabReq, RqcFchRevReq, RqcPerElabReq, RqcPerAprbReq, UsrId)
                                    VALUES(:KsvmNumReq, :KsvmOrigenReq, :KsvmFchElabReq, :KsvmFchRevReq, :KsvmPerElabReq, :KsvmPerAprbReq, :KsvmUsrId)";
            $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmIngRequisicion);
            $KsvmQuery->bindParam(":KsvmNumReq", $KsvmDataRequisicion['KsvmNumReq']);
            $KsvmQuery->bindParam(":KsvmOrigenReq", $KsvmDataRequisicion['KsvmOrigenReq']);
            $KsvmQuery->bindParam(":KsvmFchElabReq", $KsvmDataRequisicion['KsvmFchElabReq']);
            $KsvmQuery->bindParam(":KsvmFchRevReq", $KsvmDataRequisicion['KsvmFchRevReq']);
            $KsvmQuery->bindParam(":KsvmPerElabReq", $KsvmDataRequisicion['KsvmPerElabReq']);
            $KsvmQuery->bindParam(":KsvmPerAprbReq", $KsvmDataRequisicion['KsvmPerAprbReq']);
            $KsvmQuery->bindParam(":KsvmUsrId", $KsvmDataRequisicion['KsvmUsrId']);
            $KsvmQuery->execute();
         } else {
            $KsvmIngRequisicion = "INSERT INTO ksvmrequisicion13(IvtId, RqcNumReq, RqcOrigenReq, RqcFchElabReq, RqcFchRevReq, RqcPerElabReq, RqcPerAprbReq, UsrId)
                                    VALUES(:KsvmIvtId, :KsvmNumReq, :KsvmOrigenReq, :KsvmFchElabReq, :KsvmFchRevReq, :KsvmPerElabReq, :KsvmPerAprbReq, :KsvmUsrId)";
            $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmIngRequisicion);
            $KsvmQuery->bindParam(":KsvmIvtId", $KsvmDataRequisicion['KsvmIvtId']);
            $KsvmQuery->bindParam(":KsvmNumReq", $KsvmDataRequisicion['KsvmNumReq']);
            $KsvmQuery->bindParam(":KsvmOrigenReq", $KsvmDataRequisicion['KsvmOrigenReq']);
            $KsvmQuery->bindParam(":KsvmFchElabReq", $KsvmDataRequisicion['KsvmFchElabReq']);
            $KsvmQuery->bindParam(":KsvmFchRevReq", $KsvmDataRequisicion['KsvmFchRevReq']);
            $KsvmQuery->bindParam(":KsvmPerElabReq", $KsvmDataRequisicion['KsvmPerElabReq']);
            $KsvmQuery->bindParam(":KsvmPerAprbReq", $KsvmDataRequisicion['KsvmPerAprbReq']);
            $KsvmQuery->bindParam(":KsvmUsrId", $KsvmDataRequisicion['KsvmUsrId']);
            $KsvmQuery->execute();
         }
         
         return $KsvmQuery;
     }
     /**
      *Función que permite ingresar un detalle de requisición
      */
      protected function __KsvmAgregarDetalleRequisicionModelo($KsvmDataRequisicion)
      {
          $KsvmIngRequisicion = "INSERT INTO ksvmdetallerequisicion13(ExtId, DrqStockReq, DrqCantReq, DrqObservReq)
                                     VALUES(:KsvmExtId, :KsvmStockReq, :KsvmCantReq, :KsvmObservReq)";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmIngRequisicion);
          $KsvmQuery->bindParam(":KsvmExtId", $KsvmDataRequisicion['KsvmExtId']);
          $KsvmQuery->bindParam(":KsvmCantReq", $KsvmDataRequisicion['KsvmCantReq']);
          $KsvmQuery->bindParam(":KsvmStockReq", $KsvmDataRequisicion['KsvmStockReq']);
          $KsvmQuery->bindParam(":KsvmObservReq", $KsvmDataRequisicion['KsvmObservReq']);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
     /**
      *Función que permite inhabilitar una requisición
      */
      protected function __KsvmEliminarRequisicionModelo($KsvmCodRequisicion)
      {
         $KsvmDelRequisicion = "UPDATE ksvmrequisicion13 SET RqcEstReq = 'I' WHERE RqcId = :KsvmCodRequisicion";
         $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmDelRequisicion);
         $KsvmQuery->bindParam(":KsvmCodRequisicion", $KsvmCodRequisicion);
         $KsvmQuery->execute();
         return $KsvmQuery;
      }
     /**
      *Función que permite eliminar una requisición
      */
      protected function __KsvmEliminarRequisicion($KsvmCodRequisicion)
      {
         $KsvmDelRequisicion = "DELETE FROM ksvmdetallerequisicion13 WHERE DrqId = :KsvmCodRequisicion";
         $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmDelRequisicion);
         $KsvmQuery->bindParam(":KsvmCodRequisicion", $KsvmCodRequisicion);
         $KsvmQuery->execute();
         return $KsvmQuery;
      }
           /**
      *Función que permite eliminar un inventario
      */
      protected function __KsvmSeleccionarCantidad($KsvmCodRequisicion)
      {
         $KsvmCantRequisicion = "SELECT * FROM ksvmvistadetallepedido WHERE ExtId = :KsvmCodRequisicion";
         $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmCantRequisicion);
         $KsvmQuery->bindParam(":KsvmCodRequisicion", $KsvmCodRequisicion);
         $KsvmQuery->execute();
         return $KsvmQuery;
      }
      /**
      *Función que permite editar una requisición
      */
      protected function __KsvmEditarRequisicionModelo($KsvmCodRequisicion)
      {
          $KsvmEditRequisicion = "SELECT * FROM ksvmvistapedidos WHERE RqcId = :KsvmCodRequisicion";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmEditRequisicion);
          $KsvmQuery->bindParam(":KsvmCodRequisicion", $KsvmCodRequisicion);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
           /**
      *Función que permite editar un detalle de Requisicion
      */
      protected function __KsvmEditarDetalleRequisicionModelo($KsvmCodRequisicion)
      {
          $KsvmEditRequisicion = "SELECT * FROM ksvmvistadetallepedido WHERE RqcId = '$KsvmCodRequisicion'";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmEditRequisicion);
          $KsvmQuery->bindParam(":KsvmCodRequisicion", $KsvmCodRequisicion);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
     /**
      *Función que permite editar una Requisicion
      */
      protected function __KsvmCargarDataModelo($KsvmCodRequisicion)
      {
          $KsvmEditRequisicion = "SELECT * FROM ksvmvistadetallepedido WHERE DrqId = '$KsvmCodRequisicion'";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmEditRequisicion);
          $KsvmQuery->bindParam(":KsvmCodRequisicion", $KsvmCodRequisicion);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
     /**
      *Función que permite contar una requisición
      */
      protected function __KsvmContarRequisicionModelo()
      {
          $KsvmContarRequisicion = "SELECT RqcId FROM ksvmvistapedidos WHERE RqcEstReq != 'X'";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmContarRequisicion);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
       /**
      *Función que permite contar una requisición
      */
      protected function __KsvmContarRequisicionSuperModelo()
      {
          $KsvmContarRequisicion = "SELECT RqcId FROM ksvmvistapedidos WHERE RqcEstReq = 'P'";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmContarRequisicion);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
             /**
      *Función que permite contar una requisición
      */
      protected function __KsvmContarRequisicionTecniModelo($KsvmUsuario)
      {
          $KsvmContarRequisicion = "SELECT RqcId FROM ksvmvistapedidos WHERE RqcEstReq = 'A' AND UsrId = '$KsvmUsuario'";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmContarRequisicion);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
     /**
      *Función que permite aprobar una requisición
      */
      protected function __KsvmApruebaRequisicionModelo($KsvmDataRequisicion)
      {
          $KsvmApbrRequisicion = "UPDATE ksvmrequisicion13 SET RqcFchRevReq = :KsvmFchRevReq, RqcPerAprbReq = :KsvmPerAprbReq, 
                            RqcEstReq = 'A' WHERE RqcId = :KsvmCodRequisicion";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmApbrRequisicion);
          $KsvmQuery->bindParam(":KsvmFchRevReq", $KsvmDataRequisicion['KsvmFchRevReq']);
          $KsvmQuery->bindParam(":KsvmPerAprbReq", $KsvmDataRequisicion['KsvmPerAprbReq']);
          $KsvmQuery->bindParam(":KsvmCodRequisicion", $KsvmDataRequisicion['KsvmCodRequisicion']);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
     /**
      *Función que permite negar una requisición
      */
      protected function __KsvmNiegaRequisicionModelo($KsvmDataRequisicion)
      {
          $KsvmNiegaRequisicion = "UPDATE ksvmrequisicion13 SET CmpFchRevOcp = :KsvmFchRevReq, RqcPerAprbReq = :KsvmPerAprbReq, 
                             RqcEstReq = 'X' WHERE RqcId = :KsvmCodRequisicion";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmNiegaRequisicion);
          $KsvmQuery->bindParam(":KsvmFchRevReq", $KsvmDataRequisicion['KsvmFchRevReq']);
          $KsvmQuery->bindParam(":KsvmPerAprbReq", $KsvmDataRequisicion['KsvmPerAprbReq']);
          $KsvmQuery->bindParam(":KsvmCodRequisicion", $KsvmDataRequisicion['KsvmCodRequisicion']);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
     /**
      *Función que permite imprimir una Requisicion      
      */
      protected function __KsvmImprimirRequisicionModelo()
      {
          $KsvmImprimirRequisicion = "SELECT * FROM ksvmvistapedidos";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->query($KsvmImprimirRequisicion);
          return $KsvmQuery;
      }
       /**
      *Función que permite actualizar una requisición
      */
      protected function __KsvmActualizarRequisicionModelo($KsvmDataRequisicion)
      {
        $KsvmActRequisicion = "UPDATE ksvmrequisicion13 SET RqcOrigenReq = :KsvmOrigenReq, RqcFchRevReq = :KsvmFchRevReq, 
                                      RqcPerAprbReq = :KsvmPerAprbReq, UsrId = :KsvmUsrId, RqcEstReq = :KsvmEstReq WHERE RqcId = :KsvmCodRequisicion";
        $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmActRequisicion);
        $KsvmQuery->bindParam(":KsvmOrigenReq", $KsvmDataRequisicion['KsvmOrigenReq']);
        $KsvmQuery->bindParam(":KsvmFchRevReq", $KsvmDataRequisicion['KsvmFchRevReq']);
        $KsvmQuery->bindParam(":KsvmPerAprbReq", $KsvmDataRequisicion['KsvmPerAprbReq']);
        $KsvmQuery->bindParam(":KsvmUsrId", $KsvmDataRequisicion['KsvmUsrId']);
        $KsvmQuery->bindParam(":KsvmEstReq", $KsvmDataRequisicion['KsvmEstReq']);
        $KsvmQuery->bindParam(":KsvmCodRequisicion", $KsvmDataRequisicion['KsvmCodRequisicion']);
        $KsvmQuery->execute();
        return $KsvmQuery;
      }
     /**
      *Función que permite actualizar un detalle de requisición
      */
      protected function __KsvmActualizarDetalleRequisicionModelo($KsvmDataRequisicion)
      {
        $KsvmActRequisicion = "UPDATE ksvmdetallerequisicion13 SET ExtId = :KsvmExtId, DrqStockReq = :KsvmStockReq,
                            DrqCantReq = :KsvmCantReq, DrqObservReq = :KsvmObservReq WHERE DrqId = :KsvmCodRequisicion";
        $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmActRequisicion);
        $KsvmQuery->bindParam(":KsvmExtId", $KsvmDataRequisicion['KsvmExtId']);
        $KsvmQuery->bindParam(":KsvmStockReq", $KsvmDataRequisicion['KsvmStockReq']);
        $KsvmQuery->bindParam(":KsvmCantReq", $KsvmDataRequisicion['KsvmCantReq']);
        $KsvmQuery->bindParam(":KsvmObservReq", $KsvmDataRequisicion['KsvmObservReq']);
        $KsvmQuery->bindParam(":KsvmCodRequisicion", $KsvmDataRequisicion['KsvmCodRequisicion']);
        $KsvmQuery->execute();
        return $KsvmQuery;
      }

   }
