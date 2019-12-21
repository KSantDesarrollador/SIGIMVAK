<?php

  /**
   *Condicion para peticion Ajax
   */
   if ($KsvmPeticionAjax) {
       require_once "../Raiz/KsvmEstMaestra.php";
   } else {
       require_once "./Raiz/KsvmEstMaestra.php";
   }

   class KsvmEmpleadoModelo extends KsvmEstMaestra
   {
     /**
      *Función que permite ingresar un empleado
      */
     protected function __KsvmAgregarEmpleadoModelo($KsvmDataEmpleado)
     {
         $KsvmIngEmpleado = "INSERT INTO ksvmempleado03(CrgId, PrcId, RrlId, EpoTipIdentEmp, EpoIdentEmp, EpoPriApeEmp, EpoSegApeEmp, EpoPriNomEmp,
                                            EpoSegNomEmp, EpoTelfEmp, EpoDirEmp, EpoFchNacEmp, EpoEmailEmp, EpoSexoEmp, EpoGeneroEmp, EpoEstCivEmp, EpoFotoEmp)
                                    VALUES(:KsvmCrgId, :KsvmPrcId, :KsvmRrlId, :KsvmEpoTipIdentEmp, :KsvmEpoIdentEmp, :KsvmEpoPriApeEmp, :KsvmEpoSegApeEmp, 
                                            :KsvmEpoPriNomEmp, :KsvmEpoSegNomEmp, :KsvmEpoTelfEmp, :KsvmEpoDirEmp, :KsvmEpoFchNacEmp, :KsvmEpoEmailEmp, 
                                            :KsvmEpoSexoEmp, :KsvmEpoGeneroEmp, :KsvmEpoEstCivEmp, :KsvmFotoEmp)";
         $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmIngEmpleado);
         $KsvmQuery->bindParam(":KsvmCrgId", $KsvmDataEmpleado['KsvmCrgId']);
         $KsvmQuery->bindParam(":KsvmPrcId", $KsvmDataEmpleado['KsvmPrcId']);
         $KsvmQuery->bindParam(":KsvmRrlId", $KsvmDataEmpleado['KsvmRrlId']);
         $KsvmQuery->bindParam(":KsvmEpoTipIdentEmp", $KsvmDataEmpleado['KsvmEpoTipIdentEmp']);
         $KsvmQuery->bindParam(":KsvmEpoIdentEmp", $KsvmDataEmpleado['KsvmEpoIdentEmp']);
         $KsvmQuery->bindParam(":KsvmEpoPriApeEmp", $KsvmDataEmpleado['KsvmEpoPriApeEmp']);
         $KsvmQuery->bindParam(":KsvmEpoSegApeEmp", $KsvmDataEmpleado['KsvmEpoSegApeEmp']);
         $KsvmQuery->bindParam(":KsvmEpoPriNomEmp", $KsvmDataEmpleado['KsvmEpoPriNomEmp']);
         $KsvmQuery->bindParam(":KsvmEpoSegNomEmp", $KsvmDataEmpleado['KsvmEpoSegNomEmp']);
         $KsvmQuery->bindParam(":KsvmEpoTelfEmp", $KsvmDataEmpleado['KsvmEpoTelfEmp']);
         $KsvmQuery->bindParam(":KsvmEpoDirEmp", $KsvmDataEmpleado['KsvmEpoDirEmp']);
         $KsvmQuery->bindParam(":KsvmEpoFchNacEmp", $KsvmDataEmpleado['KsvmEpoFchNacEmp']);
         $KsvmQuery->bindParam(":KsvmEpoEmailEmp", $KsvmDataEmpleado['KsvmEpoEmailEmp']);
         $KsvmQuery->bindParam(":KsvmEpoSexoEmp", $KsvmDataEmpleado['KsvmEpoSexoEmp']);
         $KsvmQuery->bindParam(":KsvmEpoGeneroEmp", $KsvmDataEmpleado['KsvmEpoGeneroEmp']);
         $KsvmQuery->bindParam(":KsvmEpoEstCivEmp", $KsvmDataEmpleado['KsvmEpoEstCivEmp']);
         $KsvmQuery->bindParam(":KsvmFotoEmp", $KsvmDataEmpleado['KsvmFotoEmp']);
         $KsvmQuery->execute();
         return $KsvmQuery;
     }
     /**
      *Función que permite inhabilitar un empleado
      */
      protected function __KsvmEliminarEmpleadoModelo($KsvmCodEmpleado)
      {
         $KsvmDelEmpleado = "UPDATE ksvmempleado03 SET EpoEstEmp = 'X' WHERE EpoId = :KsvmCodEmpleado";
         $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmDelEmpleado);
         $KsvmQuery->bindParam(":KsvmCodEmpleado", $KsvmCodEmpleado);
         $KsvmQuery->execute();
         return $KsvmQuery;
      }
      /**
      *Función que permite editar un empleado
      */
      protected function __KsvmEditarEmpleadoModelo($KsvmCodEmpleado)
      {
          $KsvmEditEmpleado = "SELECT * FROM ksvmvistaempleado WHERE EpoId = :KsvmCodEmpleado";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmEditEmpleado);
          $KsvmQuery->bindParam(":KsvmCodEmpleado", $KsvmCodEmpleado);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
       /**
      *Función que permite contar un empleado
      */
      protected function __KsvmContarEmpleadoModelo($KsvmCodEmpleado)
      {
          $KsvmContarEmpleado = "SELECT EpoId FROM ksvmvistaempleado WHERE EpoId != 1 AND EpoEstEmp = 'A'";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmContarEmpleado);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
     /**
      *Función que permite imprimir una Empleado
      */
      protected function __KsvmImprimirEmpleadoModelo()
      {
          $KsvmImprimirEmpleado = "SELECT * FROM ksvmvistaempleado";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->query($KsvmImprimirEmpleado);
          return $KsvmQuery;
      }
       /**
      *Función que permite actualizar un empleado
      */
      protected function __KsvmActualizarEmpleadoModelo($KsvmDataEmpleado)
      {
        $KsvmActEmpleado = "UPDATE ksvmempleado03 SET CrgId = :KsvmCrgId, PrcId = :KsvmPrcId, RrlId = :KsvmRrlId, EpoTipIdentEmp = :KsvmEpoTipIdentEmp,
                            EpoIdentEmp = :KsvmEpoIdentEmp, EpoPriApeEmp = :KsvmEpoPriApeEmp, EpoSegApeEmp = :KsvmEpoSegApeEmp,
                            EpoPriNomEmp = :KsvmEpoPriNomEmp, EpoSegNomEmp = :KsvmEpoSegNomEmp, EpoTelfEmp = :KsvmEpoTelfEmp,
                            EpoDirEmp = :KsvmEpoDirEmp, EpoFchNacEmp = :KsvmEpoFchNacEmp, EpoEmailEmp = :KsvmEpoEmailEmp,
                            EpoSexoEmp = :KsvmEpoSexoEmp, EpoGeneroEmp = :KsvmEpoGeneroEmp, EpoEstCivEmp = :KsvmEpoEstCivEmp, EpoFotoEmp = :KsvmFotoEmp 
                            WHERE EpoId = :KsvmCodEmpleado";
        $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmActEmpleado);
        $KsvmQuery->bindParam(":KsvmCrgId", $KsvmDataEmpleado['KsvmCrgId']);
         $KsvmQuery->bindParam(":KsvmPrcId", $KsvmDataEmpleado['KsvmPrcId']);
         $KsvmQuery->bindParam(":KsvmRrlId", $KsvmDataEmpleado['KsvmRrlId']);
         $KsvmQuery->bindParam(":KsvmEpoTipIdentEmp", $KsvmDataEmpleado['KsvmEpoTipIdentEmp']);
         $KsvmQuery->bindParam(":KsvmEpoIdentEmp", $KsvmDataEmpleado['KsvmEpoIdentEmp']);
         $KsvmQuery->bindParam(":KsvmEpoPriApeEmp", $KsvmDataEmpleado['KsvmEpoPriApeEmp']);
         $KsvmQuery->bindParam(":KsvmEpoSegApeEmp", $KsvmDataEmpleado['KsvmEpoSegApeEmp']);
         $KsvmQuery->bindParam(":KsvmEpoPriNomEmp", $KsvmDataEmpleado['KsvmEpoPriNomEmp']);
         $KsvmQuery->bindParam(":KsvmEpoSegNomEmp", $KsvmDataEmpleado['KsvmEpoSegNomEmp']);
         $KsvmQuery->bindParam(":KsvmEpoTelfEmp", $KsvmDataEmpleado['KsvmEpoTelfEmp']);
         $KsvmQuery->bindParam(":KsvmEpoDirEmp", $KsvmDataEmpleado['KsvmEpoDirEmp']);
         $KsvmQuery->bindParam(":KsvmEpoFchNacEmp", $KsvmDataEmpleado['KsvmEpoFchNacEmp']);
         $KsvmQuery->bindParam(":KsvmEpoEmailEmp", $KsvmDataEmpleado['KsvmEpoEmailEmp']); 
         $KsvmQuery->bindParam(":KsvmEpoSexoEmp", $KsvmDataEmpleado['KsvmEpoSexoEmp']);
         $KsvmQuery->bindParam(":KsvmEpoGeneroEmp", $KsvmDataEmpleado['KsvmEpoGeneroEmp']);
         $KsvmQuery->bindParam(":KsvmEpoEstCivEmp", $KsvmDataEmpleado['KsvmEpoEstCivEmp']);
         $KsvmQuery->bindParam(":KsvmFotoEmp", $KsvmDataEmpleado['KsvmFotoEmp']);
         $KsvmQuery->bindParam(":KsvmCodEmpleado", $KsvmDataEmpleado['KsvmCodEmpleado']);
         $KsvmQuery->execute();
         return $KsvmQuery;
      }

   }
