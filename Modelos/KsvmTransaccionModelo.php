<?php

  /**
   *Condicion para peticion Ajax
   */
   if ($KsvmPeticionAjax) {
       require_once "../Raiz/KsvmEstMaestra.php";
   } else {
       require_once "./Raiz/KsvmEstMaestra.php";
   }

   class KsvmTransaccionModelo extends KsvmEstMaestra
   {
     /**
      *Función que permite ingresar una transacción
      */
     protected function __KsvmAgregarTransaccionModelo($KsvmDataTransaccion)
     {
         $KsvmIngTransaccion = "INSERT INTO ksvmtransaccion16(RqcId, TsnNumTran, TsnTipoTran, TsnDestinoTran, TsnPerReaTran, TsnFchRevTran, TsnPerRevTran)
                                    VALUES(:KsvmRqcId, :KsvmNumTran, :KsvmTipoTran, :KsvmDestinoTran, :KsvmPerReaTran, :KsvmFchRevTran, :KsvmPerRevTran)";
         $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmIngTransaccion);
         $KsvmQuery->bindParam(":KsvmRqcId", $KsvmDataTransaccion['KsvmRqcId']);
         $KsvmQuery->bindParam(":KsvmNumTran", $KsvmDataTransaccion['KsvmNumTran']);
         $KsvmQuery->bindParam(":KsvmTipoTran", $KsvmDataTransaccion['KsvmTipoTran']);
         $KsvmQuery->bindParam(":KsvmDestinoTran", $KsvmDataTransaccion['KsvmDestinoTran']);
         $KsvmQuery->bindParam(":KsvmPerReaTran", $KsvmDataTransaccion['KsvmPerReaTran']);
         $KsvmQuery->bindParam(":KsvmFchRevTran", $KsvmDataTransaccion['KsvmFchRevTran']);
         $KsvmQuery->bindParam(":KsvmPerRevTran", $KsvmDataTransaccion['KsvmPerRevTran']);
         $KsvmQuery->execute();
         return $KsvmQuery;
     }
     /**
      *Función que permite ingresar un detalle de transacción
      */
      protected function __KsvmAgregarDetalleTransaccionModelo($KsvmDataTransaccion)
      {
          $KsvmIngTransaccion = "INSERT INTO ksvmdetalletransaccion16(ExtId, DtsCantTran, DtsTipoTran, DtsObservTran)
                                     VALUES(:KsvmExtId, :KsvmCantTran, :KsvmTipoTran, :KsvmObservTran)";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmIngTransaccion);
          $KsvmQuery->bindParam(":KsvmExtId", $KsvmDataTransaccion['KsvmExtId']);
          $KsvmQuery->bindParam(":KsvmTipoTran", $KsvmDataTransaccion['KsvmTipoTran']);
          $KsvmQuery->bindParam(":KsvmCantTran", $KsvmDataTransaccion['KsvmCantTran']);
          $KsvmQuery->bindParam(":KsvmObservTran", $KsvmDataTransaccion['KsvmObservTran']);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
     /**
      *Función que permite inhabilitar una transacción
      */
      protected function __KsvmEliminarTransaccionModelo($KsvmCodTransaccion)
      {
         $KsvmDelTransaccion = "UPDATE ksvmtransaccion16 SET TsnEstTran = 'X' WHERE TsnId = :KsvmCodTransaccion";
         $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmDelTransaccion);
         $KsvmQuery->bindParam(":KsvmCodTransaccion", $KsvmCodTransaccion);
         $KsvmQuery->execute();
         return $KsvmQuery;
      }
     /**
      *Función que permite eliminar una transacción
      */
      protected function __KsvmEliminarTransaccion($KsvmCodTransaccion)
      {
         $KsvmDelTransaccion = "DELETE FROM ksvmdetalletransaccion16 WHERE DtsId = :KsvmCodTransaccion";
         $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmDelTransaccion);
         $KsvmQuery->bindParam(":KsvmCodTransaccion", $KsvmCodTransaccion);
         $KsvmQuery->execute();
         return $KsvmQuery;
      }
      /**
      *Función que permite editar una transacción
      */
      protected function __KsvmEditarTransaccionModelo($KsvmCodTransaccion)
      {
          $KsvmEditTransaccion = "SELECT * FROM ksvmvistatransacciones WHERE TsnId = :KsvmCodTransaccion";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmEditTransaccion);
          $KsvmQuery->bindParam(":KsvmCodTransaccion", $KsvmCodTransaccion);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
            /**
      *Función que permite editar una Transaccion
      */
      protected function __KsvmEditarDetalleTransaccionModelo($KsvmCodTransaccion)
      {
          $KsvmEditTransaccion = "SELECT * FROM ksvmvistadetalletransaccion WHERE TsnId = '$KsvmCodTransaccion'";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmEditTransaccion);
          $KsvmQuery->bindParam(":KsvmCodTransaccion", $KsvmCodTransaccion);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
     /**
      *Función que permite editar una Transaccion
      */
      protected function __KsvmCargarDataModelo($KsvmCodTransaccion)
      {
          $KsvmEditTransaccion = "SELECT * FROM ksvmvistadetalletransaccion WHERE DtsId = '$KsvmCodTransaccion'";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmEditTransaccion);
          $KsvmQuery->bindParam(":KsvmCodTransaccion", $KsvmCodTransaccion);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
       /**
      *Función que permite contar una transacción
      */
      protected function __KsvmContarTransaccionModelo($KsvmCodTransaccion)
      {
          $KsvmContarTransaccion = "SELECT TsnId FROM ksvmvistatransacciones WHERE TsnEstTran != 'X'";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmContarTransaccion);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
       /**
      *Función que permite actualizar una transacción
      */
      protected function __KsvmActualizarTransaccionModelo($KsvmDataTransaccion)
      {
        $KsvmActTransaccion = "UPDATE ksvmtransaccion16 SET RqcId = :KsvmReqId, TsnTipoTran = :KsvmTipoTran, TsnDestinoTran = :KsvmDestinoTran, 
                                      TsnFchRevTran = :KsvmFchRevTran, TsnPerRevTran = :KsvmPerRevTran, TsnObservTran = :KsvmObservTran 
                                      WHERE TsnId = :KsvmCodTransaccion";
        $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmActTransaccion);
        $KsvmQuery->bindParam(":KsvmRqcId", $KsvmDataTransaccion['KsvmRqcId']);
        $KsvmQuery->bindParam(":KsvmTipoTran", $KsvmDataTransaccion['KsvmTipoTran']);
        $KsvmQuery->bindParam(":KsvmDestinoTran", $KsvmDataTransaccion['KsvmDestinoTran']);
        $KsvmQuery->bindParam(":KsvmFchRevTran", $KsvmDataTransaccion['KsvmFchRevTran']);
        $KsvmQuery->bindParam(":KsvmPerRevTran", $KsvmDataTransaccion['KsvmPerRevTran']);
        $KsvmQuery->bindParam(":KsvmCodTransaccion", $KsvmDataTransaccion['KsvmCodTransaccion']);
        $KsvmQuery->execute();
        return $KsvmQuery;
      }
     /**
      *Función que permite actualizar un detalle de requisición
      */
      protected function __KsvmActualizarDetalleTransaccionModelo($KsvmDataTransaccion)
      {
        $KsvmActTransaccion = "UPDATE ksvmdetalletransaccion16 SET ExtId = :KsvmExtId, DtsCantTran = :KsvmCantTran, 
                                      DtsObservTran = :KsvmObservTran WHERE DtsId = :KsvmCodTransaccion";
        $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmActTransaccion);
        $KsvmQuery->bindParam(":KsvmExtId", $KsvmDataTransaccion['KsvmExtId']);
        $KsvmQuery->bindParam(":KsvmCantTran", $KsvmDataTransaccion['KsvmCantTran']);
        $KsvmQuery->bindParam(":KsvmObservTran", $KsvmDataTransaccion['KsvmObservTran']);
         $KsvmQuery->bindParam(":KsvmCodTransaccion", $KsvmDataTransaccion['KsvmCodTransaccion']);
         $KsvmQuery->execute();
         return $KsvmQuery;
      }

   }