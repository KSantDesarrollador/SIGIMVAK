<!-- 
 Copyright 2019 Klever Santiago Vaca Muela
-->
<?php
    require_once "./Controladores/KsvmExistenciaControlador.php";
    $KsvmIniExt = new KsvmExistenciaControlador();

    $KsvmDataEdit = $KsvmIniExt->__KsvmMostrarExistenciaControlador();

    if ($KsvmDataEdit->rowCount() >= 1) {
        $KsvmLlenarForm = $KsvmDataEdit->fetchAll();

        foreach ($KsvmLlenarForm as $row) {
?>

<script>
    /**Esta función muestra mensajes personalizados en el sistema*/

    Push.create("<?php echo KsvmCompany; ?>", {
        body: "<?php echo $row['MdcDescMed'].' '.$row['MdcConcenMed'].'\n'.'Tiene un'.' '.$row['AltDescAle'];?>",
        icon: "<?php echo KsvmServUrl; ?>Vistas/assets/img/Logo.png",
        timeout: 10000,
        onClick: function(){
              window.location = "<?php echo KsvmServUrl; ?>KsvmExistencias/1/";
              this.close();
        }

    });
</script>

<?php }}?>
