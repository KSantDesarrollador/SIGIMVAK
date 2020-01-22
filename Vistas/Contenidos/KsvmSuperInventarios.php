<?php
    require_once "./Controladores/KsvmInventarioControlador.php";
    $KsvmIniInv = new KsvmInventarioControlador();
    $KsvmListarInventario = $KsvmIniInv->__KsvmListarSuperInventarios();
    ?>

<section class="full-width pageContent">
    <section class="full-width header-well">
        <div class="full-width header-well-icon">
            <i class="zmdi zmdi-check-circle"></i>
        </div>
        <div class="full-width header-well-text">
            <p class="text-condensedLight">
                INVENTARIOS
            </p>
        </div>
    </section>
    <br>
    <div class="mdl-tabs" id="KsvmListaInventarios">
        <div class="mdl-grid">
            <div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
                <table class="mdl-data-table mdl-js-data-table mdl-shadow--6dp full-width table-responsive">
                    <thead>
                        <tr>
                            <th class="mdl-data-table__cell--non-numeric"># Inventario</th>
                            <th class="mdl-data-table__cell--non-numeric">Fecha</th>
                            <th class="mdl-data-table__cell--non-numeric">Bodega</th>
                            <th class="mdl-data-table__cell--non-numeric">Responsable</th>
                            <th class="mdl-data-table__cell--non-numeric">Hora</th>
                            <th class="mdl-data-table__cell--non-numeric">Duración</th>
                            <th style="text-align:center; witdh:30px;">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                    if ($KsvmListarInventario->rowCount() >= 1) {
                        $KsvmQuery = $KsvmListarInventario->fetchAll();
                        foreach ($KsvmQuery as $rows) {
                ?>
                        <tr>
                            <td class="mdl-data-table__cell--non-numeric"><?php echo $rows['IvtCodInv']?></td>
                            <td class="mdl-data-table__cell--non-numeric"><?php echo $rows['IvtFchElabInv']?></td>
                            <td class="mdl-data-table__cell--non-numeric"><?php echo $rows['BdgDescBod']?></td>
                            <td class="mdl-data-table__cell--non-numeric"><?php echo $rows['IvtPerElabInv']?></td>
                            <td class="mdl-data-table__cell--non-numeric"><?php echo $rows['IvtHoraInv']?></td>
                            <td class="mdl-data-table__cell--non-numeric"><?php echo $rows['IvtDuracionInv']?></td>
                            <td style="text-align:right; witdh:30px; display:inline-flex;">

                                <a id="btn-detail" class="btn btn-sm btn-info"
                                    href="<?php echo KsvmServUrl;?>KsvmSuperInventarios/Detail/<?php echo KsvmEstMaestra::__KsvmEncriptacion($rows['IvtId']);?>"><i
                                        class="zmdi zmdi-card"></i></a>
                                <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                &nbsp;
                                <form action="<?php echo KsvmServUrl;?>Ajax/KsvmInventarioAjax.php" method="POST"
                                    class="FormularioAjax" data-form="modificar" enctype="multipart/form-data">
                                    <input type="hidden" name="KsvmCodRevision"
                                        value="<?php echo KsvmEstMaestra::__KsvmEncriptacion($rows['IvtId']);?>">
                                    <input type="hidden" name="KsvmTokken"
                                        value="<?php echo KsvmEstMaestra::__KsvmEncriptacion('APB');?>">
                                    <button id="btn-Aprobado" type="submit" class="btn btn-sm btn-success"><i
                                            class="zmdi zmdi-power"></i></button>
                                    <div class="mdl-tooltip" for="btn-Aprobado">Confirmar</div>
                                    <div class="RespuestaAjax"></div>
                                </form>
                            </td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php } else {?>
        <tr>
            <td class="mdl-data-table__cell--non-numeric" colspan="7"><strong>No se encontraron registros...</strong>
            </td>
        </tr>
        </tbody>
        </table>

        <?php }?>

        <!-- Método para cargar datos en el formulario -->
        <?php 
			  
              $KsvmPagina = explode("/", $_GET['Vistas']);
              if ($KsvmPagina[2] != "") {
              $KsvmDataEdit = $KsvmIniInv->__KsvmEditarDetalleInventarioControlador($KsvmPagina[2]);
    
                  $KsvmQuery = $KsvmDataEdit->fetchAll();
                  
            ?>
        <script>
            window.onload = function () {

                $("#KsvmFormOcp").trigger("reset");
                $(".modal-title").text("Detalles Inventario");
                $("#KsvmDetallesInventario").modal({
                    show: true
                });
            }
        </script>

        <!-- Formulario de Detalles del Inventario -->

        <div class="modal fade" id="KsvmDetallesInventario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content ">
                    <div class="modal-header">
                        <button class="close close-edit" type="button" id="btnExitSinv" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                        <h5 class="modal-title text-center"></h5>
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST" id="KsvmFormOcp">
                            <input type="hidden" name="KsvmCodEdit" value="<?php echo $KsvmPagina[2]; ?>">
                            <div class="mdl-grid">
                                <div
                                    class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--2-col-desktop">
                                    <div class="mdl-textfield"><strong>Num.Inventario :</strong></div>
                                </div>
                                <div
                                    class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--2-col-desktop">
                                    <div class="mdl-textfield"><strong>Medicamento:</strong></div>
                                </div>
                                <div
                                    class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--2-col-desktop">
                                    <div class="mdl-textfield"><strong>Fch.Cad :</strong></div>
                                </div>
                                <div
                                    class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--1-col-desktop">
                                    <div class="mdl-textfield"><strong>Stock :</strong></div>
                                </div>
                                <div
                                    class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--2-col-desktop">
                                    <div class="mdl-textfield"><strong>Cont.Físico :</strong></div>
                                </div>
                                <div
                                    class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--2-col-desktop">
                                    <div class="mdl-textfield"><strong>Diferencia :</strong></div>
                                </div>
                                <div
                                    class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--1-col-desktop">
                                    <div class="mdl-textfield"><strong>Acción :</strong></div>
                                </div>
                                <?php foreach ($KsvmQuery as $KsvmLlenarForm) {?>
                                <div
                                    class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--2-col-desktop">
                                    <div class="mdl-data-table__cell--non-numeric">
                                        <div class="mdl-textfield__input">
                                            <?php echo $KsvmLlenarForm['IvtCodInv'];?></div>
                                    </div>
                                </div>
                                <div
                                    class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--2-col-desktop">
                                    <div class="mdl-data-table__cell--non-numeric">
                                        <div class="mdl-textfield__input">
                                            <?php echo $KsvmLlenarForm['MdcDescMed'].' '.$KsvmLlenarForm['MdcConcenMed'];?>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--2-col-desktop">
                                    <div class="mdl-data-table__cell--non-numeric mdl-textfield--floating-label">
                                        <div class="mdl-textfield__input">
                                            <?php echo $KsvmLlenarForm['ExtFchCadEx'];?></div>
                                    </div>
                                </div>
                                <div
                                    class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--1-col-desktop">
                                    <div class="mdl-data-table__cell--non-numeric mdl-textfield--floating-label">
                                        <div class="mdl-textfield__input">
                                            <?php echo $KsvmLlenarForm['DivStockInv'];?></div>
                                    </div>
                                </div>
                                <div
                                    class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--2-col-desktop">
                                    <div class="mdl-data-table__cell--non-numeric mdl-textfield--floating-label">
                                        <div class="mdl-textfield__input">
                                            <?php echo $KsvmLlenarForm['DivContFisInv'];?></div>
                                    </div>
                                </div>
                                <div
                                    class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--2-col-desktop">
                                    <div class="mdl-data-table__cell--non-numeric mdl-textfield--floating-label">
                                        <div class="mdl-textfield__input">
                                            <?php echo $KsvmLlenarForm['DivDifInv'];?></div>
                                    </div>
                                </div>
                                <div
                                    class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--1-col-desktop">
                                    <a class="btn btn-sm btn-primary"
                                        href="<?php echo KsvmServUrl;?>KsvmDetallesInventarioEditar/<?php echo KsvmEstMaestra::__KsvmEncriptacion($KsvmLlenarForm['DivId']);?>/2/"><i
                                            class="zmdi zmdi-edit"></i></a>
                                </div>
                                <?php }?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php }?>
    </div>
</section>