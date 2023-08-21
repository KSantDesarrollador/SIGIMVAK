<?php

  /**
   *Condicion para peticion Ajax
   */
   if ($KsvmPeticionAjax) {
       require_once "../Raiz/KsvmEstMaestra.php";
   } else {
       require_once "./Raiz/KsvmEstMaestra.php";
   }

   class KsvmPreciosXProveedorModelo extends KsvmEstMaestra
   {
     /**
      *Función que permite ingresar un Precio
      */
     protected function __KsvmAgregarPreciosXProveedorModelo($KsvmDataPrecios)
     {
         $KsvmIngPrecio = "INSERT INTO ksvmpreciosprov24(PvdId, MdcId, PprValorUntPre)
                                    VALUES(:KsvmPvdId, :KsvmMdcId, :KsvmValorUntPre)";
         $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmIngPrecio);
         $KsvmQuery->bindParam(":KsvmPvdId", $KsvmDataPrecios['KsvmPvdId']);
         $KsvmQuery->bindParam(":KsvmMdcId", $KsvmDataPrecios['KsvmMdcId']);
         $KsvmQuery->bindParam(":KsvmValorUntPre", $KsvmDataPrecios['KsvmValorUntPre']);
         $KsvmQuery->execute();
         return $KsvmQuery;
     }
     /**
      *Función que permite eliminar un Precio
      */
      protected function __KsvmEliminarPreciosXProveedorModelo($KsvmCodPrecio)
      {
         $KsvmDelParametros = "DELETE FROM ksvmpreciosprov24 WHERE PprId = :KsvmCodPrecio";
         $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmDelParametros);
         $KsvmQuery->bindParam(":KsvmCodPrecio", $KsvmCodPrecio);
         $KsvmQuery->execute();
         return $KsvmQuery;
      }
      /**
      *Función que permite editar un Precio
      */
      protected function __KsvmEditarPreciosXProveedorModelo($KsvmCodPrecio)
      {
          $KsvmEditParametros = "SELECT * FROM ksvmvistapreciosprov WHERE PprId = :KsvmCodPrecio";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmEditParametros);
          $KsvmQuery->bindParam(":KsvmCodPrecio", $KsvmCodPrecio);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
       /**
      *Función que permite contar un Precio
      */
      protected function __KsvmContarPreciosXProveedorModelo($KsvmCodPrecio)
      {
          $KsvmContarPrecios = "SELECT PprId FROM ksvmpreciosprov24";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmContarPrecios);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
     /**
      *Función que permite imprimir un Precio
      */
      protected function __KsvmImprimirPreciosXProveedorModelo()
      {
          $KsvmImprimirPrecios = "SELECT * FROM ksvmvistapreciosprov";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->query($KsvmImprimirPrecios);
          return $KsvmQuery;
      }
       /**
      *Función que permite actualizar un Precio
      */
      protected function __KsvmActualizarPreciosXProveedorModelo($KsvmDataPrecios)
      {
        $KsvmActPrecios = "UPDATE ksvmpreciosprov24 SET PvdId = :KsvmPvdId, MdcId = :KsvmMdcId, PprValorUntPre = :KsvmValorUntPre
                                  WHERE PprId = :KsvmCodPrecio";
        $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmActPrecios);
        $KsvmQuery->bindParam(":KsvmPvdId", $KsvmDataPrecios['KsvmPvdId']);
        $KsvmQuery->bindParam(":KsvmMdcId", $KsvmDataPrecios['KsvmMdcId']);
        $KsvmQuery->bindParam(":KsvmValorUntPre", $KsvmDataPrecios['KsvmValorUntPre']);
        $KsvmQuery->bindParam(":KsvmCodPrecio", $KsvmDataPrecios['KsvmCodPrecio']);
        $KsvmQuery->execute();
        return $KsvmQuery;
      }

   }
