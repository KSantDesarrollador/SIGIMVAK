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
            $KsvmIngRequisicion = "INSERT INTO ksvmrequisicion13(RqcNumReq, RqcOrigenReq, RqcFchRevReq, RqcPerElabReq, RqcPerAprbReq)
                                    VALUES(:KsvmNumReq, :KsvmOrigenReq, :KsvmFchRevReq, :KsvmPerElabReq, :KsvmPerAprbReq)";
            $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmIngRequisicion);
            $KsvmQuery->bindParam(":KsvmNumReq", $KsvmDataRequisicion['KsvmNumReq']);
            $KsvmQuery->bindParam(":KsvmOrigenReq", $KsvmDataRequisicion['KsvmOrigenReq']);
            $KsvmQuery->bindParam(":KsvmFchRevReq", $KsvmDataRequisicion['KsvmFchRevReq']);
            $KsvmQuery->bindParam(":KsvmPerElabReq", $KsvmDataRequisicion['KsvmPerElabReq']);
            $KsvmQuery->bindParam(":KsvmPerAprbReq", $KsvmDataRequisicion['KsvmPerAprbReq']);
            $KsvmQuery->execute();
         } else {
            $KsvmIngRequisicion = "INSERT INTO ksvmrequisicion13(IvtId, RqcNumReq, RqcOrigenReq, RqcFchRevReq, RqcPerElabReq, RqcPerAprbReq)
                                    VALUES(:KsvmIvtId, :KsvmNumReq, :KsvmOrigenReq, :KsvmFchRevReq, :KsvmPerElabReq, :KsvmPerAprbReq)";
            $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmIngRequisicion);
            $KsvmQuery->bindParam(":KsvmIvtId", $KsvmDataRequisicion['KsvmIvtId']);
            $KsvmQuery->bindParam(":KsvmNumReq", $KsvmDataRequisicion['KsvmNumReq']);
            $KsvmQuery->bindParam(":KsvmOrigenReq", $KsvmDataRequisicion['KsvmOrigenReq']);
            $KsvmQuery->bindParam(":KsvmFchRevReq", $KsvmDataRequisicion['KsvmFchRevReq']);
            $KsvmQuery->bindParam(":KsvmPerElabReq", $KsvmDataRequisicion['KsvmPerElabReq']);
            $KsvmQuery->bindParam(":KsvmPerAprbReq", $KsvmDataRequisicion['KsvmPerAprbReq']);
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
         $KsvmDelRequisicion = "UPDATE ksvmrequisicion13 SET RqcEstReq = 'X' WHERE RqcId = :KsvmCodRequisicion";
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
          $KsvmEditRequisicion = "SELECT * FROM ksvmvistadetallepedido WHERE RqcId = :KsvmCodRequisicion";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmEditRequisicion);
          $KsvmQuery->bindParam(":KsvmCodRequisicion", $KsvmCodRequisicion);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
       /**
      *Función que permite contar una requisición
      */
      protected function __KsvmContarRequisicionModelo($KsvmCodRequisicion)
      {
          $KsvmContarRequisicion = "SELECT RqcId FROM ksvmvistapedidos WHERE RqcEstReq != 'X'";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmContarRequisicion);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
       /**
      *Función que permite actualizar una requisición
      */
      protected function __KsvmActualizarRequisicionModelo($KsvmDataRequisicion)
      {
        $KsvmActRequisicion = "UPDATE ksvmrequisicion13 SET IvtId = :KsvmIvtId, RqcOrigenReq = :KsvmOrigenReq, RqcFchRevReq = :KsvmFchRevReq, 
                                      RqcPerAprbReq = :KsvmPerAprbReq WHERE RqcId = :KsvmCodRequisicion";
        $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmActRequisicion);
        $KsvmQuery->bindParam(":KsvmIvtId", $KsvmDataRequisicion['KsvmIvtId']);
        $KsvmQuery->bindParam(":KsvmOrigenReq", $KsvmDataRequisicion['KsvmOrigenReq']);
        $KsvmQuery->bindParam(":KsvmFchRevReq", $KsvmDataRequisicion['KsvmFchRevReq']);
        $KsvmQuery->bindParam(":KsvmPerAprbReq", $KsvmDataRequisicion['KsvmPerAprbReq']);
         $KsvmQuery->bindParam(":KsvmCodRequisicion", $KsvmDataRequisicion['KsvmCodRequisicion']);
         $KsvmQuery->execute();
         return $KsvmQuery;
      }
     /**
      *Función que permite actualizar un detalle de requisición
      */
      protected function __KsvmActualizarDetalleRequisicionModelo($KsvmDataRequisicion)
      {
        $KsvmActRequisicion = "UPDATE ksvmdetallerequisicion13 SET ExtId = :KsvmExtId, DrqCantReq = :KsvmCantReq, 
                            DrqStockReq = :KsvmStockReq, DrqObservReq = :KsvmObservReq WHERE DrqId = :KsvmCodRequisicion";
        $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmActRequisicion);
        $KsvmQuery->bindParam(":KsvmExtId", $KsvmDataRequisicion['KsvmExtId']);
        $KsvmQuery->bindParam(":KsvmCantReq", $KsvmDataRequisicion['KsvmCantReq']);
        $KsvmQuery->bindParam(":KsvmStockReq", $KsvmDataRequisicion['KsvmStockReq']);
        $KsvmQuery->bindParam(":KsvmObservReq", $KsvmDataRequisicion['KsvmObservReq']);
         $KsvmQuery->bindParam(":KsvmCodRequisicion", $KsvmDataRequisicion['KsvmCodRequisicion']);
         $KsvmQuery->execute();
         return $KsvmQuery;
      }

   }
