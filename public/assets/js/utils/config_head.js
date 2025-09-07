let dialogoProcesando;

/**
 * Muestra un cuadro de diálogo indicando que el sistema está procesando.
 */
function mostrarDialogoProcesando() {
    dialogoProcesando = $.dialog({
        title: 'Procesando...',
        icon: 'fas fa-spinner fa-spin',
        content: 'Por favor espera un momento',
        closeIcon: false,
        backgroundDismiss: false,
        draggable: false,
        useBootstrap: true,
        type: 'blue',
        theme: 'modern',
    });
}

/**
 * Cierra el cuadro de diálogo de procesamiento si está abierto.
 */
function cerrarDialogoProcesando() {
    if (dialogoProcesando) {
        dialogoProcesando.close();
    }
}


// configuraciones del jquery validator
 $.validator.setDefaults({
	ignore: 'input[type=hidden], .select2-search__field',
	errorClass: 'is-invalid',
	validClass: 'is-valid',
	highlight: function(element) {
		$(element).addClass('is-invalid').removeClass('is-valid');
	},
	unhighlight: function(element) {
		$(element).removeClass('is-invalid').addClass('is-valid');
	},
	errorPlacement: function(error, element) {
		const feedbackContainer = $(element).closest('.form-floating').find('.invalid-feedback');

		if (feedbackContainer.length) {
			feedbackContainer.text(error.text()).show();
		} else {
			const newFeedback = $('<div class="invalid-feedback fw-bold"></div>').text(error.text());
			$(element).parent().append(newFeedback);
		}
	},
	submitHandler: function (form) {

		mostrarDialogoProcesando();

		form.submit();
	}
});

// select 2
$('.select').select2();