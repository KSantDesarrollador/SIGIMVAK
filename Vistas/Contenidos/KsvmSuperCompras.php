<?php
    require_once "./Controladores/KsvmCompraControlador.php";
    $KsvmIniComp = new KsvmCompraControlador();
    $KsvmListarCompra = $KsvmIniComp->__KsvmListarSuperCompras();
    ?>

<section class="full-width pageContent">
    <section class="full-width header-well">
        <div class="full-width header-well-icon">
            <i class="zmdi zmdi-shopping-cart"></i>
        </div>
        <div class="full-width header-well-text">
            <p class="text-condensedLight">
                ORDENES DE COMPRA
            </p>
        </div>
    </section>
    <br>
    <div class="mdl-tabs" id="KsvmListaCompras">
        <div class="mdl-grid">
            <div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
                <table class="mdl-data-table mdl-js-data-table mdl-shadow--6dp full-width table-responsive">
                    <thead>
                        <tr>
                            <th class="mdl-data-table__cell--non-numeric"># Compra</th>
                            <th class="mdl-data-table__cell--non-numeric">Fecha</th>
                            <th class="mdl-data-table__cell--non-numeric">Num.Factura</th>
                            <th class="mdl-data-table__cell--non-numeric">Responsable</th>
                            <th class="mdl-data-table__cell--non-numeric">Unidad Médica</th>
                            <th class="mdl-data-table__cell--non-numeric">Proveedor</th>
                            <th style="text-align:center; witdh:30px;">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                <?php
                    if ($KsvmListarCompra->rowCount() >= 1) {
                        $KsvmQuery = $KsvmListarCompra->fetchAll();
                    foreach ($KsvmQuery as $rows) {
                        ?>
                        <tr>
                            <td class="mdl-data-table__cell--non-numeric"><?php echo $rows['CmpNumOcp']?></td>
                            <td class="mdl-data-table__cell--non-numeric"><?php echo $rows['CmpFchElabOcp']?></td>
                            <td class="mdl-data-table__cell--non-numeric"><?php echo $rows['CmpNumFactOcp']?></td>
                            <td class="mdl-data-table__cell--non-numeric"><?php echo $rows['CmpPerElabOcp']?></td>
                            <td class="mdl-data-table__cell--non-numeric"><?php echo $rows['UmdNomUdm']?></td>
                            <td class="mdl-data-table__cell--non-numeric"><?php echo $rows['PvdRazSocProv']?></td>
                            <td style="text-align:right; witdh:30px; display:inline-flex;">

                                <a id="btn-detail" class="btn btn-sm btn-info"
                                    href="<?php echo KsvmServUrl;?>KsvmSuperCompras/Detail/<?php echo KsvmEstMaestra::__KsvmEncriptacion($rows['CmpId']);?>"><i
                                        class="zmdi zmdi-card"></i></a>
                                <div class="mdl-tooltip" for="btn-detail">Detalles</div>
                                &nbsp;
                                <form action="<?php echo KsvmServUrl;?>Ajax/KsvmComprasAjax.php" method="POST"
                                    class="FormularioAjax" data-form="modificar" enctype="multipart/form-data">
                                    <input type="hidden" name="KsvmCodRevision"
                                        value="<?php echo KsvmEstMaestra::__KsvmEncriptacion($rows['CmpId']);?>">
                                        <input type="hidden" name="KsvmTokken"
                                        value="<?php echo KsvmEstMaestra::__KsvmEncriptacion('APB');?>">
                                    <button id="btn-Aprobado" type="submit" class="btn btn-sm btn-success"><i
                                            class="zmdi zmdi-check"></i></button>
                                    <div class="mdl-tooltip" for="btn-Aprobado">Aprobar</div>
                                    <div class="RespuestaAjax"></div>
                                </form>
                                &nbsp;
                                <form action="<?php echo KsvmServUrl;?>Ajax/KsvmComprasAjax.php" method="POST"
                                    class="FormularioAjax" data-form="modificar" enctype="multipart/form-data">
                                    <input type="hidden" name="KsvmCodRevision"
                                        value="<?php echo KsvmEstMaestra::__KsvmEncriptacion($rows['CmpId']);?>">
                                        <input type="hidden" name="KsvmTokken"
                                        value="<?php echo KsvmEstMaestra::__KsvmEncriptacion('NEG');?>">
                                    <button id="btn-Negado" type="submit" class="btn btn-sm btn-danger"><i
                                            class="zmdi zmdi-close"></i></button>
                                    <div class="mdl-tooltip" for="btn-Negado">Negar</div>
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
                <td class="mdl-data-table__cell--non-numeric" colspan="7"><strong>No se encontraron registros...</strong></td>
                </tr>
                </tbody>
                </table>

        <?php }?>

        <!-- Método para cargar datos en el formulario -->
        <?php 
			  
              $KsvmPagina = explode("/", $_GET['Vistas']);
              if ($KsvmPagina[2] != "") {
              $KsvmDataEdit = $KsvmIniComp->__KsvmEditarDetalleCompraControlador($KsvmPagina[2]);
    
                  $KsvmQuery = $KsvmDataEdit->fetchAll();
                  
            ?>
        <script>
            window.onload = function () {

                $("#KsvmFormOcp").trigger("reset");
                $(".modal-title").text("Detalles Compra");
                $("#KsvmDetallesCompra").modal({
                    show: true
                });
            }
        </script>

        <!-- Formulario de Detalles del Compra -->

        <div class="modal fade" id="KsvmDetallesCompra" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content ">
                    <div class="modal-header">
                        <button class="close close-edit" type="button" id="btnExitSocp" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                        <h5 class="modal-title text-center"></h5>
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST" id="KsvmFormOcp">
                            <input type="hidden" name="KsvmCodEdit" value="<?php echo $KsvmPagina[2]; ?>">
                            <div class="mdl-grid">
                                <div
                                    class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--2-col-desktop">
                                    <div class="mdl-textfield"><strong>Num.Orden Compra :</strong></div>
                                </div>
                                <div
                                    class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--2-col-desktop">
                                    <div class="mdl-textfield"><strong>Medicamento:</strong></div>
                                </div>
                                <div
                                    class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--1-col-desktop">
                                    <div class="mdl-textfield"><strong>Cantidad :</strong></div>
                                </div>
                                <div
                                    class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--2-col-desktop">
                                    <div class="mdl-textfield"><strong>Valor Unitario :</strong></div>
                                </div>
                                <div
                                    class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--2-col-desktop">
                                    <div class="mdl-textfield"><strong>Valor Total :</strong></div>
                                </div>
                                <div
                                    class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--2-col-desktop">
                                    <div class="mdl-textfield"><strong>Observación :</strong></div>
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
                                            <?php echo $KsvmLlenarForm['CmpNumOcp'];?></div>
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
                                    class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--1-col-desktop">
                                    <div class="mdl-data-table__cell--non-numeric mdl-textfield--floating-label">
                                        <div class="mdl-textfield__input">
                                            <?php echo $KsvmLlenarForm['DocCantOcp'];?></div>
                                    </div>
                                </div>
                                <div
                                    class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--2-col-desktop">
                                    <div class="mdl-data-table__cell--non-numeric mdl-textfield--floating-label">
                                        <div class="mdl-textfield__input">
                                            <?php echo $KsvmLlenarForm['DocValorUntOcp'];?></div>
                                    </div>
                                </div>
                                <div
                                    class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--2-col-desktop">
                                    <div class="mdl-data-table__cell--non-numeric mdl-textfield--floating-label">
                                        <div class="mdl-textfield__input">
                                            <?php echo $KsvmLlenarForm['DocValorTotOcp'];?></div>
                                    </div>
                                </div>
                                <div
                                    class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--2-col-desktop">
                                    <div class="mdl-data-table__cell--non-numeric mdl-textfield--floating-label">
                                        <div class="mdl-textfield__input">
                                            <?php echo $KsvmLlenarForm['DocObservOcp'];?></div>
                                    </div>
                                </div>
                                <div
                                    class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--1-col-desktop">
                                    <a class="btn btn-sm btn-primary"
                                        href="<?php echo KsvmServUrl;?>KsvmDetallesCompraEditar/<?php echo KsvmEstMaestra::__KsvmEncriptacion($KsvmLlenarForm['DocId']);?>/2/"><i
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