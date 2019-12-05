<?php

  /**
   *Condicion para peticion Ajax
   */
   if ($KsvmPeticionAjax) {
       require_once "../Raiz/KsvmEstMaestra.php";
   } else {
       require_once "./Raiz/KsvmEstMaestra.php";
   }

   class KsvmProveedorModelo extends KsvmEstMaestra
   {
     /**
      *Función que permite ingresar un proveedor
      */
     protected function __KsvmAgregarProveedorModelo($KsvmDataProveedor)
     {
         $KsvmIngProveedor = "INSERT INTO ksvmproveedor04(PrcId, PvdTipProv, PvdIdentProv, PvdRazSocProv, PvdTelfProv, PvdDirProv, PvdEmailProv,
                                            PvdPerContProv, PvdCarContProv)
                                    VALUES(:KsvmPrcId, :KsvmTipProv, :KsvmIdentProv, :KsvmRazSocProv, :KsvmTelfProv, :KsvmDirProv, 
                                            :KsvmEmailProv, :KsvmPerContProv, :KsvmCarContProv)";
         $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmIngProveedor);
         $KsvmQuery->bindParam(":KsvmPrcId", $KsvmDataProveedor['KsvmPrcId']);
         $KsvmQuery->bindParam(":KsvmTipProv", $KsvmDataProveedor['KsvmTipProv']);
         $KsvmQuery->bindParam(":KsvmIdentProv", $KsvmDataProveedor['KsvmIdentProv']);
         $KsvmQuery->bindParam(":KsvmRazSocProv", $KsvmDataProveedor['KsvmRazSocProv']);
         $KsvmQuery->bindParam(":KsvmTelfProv", $KsvmDataProveedor['KsvmTelfProv']);
         $KsvmQuery->bindParam(":KsvmDirProv", $KsvmDataProveedor['KsvmDirProv']);
         $KsvmQuery->bindParam(":KsvmEmailProv", $KsvmDataProveedor['KsvmEmailProv']);
         $KsvmQuery->bindParam(":KsvmPerContProv", $KsvmDataProveedor['KsvmPerContProv']);
         $KsvmQuery->bindParam(":KsvmCarContProv", $KsvmDataProveedor['KsvmCarContProv']);
         $KsvmQuery->execute();
         return $KsvmQuery;
     }
     /**
      *Función que permite inhabilitar un proveedor
      */
      protected function __KsvmEliminarProveedorModelo($KsvmCodProveedor)
      {
         $KsvmDelProveedor = "UPDATE ksvmproveedor04 SET PvdEstProv = 'X' WHERE PvdId = :KsvmCodProveedor";
         $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmDelProveedor);
         $KsvmQuery->bindParam(":KsvmCodProveedor", $KsvmCodProveedor);
         $KsvmQuery->execute();
         return $KsvmQuery;
      }
      /**
      *Función que permite editar un proveedor
      */
      protected function __KsvmEditarProveedorModelo($KsvmCodProveedor)
      {
          $KsvmEditProveedor = "SELECT * FROM ksvmvistaproveedores WHERE PvdId = :KsvmCodProveedor";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmEditProveedor);
          $KsvmQuery->bindParam(":KsvmCodProveedor", $KsvmCodProveedor);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
       /**
      *Función que permite contar un proveedor
      */
      protected function __KsvmContarProveedorModelo($KsvmCodProveedor)
      {
          $KsvmContarProveedor = "SELECT PvdId FROM ksvmvistaproveedores WHERE PvdEstProv = 'A'";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmContarProveedor);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
       /**
      *Función que permite actualizar un proveedor
      */
      protected function __KsvmActualizarProveedorModelo($KsvmDataProveedor)
      {
        $KsvmActProveedor = "UPDATE ksvmproveedor04 SET PrcId = :KsvmPrcId, PvdTipProv = :KsvmTipProv, PvdIdentProv = :KsvmIdentProv,
                            PvdRazSocProv = :KsvmRazSocProv, PvdTelfProv = :KsvmTelfProv, PvdDirProv = :KsvmDirProv,
                            PvdEmailprov = :KsvmEmailProv, PvdPerContProv = :KsvmPerContProv, PvdCarContProv = :KsvmCarContProv
                            WHERE PvdId = :KsvmCodProveedor";
        $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmActProveedor);
        $KsvmQuery->bindParam(":KsvmPrcId", $KsvmDataProveedor['KsvmPrcId']);
         $KsvmQuery->bindParam(":KsvmTipProv", $KsvmDataProveedor['KsvmTipProv']);
         $KsvmQuery->bindParam(":KsvmIdentProv", $KsvmDataProveedor['KsvmIdentProv']);
         $KsvmQuery->bindParam(":KsvmRazSocProv", $KsvmDataProveedor['KsvmRazSocProv']);
         $KsvmQuery->bindParam(":KsvmTelfProv", $KsvmDataProveedor['KsvmTelfProv']);
         $KsvmQuery->bindParam(":KsvmDirProv", $KsvmDataProveedor['KsvmDirProv']);
         $KsvmQuery->bindParam(":KsvmEmailProv", $KsvmDataProveedor['KsvmEmailProv']);
         $KsvmQuery->bindParam(":KsvmPerContProv", $KsvmDataProveedor['KsvmPerContProv']);
         $KsvmQuery->bindParam(":KsvmCarContProv", $KsvmDataProveedor['KsvmCarContProv']);
         $KsvmQuery->bindParam(":KsvmCodProveedor", $KsvmDataProveedor['KsvmCodProveedor']);
         $KsvmQuery->execute();
         return $KsvmQuery;
      }

   }
