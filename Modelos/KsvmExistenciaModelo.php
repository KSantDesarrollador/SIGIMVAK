<?php

  /**
   *Condicion para peticion Ajax
   */
   if ($KsvmPeticionAjax) {
       require_once "../Raiz/KsvmEstMaestra.php";
   } else {
       require_once "./Raiz/KsvmEstMaestra.php";
   }

   class KsvmExistenciaModelo extends KsvmEstMaestra
   {
     /**
      *Función que permite ingresar una existencia
      */
     protected function __KsvmAgregarExistenciaModelo($KsvmDataExistencia)
     {
         $KsvmIngExistencia = "INSERT INTO ksvmexistencias21(DocId, ExtLoteEx, ExtFchCadEx, ExtPresentEx, 
                                            ExtStockIniEx, ExtCodBarEx, ExtBinLocEx)
                                    VALUES(:KsvmDocId, :KsvmLoteEx, :KsvmFchCadEx, :KsvmPresentEx, 
                                           :KsvmStockIniEx, :KsvmCodBarEx, :KsvmBinLocEx)";
         $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmIngExistencia);
         $KsvmQuery->bindParam(":KsvmDocId", $KsvmDataExistencia['KsvmDocId']);
         $KsvmQuery->bindParam(":KsvmLoteEx", $KsvmDataExistencia['KsvmLoteEx']);
         $KsvmQuery->bindParam(":KsvmFchCadEx", $KsvmDataExistencia['KsvmFchCadEx']);
         $KsvmQuery->bindParam(":KsvmPresentEx", $KsvmDataExistencia['KsvmPresentEx']);
         $KsvmQuery->bindParam(":KsvmStockIniEx", $KsvmDataExistencia['KsvmStockIniEx']);
         $KsvmQuery->bindParam(":KsvmCodBarEx", $KsvmDataExistencia['KsvmCodBarEx']);
         $KsvmQuery->bindParam(":KsvmBinLocEx", $KsvmDataExistencia['KsvmBinLocEx']);
         $KsvmQuery->execute();
         return $KsvmQuery;
     }
          /**
      *Función que permite ingresar una existencia x bodega
      */
      protected function __KsvmAgregarBodegaModelo($KsvmDataExistencia)
      {
          $KsvmIngExistencia = "INSERT INTO ksvmexistenciaxbodega23(BdgId, ExtId, ExbStockEbo, ExbStockSegEbo)
                                     VALUES(:KsvmBdgId, :KsvmExtId, :KsvmStockEx, :KsvmStockSegEx)";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmIngExistencia);
          $KsvmQuery->bindParam(":KsvmBdgId", $KsvmDataExistencia['KsvmBdgId']);
          $KsvmQuery->bindParam(":KsvmExtId", $KsvmDataExistencia['KsvmExtId']);
          $KsvmQuery->bindParam(":KsvmStockEx", $KsvmDataExistencia['KsvmStockEx']);
          $KsvmQuery->bindParam(":KsvmStockSegEx", $KsvmDataExistencia['KsvmStockSegEx']);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
     /**
      *Función que permite inhabilitar una existencia
      */
      protected function __KsvmEliminarExistenciaModelo($KsvmCodExistencia)
      {
         $KsvmDelExistencia = "UPDATE ksvmexistencias21 SET ExtEstEx = 'X' WHERE RqcId = :KsvmCodExistencia";
         $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmDelExistencia);
         $KsvmQuery->bindParam(":KsvmCodExistencia", $KsvmCodExistencia);
         $KsvmQuery->execute();
         return $KsvmQuery;
      }
      /**
      *Función que permite editar una existencia
      */
      protected function __KsvmEditarExistenciaModelo($KsvmCodExistencia)
      {
          $KsvmEditExistencia = "SELECT * FROM ksvmvistaexistencias WHERE ExtId = :KsvmCodExistencia";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmEditExistencia);
          $KsvmQuery->bindParam(":KsvmCodExistencia", $KsvmCodExistencia);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
     /**
      *Función que permite contar una existencia
      */
      protected function __KsvmContarExistenciaModelo($KsvmCodExistencia)
      {
          $KsvmContarExistencia = "SELECT ExtId FROM ksvmvistaexistencias WHERE ExtEstEx = 'A'";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmContarExistencia);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
     /**
      *Función que permite imprimir una Existencia
      */
      protected function __KsvmImprimirExistenciaModelo()
      {
          $KsvmImprimirExistencia = "SELECT * FROM ksvmvistaexistencias";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->query($KsvmImprimirExistencia);
          return $KsvmQuery;
      }
       /**
      *Función que permite actualizar una existencia
      */
      protected function __KsvmActualizarExistenciaModelo($KsvmDataExistencia)
      {
        $KsvmActExistencia = "UPDATE ksvmexistencias21 SET DocId = :KsvmDocId, BdgId = :KsvmBdgId,  
                            ExtLoteEx = :KsvmLoteEx ,ExtFchCadEx = :KsvmFchCadEx, ExtPresentEx = :KsvmPresentEx, 
                            ExtStockIniEx = :KsvmStockIniEx, ExtStockEx = :KsvmStockEx, ExtStockSegEx = KsvmStockSegEx, 
                            ExtCodBarEx = KsvmCodBarEx, ExtBinLocEx = KsvmBinLocEx WHERE ExtId = :KsvmCodExistencia";
        $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmActExistencia);
        $KsvmQuery->bindParam(":KsvmDocId", $KsvmDataExistencia['KsvmDocId']);
        $KsvmQuery->bindParam(":KsvmBdgId", $KsvmDataExistencia['KsvmBdgId']);
        $KsvmQuery->bindParam(":KsvmLoteEx", $KsvmDataExistencia['KsvmLoteEx']);
        $KsvmQuery->bindParam(":KsvmFchCadEx", $KsvmDataExistencia['KsvmFchCadEx']);
        $KsvmQuery->bindParam(":KsvmPresentEx", $KsvmDataExistencia['KsvmPresentEx']);
        $KsvmQuery->bindParam(":KsvmStockIniEx", $KsvmDataExistencia['KsvmStockIniEx']);
        $KsvmQuery->bindParam(":KsvmStockEx", $KsvmDataExistencia['KsvmStockEx']);
        $KsvmQuery->bindParam(":KsvmStockSegEx", $KsvmDataExistencia['KsvmStockSegEx']);
        $KsvmQuery->bindParam(":KsvmCodBarEx", $KsvmDataExistencia['KsvmCodBarEx']);
        $KsvmQuery->bindParam(":KsvmBinLocEx", $KsvmDataExistencia['KsvmBinLocEx']);
        $KsvmQuery->bindParam(":KsvmCodExistencia", $KsvmDataExistencia['KsvmCodExistencia']);
        $KsvmQuery->execute();
        return $KsvmQuery;
      }

   }
