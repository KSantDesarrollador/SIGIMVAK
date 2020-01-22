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
         if ($KsvmDataTransaccion['KsvmRqcId'] != "") {
            $KsvmIngTransaccion = "INSERT INTO ksvmtransaccion16(RqcId, TsnNumTran, TsnTipoTran, TsnDestinoTran, TsnFchReaTran, TsnPerReaTran, TsnFchRevTran, 
                                    TsnPerRevTran, UsrId)
                                    VALUES(:KsvmRqcId, :KsvmNumTran, :KsvmTipoTran, :KsvmDestinoTran, :KsvmFchReaTran, :KsvmPerReaTran, :KsvmFchRevTran, 
                                    :KsvmPerRevTran, :KsvmUsrId)";
            $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmIngTransaccion);
            $KsvmQuery->bindParam(":KsvmRqcId", $KsvmDataTransaccion['KsvmRqcId']);
            $KsvmQuery->bindParam(":KsvmNumTran", $KsvmDataTransaccion['KsvmNumTran']);
            $KsvmQuery->bindParam(":KsvmTipoTran", $KsvmDataTransaccion['KsvmTipoTran']);
            $KsvmQuery->bindParam(":KsvmDestinoTran", $KsvmDataTransaccion['KsvmDestinoTran']);
            $KsvmQuery->bindParam(":KsvmFchReaTran", $KsvmDataTransaccion['KsvmFchReaTran']);
            $KsvmQuery->bindParam(":KsvmPerReaTran", $KsvmDataTransaccion['KsvmPerReaTran']);
            $KsvmQuery->bindParam(":KsvmFchRevTran", $KsvmDataTransaccion['KsvmFchRevTran']);
            $KsvmQuery->bindParam(":KsvmPerRevTran", $KsvmDataTransaccion['KsvmPerRevTran']);
            $KsvmQuery->bindParam(":KsvmUsrId", $KsvmDataTransaccion['KsvmUsrId']);
            $KsvmQuery->execute();
            return $KsvmQuery;
         } else {
            $KsvmIngTransaccion = "INSERT INTO ksvmtransaccion16(TsnNumTran, TsnTipoTran, TsnDestinoTran, TsnFchReaTran, TsnPerReaTran, TsnFchRevTran, 
                                    TsnPerRevTran, UsrId)
                                    VALUES(:KsvmNumTran, :KsvmTipoTran, :KsvmDestinoTran, :KsvmFchReaTran, :KsvmPerReaTran, :KsvmFchRevTran, 
                                    :KsvmPerRevTran, :KsvmUsrId)";
            $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmIngTransaccion);
            $KsvmQuery->bindParam(":KsvmNumTran", $KsvmDataTransaccion['KsvmNumTran']);
            $KsvmQuery->bindParam(":KsvmTipoTran", $KsvmDataTransaccion['KsvmTipoTran']);
            $KsvmQuery->bindParam(":KsvmDestinoTran", $KsvmDataTransaccion['KsvmDestinoTran']);
            $KsvmQuery->bindParam(":KsvmFchReaTran", $KsvmDataTransaccion['KsvmFchReaTran']);
            $KsvmQuery->bindParam(":KsvmPerReaTran", $KsvmDataTransaccion['KsvmPerReaTran']);
            $KsvmQuery->bindParam(":KsvmFchRevTran", $KsvmDataTransaccion['KsvmFchRevTran']);
            $KsvmQuery->bindParam(":KsvmPerRevTran", $KsvmDataTransaccion['KsvmPerRevTran']);
            $KsvmQuery->bindParam(":KsvmUsrId", $KsvmDataTransaccion['KsvmUsrId']);
            $KsvmQuery->execute();
            return $KsvmQuery;
         }
         

     }
     /**
      *Función que permite ingresar un detalle de transacción
      */
      protected function __KsvmAgregarDetalleTransaccionModelo($KsvmDataTransaccion)
      {
          $KsvmIngTransaccion = "INSERT INTO ksvmdetalletransaccion16(ExtId, BdgId, DtsCantTran, DtsTipoTran, DtsObservTran)
                                     VALUES(:KsvmExtId, :KsvmBdgId, :KsvmCantTran, :KsvmTipoTran, :KsvmObservTran)";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmIngTransaccion);
          $KsvmQuery->bindParam(":KsvmExtId", $KsvmDataTransaccion['KsvmExtId']);
          $KsvmQuery->bindParam(":KsvmBdgId", $KsvmDataTransaccion['KsvmBdgId']);
          $KsvmQuery->bindParam(":KsvmCantTran", $KsvmDataTransaccion['KsvmCantTran']);
          $KsvmQuery->bindParam(":KsvmTipoTran", $KsvmDataTransaccion['KsvmTipoTran']);
          $KsvmQuery->bindParam(":KsvmObservTran", $KsvmDataTransaccion['KsvmObservTran']);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
     /**
      *Función que permite inhabilitar una transacción
      */
      protected function __KsvmEliminarTransaccionModelo($KsvmCodTransaccion)
      {
         $KsvmDelTransaccion = "UPDATE ksvmtransaccion16 SET TsnEstTran = 'I' WHERE TsnId = :KsvmCodTransaccion";
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
      *Función que permite editar detalle de Transaccion
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
      protected function __KsvmContarIngresosModelo()
      {
          $KsvmContarTransaccion = "SELECT TsnId FROM ksvmvistatransacciones WHERE TsnEstTran != 'X' AND TsnTipoTran = 'Ingreso'";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmContarTransaccion);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
     /**
      *Función que permite contar una transacción
      */
      protected function __KsvmContarIngresosSuperModelo()
      {
          $KsvmContarTransaccion = "SELECT TsnId FROM ksvmvistatransacciones WHERE TsnEstTran = 'P' AND TsnTipoTran = 'Ingreso'";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmContarTransaccion);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
     /**
      *Función que permite contar una transacción
      */
      protected function __KsvmContarIngresosTecniModelo()
      {
          $KsvmContarTransaccion = "SELECT TsnId FROM ksvmvistatransacciones WHERE TsnEstTran = 'A' AND TsnTipoTran = 'Ingreso'";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmContarTransaccion);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
     /**
      *Función que permite contar una transacción
      */
      protected function __KsvmContarEgresosModelo()
      {
          $KsvmContarTransaccion = "SELECT TsnId FROM ksvmvistatransacciones WHERE TsnEstTran != 'X' AND TsnTipoTran = 'Egreso'";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmContarTransaccion);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
     /**
      *Función que permite contar una transacción
      */
      protected function __KsvmContarEgresosSuperModelo()
      {
          $KsvmContarTransaccion = "SELECT TsnId FROM ksvmvistatransacciones WHERE TsnEstTran = 'P' AND TsnTipoTran = 'Egreso'";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmContarTransaccion);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
     /**
      *Función que permite contar una transacción
      */
      protected function __KsvmContarEgresosTecniModelo()
      {
          $KsvmContarTransaccion = "SELECT TsnId FROM ksvmvistatransacciones WHERE TsnEstTran = 'A' AND TsnTipoTran = 'Egreso'";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmContarTransaccion);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
     /**
      *Función que permite imprimir una Transaccion      
      */
      protected function __KsvmImprimirTransaccionModelo()
      {
          $KsvmImprimirTransaccion = "SELECT * FROM ksvmvistatransacciones";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->query($KsvmImprimirTransaccion);
          return $KsvmQuery;
      }
     /**
      *Función que permite imprimir una Transaccion      
      */
      protected function __KsvmImprimirTransaccionesModelo($KsvmTipo)
      {
          $KsvmImprimirTransaccion = "SELECT * FROM ksvmvistatransacciones WHERE TsnTipoTran = '$KsvmTipo'";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->query($KsvmImprimirTransaccion);
          return $KsvmQuery;
      }
       /**
      *Función que permite actualizar una transacción
      */
      protected function __KsvmActualizarTransaccionModelo($KsvmDataTransaccion)
      {
        $KsvmActTransaccion = "UPDATE ksvmtransaccion16 SET RqcId = :KsvmRqcId, TsnTipoTran = :KsvmTipoTran, TsnDestinoTran = :KsvmDestinoTran, 
                                      TsnFchRevTran = :KsvmFchRevTran, TsnPerRevTran = :KsvmPerRevTran, UsrId = :KsvmUsrId, TsnEstTran = :KsvmEstTran 
                                      WHERE TsnId = :KsvmCodTransaccion";
        $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmActTransaccion);
        $KsvmQuery->bindParam(":KsvmRqcId", $KsvmDataTransaccion['KsvmRqcId']);
        $KsvmQuery->bindParam(":KsvmTipoTran", $KsvmDataTransaccion['KsvmTipoTran']);
        $KsvmQuery->bindParam(":KsvmDestinoTran", $KsvmDataTransaccion['KsvmDestinoTran']);
        $KsvmQuery->bindParam(":KsvmFchRevTran", $KsvmDataTransaccion['KsvmFchRevTran']);
        $KsvmQuery->bindParam(":KsvmPerRevTran", $KsvmDataTransaccion['KsvmPerRevTran']);
        $KsvmQuery->bindParam(":KsvmUsrId", $KsvmDataTransaccion['KsvmUsrId']);
        $KsvmQuery->bindParam(":KsvmEstTran", $KsvmDataTransaccion['KsvmEstTran']);
        $KsvmQuery->bindParam(":KsvmCodTransaccion", $KsvmDataTransaccion['KsvmCodTransaccion']);
        $KsvmQuery->execute();
        return $KsvmQuery;
      }
     /**
      *Función que permite actualizar un detalle de requisición
      */
      protected function __KsvmActualizarDetalleTransaccionModelo($KsvmDataTransaccion)
      {
        $KsvmActTransaccion = "UPDATE ksvmdetalletransaccion16 SET ExtId = :KsvmExtId, DtsCantTran = :KsvmCantTran, DtsTipoTran = :KsvmTipoTran,
                                      DtsObservTran = :KsvmObservTran WHERE DtsId = :KsvmCodTransaccion";
        $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmActTransaccion);
        $KsvmQuery->bindParam(":KsvmExtId", $KsvmDataTransaccion['KsvmExtId']);
        $KsvmQuery->bindParam(":KsvmCantTran", $KsvmDataTransaccion['KsvmCantTran']);
        $KsvmQuery->bindParam(":KsvmTipoTran", $KsvmDataTransaccion['KsvmTipoTran']);
        $KsvmQuery->bindParam(":KsvmObservTran", $KsvmDataTransaccion['KsvmObservTran']);
         $KsvmQuery->bindParam(":KsvmCodTransaccion", $KsvmDataTransaccion['KsvmCodTransaccion']);
         $KsvmQuery->execute();
         return $KsvmQuery;
      }

   }
