<!-- Copyright 2019 Klever Santiago Vaca Muela -->

  <script type="text/javascript">
    $(document).ready(function () {

        /*Salir del sistema*/
        $('.btn-exit').on('click', function (e) {
            e.preventDefault();

            var KsvmRef = $(this);
            var KsvmToken = KsvmRef.attr('href');

            swal({
                title: 'Realmente quiere salir del sistema?',
                text: "La sesión actual se cerrará y abandonará el sistema",
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#F44336',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Salir',
                closeOnConfirm: false
              }
              ,function () {
                  $.ajax({
                      url:'<?php echo KsvmServUrl; ?>Ajax/KsvmLoginAjax.php?KsvmTok='+KsvmToken
                    })
                      .done(function(salir) {
                        if (salir == "true") {
                          window.location.href="<?php echo KsvmServUrl;?>Login";
                        }else{
                          swal("Ocurrió un error inesperado",
                            "No es posible cerrar la sesión",
                            "error"
                          );
                        }   
                        })
                        .fail(function(){
                          swal("Ocurrió un error inesperado",
                            "No es posible cerrar la sesión",
                            "error"
                          );
                        });
                      });
              });
      });
  </script>
  <script>
    $.material.init();
  </script>