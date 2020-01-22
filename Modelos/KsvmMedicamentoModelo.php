<?php

  /**
   *Condicion para peticion Ajax
   */
   if ($KsvmPeticionAjax) {
       require_once "../Raiz/KsvmEstMaestra.php";
   } else {
       require_once "./Raiz/KsvmEstMaestra.php";
   }

   class KsvmMedicamentoModelo extends KsvmEstMaestra
   {
     /**
      *Función que permite ingresar un medicamento
      */
     protected function __KsvmAgregarMedicamentoModelo($KsvmDataMedicamento)
     {
         $KsvmIngMedicamento = "INSERT INTO ksvmmedicamentos07(CtgId, MdcCodMed, MdcDescMed, MdcPresenMed, MdcConcenMed, MdcNivPrescMed, 
                                            MdcNivAtencMed, MdcViaAdmMed, MdcFotoMed)
                                    VALUES(:KsvmCtgId, :KsvmCodMed, :KsvmDescMed, :KsvmPresenMed, :KsvmConcenMed, :KsvmNivPrescMed, 
                                            :KsvmNivAtencMed, :KsvmViaAdmMed, :KsvmFotoMed)";
         $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmIngMedicamento);
         $KsvmQuery->bindParam(":KsvmCtgId", $KsvmDataMedicamento['KsvmCtgId']);
         $KsvmQuery->bindParam(":KsvmCodMed", $KsvmDataMedicamento['KsvmCodMed']);
         $KsvmQuery->bindParam(":KsvmDescMed", $KsvmDataMedicamento['KsvmDescMed']);
         $KsvmQuery->bindParam(":KsvmPresenMed", $KsvmDataMedicamento['KsvmPresenMed']);
         $KsvmQuery->bindParam(":KsvmConcenMed", $KsvmDataMedicamento['KsvmConcenMed']);
         $KsvmQuery->bindParam(":KsvmNivPrescMed", $KsvmDataMedicamento['KsvmNivPrescMed']);
         $KsvmQuery->bindParam(":KsvmNivAtencMed", $KsvmDataMedicamento['KsvmNivAtencMed']);
         $KsvmQuery->bindParam(":KsvmViaAdmMed", $KsvmDataMedicamento['KsvmViaAdmMed']);
         $KsvmQuery->bindParam(":KsvmFotoMed", $KsvmDataMedicamento['KsvmFotoMed']);
         $KsvmQuery->execute();
         return $KsvmQuery;
     }
     /**
      *Función que permite inhabilitar un medicamento
      */
      protected function __KsvmEliminarMedicamentoModelo($KsvmCodMedicamento)
      {
         $KsvmDelMedicamento = "UPDATE ksvmmedicamentos07 SET MdcEstMed = 'X' WHERE MdcId = :KsvmCodMedicamento";
         $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmDelMedicamento);
         $KsvmQuery->bindParam(":KsvmCodMedicamento", $KsvmCodMedicamento);
         $KsvmQuery->execute();
         return $KsvmQuery;
      }
      /**
      *Función que permite editar un medicamento
      */
      protected function __KsvmEditarMedicamentoModelo($KsvmCodMedicamento)
      {
          $KsvmEditMedicamento = "SELECT * FROM ksvmvistamedicamentos WHERE MdcId = :KsvmCodMedicamento";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmEditMedicamento);
          $KsvmQuery->bindParam(":KsvmCodMedicamento", $KsvmCodMedicamento);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
       /**
      *Función que permite contar un medicamento
      */
      protected function __KsvmContarMedicamentoModelo($KsvmCodMedicamento)
      {
          $KsvmContarMedicamento = "SELECT MdcId FROM ksvmvistamedicamentos WHERE MdcEstMed = 'A'";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmContarMedicamento);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
     /**
      *Función que permite imprimir un Medicamento
      */
      protected function __KsvmImprimirMedicamentoModelo()
      {
          $KsvmImprimirMedicamento = "SELECT * FROM ksvmvistamedicamentos";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->query($KsvmImprimirMedicamento);
          return $KsvmQuery;
      }
       /**
      *Función que permite actualizar un medicamento
      */
      protected function __KsvmActualizarMedicamentoModelo($KsvmDataMedicamento)
      {
          if ($KsvmDataMedicamento['KsvmFotoMed'] != "") {
                $KsvmActMedicamento = "UPDATE ksvmmedicamentos07 SET CtgId = :KsvmCtgId, MdcCodMed = :KsvmCodMed, MdcDescMed = :KsvmDescMed,
                MdcPresenMed = :KsvmPresenMed, MdcConcenMed = :KsvmConcenMed, MdcNivPrescMed = :KsvmNivPrescMed,
                MdcNivAtencMed = :KsvmNivAtencMed, MdcViaAdmMed = :KsvmViaAdmMed, MdcFotoMed = :KsvmFotoMed
                WHERE MdcId = :KsvmCodMedicamento";
                $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmActMedicamento);
                $KsvmQuery->bindParam(":KsvmCtgId", $KsvmDataMedicamento['KsvmCtgId']);
                $KsvmQuery->bindParam(":KsvmCodMed", $KsvmDataMedicamento['KsvmCodMed']);
                $KsvmQuery->bindParam(":KsvmDescMed", $KsvmDataMedicamento['KsvmDescMed']);
                $KsvmQuery->bindParam(":KsvmPresenMed", $KsvmDataMedicamento['KsvmPresenMed']);
                $KsvmQuery->bindParam(":KsvmConcenMed", $KsvmDataMedicamento['KsvmConcenMed']);
                $KsvmQuery->bindParam(":KsvmNivPrescMed", $KsvmDataMedicamento['KsvmNivPrescMed']);
                $KsvmQuery->bindParam(":KsvmNivAtencMed", $KsvmDataMedicamento['KsvmNivAtencMed']);
                $KsvmQuery->bindParam(":KsvmViaAdmMed", $KsvmDataMedicamento['KsvmViaAdmMed']);
                $KsvmQuery->bindParam(":KsvmFotoMed", $KsvmDataMedicamento['KsvmFotoMed']);
                $KsvmQuery->bindParam(":KsvmCodMedicamento", $KsvmDataMedicamento['KsvmCodMedicamento']);
                $KsvmQuery->execute();
                return $KsvmQuery;
          } else {
          
                $KsvmActMedicamento = "UPDATE ksvmmedicamentos07 SET CtgId = :KsvmCtgId, MdcCodMed = :KsvmCodMed, MdcDescMed = :KsvmDescMed,
                                    MdcPresenMed = :KsvmPresenMed, MdcConcenMed = :KsvmConcenMed, MdcNivPrescMed = :KsvmNivPrescMed,
                                    MdcNivAtencMed = :KsvmNivAtencMed, MdcViaAdmMed = :KsvmViaAdmMed
                                    WHERE MdcId = :KsvmCodMedicamento";
                $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmActMedicamento);
                $KsvmQuery->bindParam(":KsvmCtgId", $KsvmDataMedicamento['KsvmCtgId']);
                $KsvmQuery->bindParam(":KsvmCodMed", $KsvmDataMedicamento['KsvmCodMed']);
                $KsvmQuery->bindParam(":KsvmDescMed", $KsvmDataMedicamento['KsvmDescMed']);
                $KsvmQuery->bindParam(":KsvmPresenMed", $KsvmDataMedicamento['KsvmPresenMed']);
                $KsvmQuery->bindParam(":KsvmConcenMed", $KsvmDataMedicamento['KsvmConcenMed']);
                $KsvmQuery->bindParam(":KsvmNivPrescMed", $KsvmDataMedicamento['KsvmNivPrescMed']);
                $KsvmQuery->bindParam(":KsvmNivAtencMed", $KsvmDataMedicamento['KsvmNivAtencMed']);
                $KsvmQuery->bindParam(":KsvmViaAdmMed", $KsvmDataMedicamento['KsvmViaAdmMed']);
                $KsvmQuery->bindParam(":KsvmCodMedicamento", $KsvmDataMedicamento['KsvmCodMedicamento']);
                $KsvmQuery->execute();
                return $KsvmQuery;
            }
        }

   }
