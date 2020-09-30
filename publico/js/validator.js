$("#form_ej4").bootstrapValidator({

    message: "Valor invalido",

    feedbackIcons: {
        valid: "fal fa-inverse",
        validating: "fa fa-wifi-1",
        invalid: "fa fa-times"
    },

    fields: {

        titulo: {

            validators: {
                notEmpty: {
                    message: "Se requiere el titulo de la obra."
                }
            }
        },

        actores: {

            validators: {
                notEmpty: {
                    message: "Se requiere al menos un actor."
                }
            }
        },

        director: {

            validators: {
                notEmpty: {
                    message: "Se requiere al menos un director."
                }
            }
        },

        guion: {

            validators: {
                notEmpty: {
                    message: "Se requiere el guión."
                }
            }
        },

        produccion: {

            validators: {
                notEmpty: {
                    message: "Se requiere este dato."
                }
            }
        },

        anio: {

            validators: {
                notEmpty: {
                    message: "Se requiere una fecha."
                }
            }
        },

        nacionalidad: {

            validators: {
                notEmpty: {
                    message: "Se requiere la Nacionalidad."
                }
            }
        },

        genero: {

            validators: {
                notEmpty: {
                    message: "Se requiere un genero."
                }
            }
        },

        duracion: {

            validators: {
                notEmpty: {
                    message: "Se requiere la duración de la obra."
                }
            }
        },

        restriccion: {

            validators: {
                notEmpty: {
                    message: "Se requiere una restriccion de edad."
                }
            }
        },

        sinopsis: {

            validators: {
                notEmpty: {
                    message: "Se requiere la sinopsis."
                }
            }
        }

    }

});