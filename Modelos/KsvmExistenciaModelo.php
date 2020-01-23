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
         $KsvmIngExistencia = "INSERT INTO ksvmexistencias21(DocId, ExtLoteEx, ExtFchCadEx, 
                                            ExtStockIniEx, ExtStockSegEx, ExtCodBarEx, ExtBinLocEx)
                                    VALUES(:KsvmDocId, :KsvmLoteEx, :KsvmFchCadEx, 
                                           :KsvmStockIniEx, :KsvmStockSegEx, :KsvmCodBarEx, :KsvmBinLocEx)";
         $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmIngExistencia);
         $KsvmQuery->bindParam(":KsvmDocId", $KsvmDataExistencia['KsvmDocId']);
         $KsvmQuery->bindParam(":KsvmLoteEx", $KsvmDataExistencia['KsvmLoteEx']);
         $KsvmQuery->bindParam(":KsvmFchCadEx", $KsvmDataExistencia['KsvmFchCadEx']);
         $KsvmQuery->bindParam(":KsvmStockIniEx", $KsvmDataExistencia['KsvmStockIniEx']);
         $KsvmQuery->bindParam(":KsvmStockSegEx", $KsvmDataExistencia['KsvmStockSegEx']);
         $KsvmQuery->bindParam(":KsvmCodBarEx", $KsvmDataExistencia['KsvmCodBarEx']);
         $KsvmQuery->bindParam(":KsvmBinLocEx", $KsvmDataExistencia['KsvmBinLocEx']);
         $KsvmQuery->execute();
         return $KsvmQuery;
     }
     /**
      *Función que permite inhabilitar una existencia
      */
      protected function __KsvmEliminarExistenciaModelo($KsvmCodExistencia)
      {
         $KsvmDelExistencia = "DELETE FROM ksvmexistencias21 WHERE ExtId = :KsvmCodExistencia";
         $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmDelExistencia);
         $KsvmQuery->bindParam(":KsvmCodExistencia", $KsvmCodExistencia);
         $KsvmQuery->execute();
         return $KsvmQuery;
      }
      /**
      *Función que permite editar una existencia
      */
      protected function __KsvmEditarDetalleExistenciaModelo($KsvmCodExistencia, $KsvmUsuario, $KsvmRol)
      {
        if ($KsvmRol = "Administrador" || $KsvmRol = "Supervisor"  || $KsvmRol = "Tecnico" ) {
            $KsvmEditExistencia = "SELECT * FROM ksvmvistaexistencias  WHERE ExtId = :KsvmCodExistencia AND UsrId = :KsvmUsuario AND BdgId = 5";
            $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmEditExistencia);
            $KsvmQuery->bindParam(":KsvmCodExistencia", $KsvmCodExistencia);
            $KsvmQuery->bindParam(":KsvmUsuario", $KsvmUsuario);
            $KsvmQuery->execute();
          } else {
            $KsvmEditExistencia = "SELECT * FROM ksvmvistaexistencias  WHERE ExtId = :KsvmCodExistencia AND UsrId = :KsvmUsuario";
            $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmEditExistencia);
            $KsvmQuery->bindParam(":KsvmCodExistencia", $KsvmCodExistencia);
            $KsvmQuery->bindParam(":KsvmUsuario", $KsvmUsuario);
            $KsvmQuery->execute();
          }
          return $KsvmQuery;

      }
     /**
      *Función que permite editar una existencia
      */
      protected function __KsvmEditarExistenciaModelo($KsvmCodExistencia)
      {
          $KsvmEditExistencia = "SELECT DISTINCT ExtId, MdcDescMed, MdcConcenMed, ExtLoteEx, ExtFchCadEx, ExtBinLocEx, ExtCodBarEx, ExtEstEx,
          BdgDescBod FROM ksvmvistaexistencias WHERE ExtId = :KsvmCodExistencia";
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
      *Función que permite mostar una existencia
      */
      protected function __KsvmMostrarExistenciaModelo()
      {
          $KsvmContarExistencia = "SELECT * FROM ksvmvistaexistencias WHERE (AltNomAle = 'Alto' OR AltNomAle = 'Critico') AND ExtEstEx = 'A'";
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
        $KsvmActExistencia = "UPDATE ksvmexistencias21 SET DocId = :KsvmDocId, ExtLoteEx = :KsvmLoteEx, ExtFchCadEx = :KsvmFchCadEx, 
                            ExtStockIniEx = :KsvmStockIniEx, ExtStockSegEx = :KsvmStockSegEx, 
                            ExtCodBarEx = :KsvmCodBarEx, ExtBinLocEx = :KsvmBinLocEx WHERE ExtId = :KsvmCodExistencia";
        $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmActExistencia);
        $KsvmQuery->bindParam(":KsvmDocId", $KsvmDataExistencia['KsvmDocId']);
        $KsvmQuery->bindParam(":KsvmLoteEx", $KsvmDataExistencia['KsvmLoteEx']);
        $KsvmQuery->bindParam(":KsvmFchCadEx", $KsvmDataExistencia['KsvmFchCadEx']);
        $KsvmQuery->bindParam(":KsvmStockIniEx", $KsvmDataExistencia['KsvmStockIniEx']);
        $KsvmQuery->bindParam(":KsvmStockSegEx", $KsvmDataExistencia['KsvmStockSegEx']);
        $KsvmQuery->bindParam(":KsvmCodBarEx", $KsvmDataExistencia['KsvmCodBarEx']);
        $KsvmQuery->bindParam(":KsvmBinLocEx", $KsvmDataExistencia['KsvmBinLocEx']);
        $KsvmQuery->bindParam(":KsvmCodExistencia", $KsvmDataExistencia['KsvmCodExistencia']);
        $KsvmQuery->execute();
        return $KsvmQuery;
      }

   }
