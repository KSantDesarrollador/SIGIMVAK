/*
 * Copyright 2019 Klever Santiago Vaca Muela
 */

$(document).ready(function() {
	/*Enviar formularios mediante Ajax*/
	$('.FormularioAjax').submit(function(e) {
		e.preventDefault();

		var form = $(this);

		var tipo = form.attr('data-form');
		var accion = form.attr('action');
		var metodo = form.attr('method');
		var respuesta = form.children('.RespuestaAjax');

		var msjError =
			"<script>swal('Ocurrió un error inesperado','Por favor recargue la página','error');</script>";
		var formdata = new FormData(form[0]);

		var textoAlerta;
		if (tipo === 'guardar') {
			textoAlerta = 'Los datos que enviará quedaran almacenados en el sistema';
		} else if (tipo === 'eliminar') {
			textoAlerta = 'Los datos serán eliminados completamente del sistema';
		} else if (tipo === 'modificar') {
			textoAlerta = 'Los datos del sistema serán actualizados';
		} else {
			textoAlerta = 'Quiere realizar la operación solicitada';
		}

		swal(
			{
				title: '¿Está seguro?',
				text: textoAlerta,
				type: 'info',
				showCancelButton: true,
				cancelButtonColor: '#F44336',
				confirmButtonText: 'Aceptar',
				cancelButtonText: 'Cancelar'
			},
			function(isConfirm) {
				if (isConfirm) {
					$.ajax({
						type: metodo,
						url: accion,
						data: formdata,
						cache: false,
						contentType: false,
						processData: false,
						xhr: function() {
							var xhr = new window.XMLHttpRequest();
							xhr.upload.addEventListener('progress', function(evt) {
								if (evt.lengthComputable) {
									var percentComplete = evt.loaded / evt.total;
									percentComplete = parseInt(percentComplete * 100);
									if (percentComplete < 100) {
										respuesta.html(
											'<p class="text-center">Procesado... (' +
												percentComplete +
												'%)</p><div class="progress progress-striped active"><div class="progress-bar progress-bar-info" style="width: ' +
												percentComplete +
												'%;"></div></div>'
										);
									} else {
										respuesta.html('<p class="text-center"></p>');
									}
								}
							});
							return xhr;
						},
						success: function(data) {
							respuesta.html(data);
						},
						error: function() {
							respuesta.html(msjError);
						}
					});
					return false;
				}
			}
		);
	});

	/*Mostrar ocultar area de notificaciones*/
	$('.btn-Notification').on('click', function() {
		var ContainerNoty = $('.container-notifications');
		var NotificationArea = $('.NotificationArea');
		if (
			NotificationArea.hasClass('NotificationArea-show') &&
			ContainerNoty.hasClass('container-notifications-show')
		) {
			NotificationArea.removeClass('NotificationArea-show');
			ContainerNoty.removeClass('container-notifications-show');
		} else {
			NotificationArea.addClass('NotificationArea-show');
			ContainerNoty.addClass('container-notifications-show');
		}
	});

	/*Mostrar ocultar menu principal*/
	$('.btn-menu').on('click', function() {
		var navLateral = $('.navLateral');
		var pageContent = $('.pageContent');
		var footer = $('.footer');
		var navOption = $('.navBar-options');
		if (
			navLateral.hasClass('navLateral-change') &&
			pageContent.hasClass('pageContent-change')
		) {
			navLateral.removeClass('navLateral-change');
			pageContent.removeClass('pageContent-change');
			footer.removeClass('footer-change');
			navOption.removeClass('navBar-options-change');
		} else {
			navLateral.addClass('navLateral-change');
			pageContent.addClass('pageContent-change');
			footer.addClass('footer-change');
			navOption.addClass('navBar-options-change');
		}
	});

	/*Mostrar y ocultar submenus*/
	$('.btn-subMenu').on('click', function() {
		var subMenu = $(this).next('ul');
		var icon = $(this).children('span');
		if (subMenu.hasClass('sub-menu-options-show')) {
			subMenu.removeClass('sub-menu-options-show');
			icon.addClass('zmdi-chevron-left').removeClass('zmdi-chevron-down');
		} else {
			subMenu.addClass('sub-menu-options-show');
			icon.addClass('zmdi-chevron-down').removeClass('zmdi-chevron-left');
		}
	});

	/*Agrega registros a la lista*/
	$('.RegistrosAjax').submit(function(e) {
		e.preventDefault();

		var form = $(this);

		var accion = form.attr('action');
		var metodo = form.attr('method');
		var msjError =
			"<script>swal('Ocurrió un error inesperado','Por favor recargue la página','error');</script>";
		var datos = new FormData(form[0]);

		$.ajax({
			type: metodo,
			url: accion,
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			success: function(info) {
				if (info == 'true') {
					$('.RegistrosAjax')[0].reset();
				} else {
					$('.Respuesta').html(info);
				}
			},
			error: function() {
				$('.Respuesta').html(msjError);
			}
		});
		return false;
	});

	/*Cronómetro*/

	let KsvmCronometro = $('#KsvmDuracionInv');
	let KsvmBtnIniciar = $('#btnIniciar');
	let KsvmBtnGuardar = $('#btnGuardar');
	let KsvmBtnCancelar = $('#btnCancelar');

	let KsvmSegundos = 00,
		KsvmMinutos = 0,
		KsvmHoras = 0;
	let KsvmIntervalo = 0;
	let KsvmBandera = false;

	Iniciar();

	function Iniciar() {
		KsvmBtnIniciar.on('click', function() {
			if (KsvmBandera == false) {
				KsvmIntervalo = setInterval(function() {
					KsvmSegundos++;
					if (KsvmSegundos == 60) {
						KsvmSegundos = 00;
						KsvmMinutos++;
						if (KsvmMinutos == 60) {
							KsvmMinutos = 00;
							KsvmHoras++;
						}
					}

					KsvmHour = (KsvmHoras < 10 ? '0' : '') + KsvmHoras;
					KsvmMin = (KsvmMinutos < 10 ? ':0' : ':') + KsvmMinutos;
					KsvmSeg = (KsvmSegundos < 10 ? ':0' : ':') + KsvmSegundos;
					KsvmCronometro.val(KsvmHour + KsvmMin + KsvmSeg);
				}, 1000);
				KsvmBandera = true;
			}
		});

		KsvmBtnCancelar.on('click', function() {
			if (KsvmBandera == false) {
				KsvmIntervalo = setInterval(function() {
					KsvmSegundos++;
					if (KsvmSegundos == 60) {
						KsvmSegundos = 00;
						KsvmMinutos++;
						if (KsvmMinutos == 60) {
							KsvmMinutos = 00;
							KsvmHoras++;
						}
					}

					KsvmHour = (KsvmHoras < 10 ? '0' : '') + KsvmHoras;
					KsvmMin = (KsvmMinutos < 10 ? ':0' : ':') + KsvmMinutos;
					KsvmSeg = (KsvmSegundos < 10 ? ':0' : ':') + KsvmSegundos;
					KsvmCronometro.val(KsvmHour + KsvmMin + KsvmSeg);
				}, 1000);
				KsvmBandera = true;
			}
		});

		KsvmBtnGuardar.on('click', function() {
			KsvmBandera = false;
			clearInterval(KsvmIntervalo);
		});
	}

	// Validar formularios
	$('#btnSave').on('click', function() {
		var KsvmDato1 = $('#KsvmDato1').val();
		var KsvmDato2 = $('#KsvmDato2').val();
		var KsvmDato3 = $('#KsvmDato3').val();
		var KsvmDato4 = $('#KsvmDato4').val();
		var KsvmDato5 = $('#KsvmDato5').val();
		var KsvmDato6 = $('#KsvmDato6').val();
		var KsvmDato7 = $('#KsvmDato7').val();
		var KsvmDato8 = $('#KsvmDato8').val();
		var KsvmDato9 = $('#KsvmDato9').val();
		var KsvmDato10 = $('#KsvmDato10').val();
		var KsvmDato11 = $('#KsvmDato11').val();
		var KsvmDato12 = $('#KsvmDato12').val();
		var KsvmDato13 = $('#KsvmDato13').val();
		var KsvmDato14 = $('#KsvmDato14').val();
		var KsvmDato15 = $('#KsvmDato15').val();

		if (KsvmDato1 == '') {
			$('#KsvmError1').fadeIn(600);
			return false;
		} else {
			$('#KsvmError1').fadeOut(600);
			if (KsvmDato2 == '') {
				$('#KsvmError2').fadeIn(600);
				return false;
			} else {
				$('#KsvmError2').fadeOut(600);
				if (KsvmDato3 == '') {
					$('#KsvmError3').fadeIn(600);
					return false;
				} else {
					$('#KsvmError3').fadeOut(600);
					if (KsvmDato4 == '') {
						$('#KsvmError4').fadeIn(600);
						return false;
					} else {
						$('#KsvmError4').fadeOut(600);
						if (KsvmDato5 == '') {
							$('#KsvmError5').fadeIn(600);
							return false;
						} else {
							$('#KsvmError5').fadeOut(600);
							if (KsvmDato6 == '') {
								$('#KsvmError6').fadeIn(600);
								return false;
							} else {
								$('#KsvmError6').fadeOut(600);
								if (KsvmDato7 == '') {
									$('#KsvmError7').fadeIn(600);
									return false;
								} else {
									$('#KsvmError7').fadeOut(600);
									if (KsvmDato8 == '') {
										$('#KsvmError8').fadeIn(600);
										return false;
									} else {
										$('#KsvmError8').fadeOut(600);
										if (KsvmDato9 == '') {
											$('#KsvmError9').fadeIn(600);
											return false;
										} else {
											$('#KsvmError9').fadeOut(600);
											if (KsvmDato10 == '') {
												$('#KsvmError10').fadeIn(600);
												return false;
											} else {
												$('#KsvmError10').fadeOut(600);
												if (KsvmDato11 == '') {
													$('#KsvmError11').fadeIn(600);
													return false;
												} else {
													$('#KsvmError11').fadeOut(600);
													if (KsvmDato12 == '') {
														$('#KsvmError12').fadeIn(600);
														return false;
													} else {
														$('#KsvmError12').fadeOut(600);
														if (KsvmDato13 == '') {
															$('#KsvmError13').fadeIn(600);
															return false;
														} else {
															$('#KsvmError13').fadeOut(600);
															if (KsvmDato14 == '') {
																$('#KsvmError14').fadeIn(600);
																return false;
															} else {
																$('#KsvmError14').fadeOut(600);
																if (KsvmDato15 == '') {
																	$('#KsvmError15').fadeIn(600);
																	return false;
																}
															}
														}
													}
												}
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}
	});

	$('.mdl-textfield__input').on('keypress', function() {
		$('.ValForm').fadeOut(600);
	});

	$('.ksvmSelectDin').on('change', function() {
		$('.ValForm').fadeOut(600);
	});

	/* Multiple Item Picker */
	$('.ksvmSelectDin').select2();
});

/*Barras de navegación*/
(function($) {
	$(window).on('load', function() {
		$('.navLateral-body').mCustomScrollbar({
			theme: 'light',
			scrollbarPosition: 'inside',
			autoHideScrollbar: true,
			scrollButtons: { enable: true }
		});
		$('.pageContent, .NotificationArea, #containerCant').mCustomScrollbar({
			theme: 'dark',
			scrollbarPosition: 'inside',
			autoHideScrollbar: true,
			scrollButtons: { enable: true }
		});
		// $('').mCustomScrollbar({
		// 	theme: 'dark',
		// 	scrollbarPosition: 'inside',
		// 	autoHideScrollbar: true,
		// 	scrollButtons: { enable: true }
		// });
	});
})(jQuery);
