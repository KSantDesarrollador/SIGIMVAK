<?php

  /**
   *Condicion para peticion Ajax
   */
   if ($KsvmPeticionAjax) {
       require_once "../Raiz/KsvmEstMaestra.php";
   } else {
       require_once "./Raiz/KsvmEstMaestra.php";
   }

   class KsvmProcedenciaModelo extends KsvmEstMaestra
   {
     /**
      *Función que permite ingresar una procedencia
      */
     protected function __KsvmAgregarProcedenciaModelo($KsvmDataProcedencia)
     {
         $KsvmIngProcedencia = "INSERT INTO ksvmprocedencia06(PrcJerqProc, PrcCodProc, PrcNomProc, PrcNivProc, PrcDescProc)
                                    VALUES(:KsvmJerqProc, :KsvmCodProc, :KsvmNomProc, :KsvmNivProc, :KsvmDescProc)";
         $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmIngProcedencia);
         $KsvmQuery->bindParam(":KsvmJerqProc", $KsvmDataProcedencia['KsvmJerqProc']);
         $KsvmQuery->bindParam(":KsvmCodProc", $KsvmDataProcedencia['KsvmCodProc']);
         $KsvmQuery->bindParam(":KsvmNomProc", $KsvmDataProcedencia['KsvmNomProc']);
         $KsvmQuery->bindParam(":KsvmNivProc", $KsvmDataProcedencia['KsvmNivProc']);
         $KsvmQuery->bindParam(":KsvmDescProc", $KsvmDataProcedencia['KsvmDescProc']);
         $KsvmQuery->execute();
         return $KsvmQuery;
     }
     /**
      *Función que permite inhabilitar una procedencia
      */
      protected function __KsvmEliminarProcedenciaModelo($KsvmCodProcedencia)
      {
         $KsvmDelProcedencia = "UPDATE ksvmprocedencia06 SET PrcEstProc = 'X' WHERE PrcId = :KsvmCodProcedencia";
         $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmDelProcedencia);
         $KsvmQuery->bindParam(":KsvmCodProcedencia", $KsvmCodProcedencia);
         $KsvmQuery->execute();
         return $KsvmQuery;
      }
      /**
      *Función que permite editar una procedencia
      */
      protected function __KsvmEditarProcedenciaModelo($KsvmCodProcedencia)
      {
          $KsvmEditProcedencia = "SELECT * FROM ksvmprocedencia06 WHERE PrcId = :KsvmCodProcedencia";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmEditProcedencia);
          $KsvmQuery->bindParam(":KsvmCodProcedencia", $KsvmCodProcedencia);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
       /**
      *Función que permite contar una procedencia
      */
      protected function __KsvmContarProcedenciaModelo($KsvmCodProcedencia)
      {
          $KsvmContarProcedencia = "SELECT PrcId FROM ksvmprocedencia06 WHERE PrcEstProc = 'A'";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmContarProcedencia);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
       /**
      *Función que permite actualizar una procedencia
      */
      protected function __KsvmActualizarProcedenciaModelo($KsvmDataProcedencia)
      {
        $KsvmActProcedencia = "UPDATE ksvmprocedencia06 SET PrcJerqProc = :KsvmJerqProc, PrcCodProc = :KsvmCodProc, PrcNomProc = :KsvmNomProc,
                            PrcNivProc = :KsvmNivProc, PrcDescProc = :KsvmDescProc 
                            WHERE PrcId = :KsvmCodProcedencia";
        $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmActProcedencia);
        $KsvmQuery->bindParam(":KsvmJerqProc", $KsvmDataProcedencia['KsvmJerqProc']);
         $KsvmQuery->bindParam(":KsvmCodProc", $KsvmDataProcedencia['KsvmCodProc']);
         $KsvmQuery->bindParam(":KsvmNomProc", $KsvmDataProcedencia['KsvmNomProc']);
         $KsvmQuery->bindParam(":KsvmNivProc", $KsvmDataProcedencia['KsvmNivProc']);
         $KsvmQuery->bindParam(":KsvmDescProc", $KsvmDataProcedencia['KsvmDescProc']);
         $KsvmQuery->bindParam(":KsvmCodProcedencia", $KsvmDataProcedencia['KsvmCodProcedencia']);
         $KsvmQuery->execute();
         return $KsvmQuery;
      }

   }
