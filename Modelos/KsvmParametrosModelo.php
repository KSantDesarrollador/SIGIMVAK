<?php

  /**
   *Condicion para peticion Ajax
   */
   if ($KsvmPeticionAjax) {
       require_once "../Raiz/KsvmEstMaestra.php";
   } else {
       require_once "./Raiz/KsvmEstMaestra.php";
   }

   class KsvmParametrosModelo extends KsvmEstMaestra
   {
     /**
      *Función que permite ingresar un Parametro
      */
     protected function __KsvmAgregarParametrosModelo($KsvmDataParametros)
     {
         $KsvmIngParametros = "INSERT INTO ksvmparametros22(ExtId, AltId, PmtMinPar, PmtMaxPar)
                                    VALUES(:KsvmExtId, :KsvmAltId, :KsvmMinPar, :KsvmMaxPar)";
         $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmIngParametros);
         $KsvmQuery->bindParam(":KsvmExtId", $KsvmDataParametros['KsvmExtId']);
         $KsvmQuery->bindParam(":KsvmAltId", $KsvmDataParametros['KsvmAltId']);
         $KsvmQuery->bindParam(":KsvmMinPar", $KsvmDataParametros['KsvmMinPar']);
         $KsvmQuery->bindParam(":KsvmMaxPar", $KsvmDataParametros['KsvmMaxPar']);
         $KsvmQuery->execute();
         return $KsvmQuery;
     }
     /**
      *Función que permite eliminar un Parametro
      */
      protected function __KsvmEliminarParametrosModelo($KsvmCodParametros)
      {
         $KsvmDelParametros = "DELETE FROM ksvmparametros22 WHERE PmtId = :KsvmCodParametros";
         $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmDelParametros);
         $KsvmQuery->bindParam(":KsvmCodParametros", $KsvmCodParametros);
         $KsvmQuery->execute();
         return $KsvmQuery;
      }
      /**
      *Función que permite editar un Parametro
      */
      protected function __KsvmEditarParametrosModelo($KsvmCodParametros)
      {
          $KsvmEditParametros = "SELECT * FROM ksvmvistaparametros WHERE PmtId = :KsvmCodParametros";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmEditParametros);
          $KsvmQuery->bindParam(":KsvmCodParametros", $KsvmCodParametros);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
       /**
      *Función que permite contar un Parametro
      */
      protected function __KsvmContarParametrosModelo($KsvmCodParametros)
      {
          $KsvmContarParametros = "SELECT PmtId FROM ksvmparametros22";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmContarParametros);
          $KsvmQuery->execute();
          return $KsvmQuery;
      }
     /**
      *Función que permite imprimir un Parametro
      */
      protected function __KsvmImprimirParametrosModelo()
      {
          $KsvmImprimirParametros = "SELECT * FROM ksvmvistaparametros";
          $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->query($KsvmImprimirParametros);
          return $KsvmQuery;
      }
       /**
      *Función que permite actualizar un Parametro
      */
      protected function __KsvmActualizarParametrosModelo($KsvmDataParametros)
      {
        $KsvmActParametros = "UPDATE ksvmparametros22 SET ExtId = :KsvmExtId, AltId = :KsvmAltId, PmtMinPar = :KsvmMinPar,
                              PmtMaxPar = :KsvmMaxPar WHERE PmtId = :KsvmCodParametros";
        $KsvmQuery = KsvmEstMaestra :: __KsvmConexion()->prepare($KsvmActParametros);
        $KsvmQuery->bindParam(":KsvmExtId", $KsvmDataParametros['KsvmExtId']);
        $KsvmQuery->bindParam(":KsvmAltId", $KsvmDataParametros['KsvmAltId']);
        $KsvmQuery->bindParam(":KsvmMinPar", $KsvmDataParametros['KsvmMinPar']);
        $KsvmQuery->bindParam(":KsvmMaxPar", $KsvmDataParametros['KsvmMaxPar']);
        $KsvmQuery->bindParam(":KsvmCodParametros", $KsvmDataParametros['KsvmCodParametros']);
        $KsvmQuery->execute();
        return $KsvmQuery;
      }

   }
