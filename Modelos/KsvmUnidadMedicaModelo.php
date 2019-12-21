<?php

  /**
   *Condicion para peticion Ajax
   */
   if ($KsvmPeticionAjax) {
       require_once "../Raiz/KsvmEstMaestra.php";
   } else {
       require_once "./Raiz/KsvmEstMaestra.php";
   }

   class KsvmUnidadMedicaModelo extends KsvmEstMaestra
   {
     /**
      *Función que permite ingresar una unidad médica
      */
     protected function __KsvmAgregarUnidadMedicaModelo($KsvmDataUnidadMedica)
     {
         $KsvmIngUnidadMedica = "INSERT INTO ksvmunidadmedica09(PrcId UmdIdentUdm, UmdNomUdm, UmdTelfUdm, UmdDirUdm, UmdEmailUdm)
                                             VALUES(:KsvmPrcId, :KsvmIdentUdm, :KsvmNomUdm, :KsvmTelfUdm, :KsvmDirUdm, :KsvmEmailUdm)";
         $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmIngUnidadMedica);
         $KsvmQuery->bindParam(":KsvmPrcId", $KsvmDataUnidadMedica['KsvmPrcId']);
         $KsvmQuery->bindParam(":KsvmIdentUdm", $KsvmDataUnidadMedica['KsvmIdentUdm']);
         $KsvmQuery->bindParam(":KsvmNomUdm", $KsvmDataUnidadMedica['KsvmNomUdm']);
         $KsvmQuery->bindParam(":KsvmTelfUdm", $KsvmDataUnidadMedica['KsvmTelfUdm']);
         $KsvmQuery->bindParam(":KsvmDirUdm", $KsvmDataUnidadMedica['KsvmDirUdm']);
         $KsvmQuery->bindParam(":KsvmEmailUdm", $KsvmDataUnidadMedica['KsvmEmailUdm']);
         $KsvmQuery->execute();
         return $KsvmQuery;
     }
     /**
      *Función que permite inhabilitar una unidad médica
      */
      protected function __KsvmEliminarUnidadMedicaModelo($KsvmCodUnidadMedica)
      {
         $KsvmDelUnidadMedica = "UPDATE ksvmunidadmedica09 SET UmdEstUdm = 'X' WHERE UmdId = :KsvmCodUnidadMedica";
         $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmDelUnidadMedica);
         $KsvmQuery->bindParam(":KsvmCodUnidadMedica", $KsvmCodUnidadMedica);
         $KsvmQuery->execute();
         return $KsvmQuery;
      }
      /**
      *Función que permite editar una unidad médica
      */
      protected function __KsvmEditarUnidadMedicaModelo($KsvmCodUnidadMedica)
      {
          $KsvmEditUnidadMedica = "SELECT * FROM ksvmvistaunidadesmedicas WHERE UmdId = :KsvmCodUnidadMedica";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmEditUnidadMedica);
          $KsvmQuery->bindParam(":KsvmCodUnidadMedica", $KsvmCodUnidadMedica);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
       /**
      *Función que permite contar una unidad médica
      */
      protected function __KsvmContarUnidadMedicaModelo($KsvmCodUnidadMedica)
      {
          $KsvmContarUnidadMedica = "SELECT UmdId FROM ksvmvistaunidadesmedicas WHERE UmdEstUdm = 'A'";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmContarUnidadMedica);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
     /**
      *Función que permite imprimir una unidad médica      
      */
      protected function __KsvmImprimirUnidadMedicaModelo()
      {
          $KsvmImprimirUnidadMedica = "SELECT * FROM ksvmvistaunidadesmedicas";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->query($KsvmImprimirUnidadMedica);
          return $KsvmQuery;
      }
       /**
      *Función que permite actualizar una unidad médica
      */
      protected function __KsvmActualizarUnidadMedicaModelo($KsvmDataUnidadMedica)
      {
        $KsvmActUnidadMedica = "UPDATE ksvmunidadmedica09 SET PrcId = :KsvmPrcId, UmdIdentUdm = :KsvmIdentUdm, UmdNomUdm = :KsvmNomUdm, 
                                    UmdTelfUdm = :KsvmTelfUdm, UmdDirUdm = :KsvmDirUdm, UmdEmailUdm = :KsvmEmailUdm
                                    WHERE UmdId = :KsvmCodUnidadMedica";
        $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmActUnidadMedica);
        $KsvmQuery->bindParam(":KsvmPrcId", $KsvmDataUnidadMedica['KsvmPrcId']);
        $KsvmQuery->bindParam(":KsvmIdentUdm", $KsvmDataUnidadMedica['KsvmIdentUdm']);
         $KsvmQuery->bindParam(":KsvmNomUdm", $KsvmDataUnidadMedica['KsvmNomUdm']);
         $KsvmQuery->bindParam(":KsvmTelfUdm", $KsvmDataUnidadMedica['KsvmTelfUdm']);
         $KsvmQuery->bindParam(":KsvmDirUdm", $KsvmDataUnidadMedica['KsvmDirUdm']);
         $KsvmQuery->bindParam(":KsvmEmailUdm", $KsvmDataUnidadMedica['KsvmEmailUdm']);
         $KsvmQuery->bindParam(":KsvmCodUnidadMedica", $KsvmDataUnidadMedica['KsvmCodUnidadMedica']);
         $KsvmQuery->execute();
         return $KsvmQuery;
      }

   }
