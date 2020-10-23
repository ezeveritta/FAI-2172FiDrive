$("#form_amarchivo").bootstrapValidator({

    message: "Valor invalido",

    feedbackIcons: {
        valid: "fal fa-inverse",
        validating: "fa fa-wifi-1",
        invalid: "fa fa-times"
    },

    fields: {

        nombre: {

            validators: {
                notEmpty: {
                    message: "Se requiere un nombre."
                }
            }
        },

        usuario: {

            validators: {
                notEmpty: {
                    message: "Se requiere un usuario."
                }
            }
        }

    }

});

// Eliminar Archivo
$("#eliminarArchivo").bootstrapValidator({

    message: "Valor invalido",

    feedbackIcons: {
        valid: "fal fa-inverse",
        validating: "fa fa-wifi-1",
        invalid: "fa fa-times"
    },

    fields: {

        usuario: {

            validators: {
                notEmpty: {
                    message: "Se requiere un nombre."
                }
            }
        },

        motivo: {

            validators: {
                notEmpty: {
                    message: "Se requiere un motivo."
                }
            }
        }

    }

});