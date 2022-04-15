/*================================================================
    TODO: Validación de lado del cliente
================================================================*/

/*==================================================
    TODO: Validación desde Bootstrap 4
==================================================*/

(function () {
    'use strict';
    window.addEventListener('load', function () {
        // Get the forms we want to add validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function (form) {
            form.addEventListener('submit', function (event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();

/*==================================================
    TODO: Función para validar data repetida
==================================================*/

function validateRepeat(event, type, table, suffix) {

    var data = new FormData();
    data.append("data", event.target.value);
    data.append("table", table);
    data.append("suffix", suffix);

    $.ajax({
        url: "ajax/ajax-validate.php",
        method: "POST",
        data: data,
        contentType: false,
        cache: false,
        processData: false,
        success: function (response) {

            if (response == 200) {

                event.target.value = "";
                $(event.target).parent().addClass("was-validated");
                $(event.target).parent().children(".invalid-feedback").html("El dato escrito ya existen en la base de datos");

            } else {

                validateJS(event, type);

                if (table == "categories" || table == "subcategories") {

                    createUrl(event, "url-" + suffix);

                }

            }

        }

    })

}

/*==================================================
    TODO: Función para validar formulario
==================================================*/

function validateJS(event, type) {

    var pattern;

    if (type == "text") pattern = /^[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}$/;

    if (type == "t&n") pattern = /^[A-Za-z0-9]{1,}$/;

    if (type == "email") pattern = /^[.a-zA-Z0-9_]+([.][.a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/;

    if (type == "pass") pattern = /^[#\\=\\$\\;\\*\\_\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-Z]{1,}$/;

    if (type == "regex") pattern = /^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}$/;

    if (type == "icon") {

        pattern = /^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}$/;

        $(".viewIcon").html('<i class="' + event.target.value + '"></i>')

    }

    if (type == "phone") pattern = /^[-\\(\\)\\0-9 ]{1,}$/;

    if (!pattern.test(event.target.value)) {

        $(event.target).parent().addClass("was-validated");
        $(event.target).parent().children(".invalid-feedback").html("Error de sintaxias en el campo.");

    }

}

/*==================================================
    TODO: Validar imagen
==================================================*/

function validateImageJS(event, input) {

    var image = event.target.files[0];

    if (image["type"] !== "image/png" && image["type"] !== "image/jpeg" && image["type"] !== "image/gif") {

        fncNotie(3, "La imagen debe estar en formato JPG, PNG o GIF.");

        return;

    } else if (image["size"] > 2000000) {

        fncNotie(3, "La imagen no debe pesar más de 2 MB.");

        return;

    } else {

        var data = new FileReader();
        data.readAsDataURL(image);

        $(data).on("load", function (event) {

            var path = event.target.result;

            $("." + input).attr("src", path);

        })

    }

}


/*================================================================
    TODO: Función para recordar credenciales de ingreso
================================================================*/

function rememberMe(event) {

    if (event.target.checked) {

        localStorage.setItem("emailRemember", $('[name="loginEmail"]').val());
        localStorage.setItem("checkRemember", true);

    } else {

        localStorage.removeItem("emailRemember");
        localStorage.removeItem("checkRemember");

    }

}

/*================================================================
    TODO: Capturar el email para login desde el LocalStorage
================================================================*/

$(document).ready(function () {

    if (localStorage.getItem("emailRemember") != null) {

        $('[name="loginEmail"]').val(localStorage.getItem("emailRemember"));
    }

    if (localStorage.getItem("checkRemember") != null && localStorage.getItem("checkRemember")) {

        $('#remember').attr("checked", true);

    }

})

/*================================================================
    TODO: Activación de Bootstrap Switch
================================================================*/

$("input[data-bootstrap-switch]").each(function () {
    $(this).bootstrapSwitch('state', $(this).prop('checked'));
})

/*================================================================
    TODO: Activación de Select 2
================================================================*/

$('.select2').select2({
    theme: 'bootstrap4'
})

/*================================================================
    TODO: Capturar código telefónico
================================================================*/

$(document).on("change", ".changeCountry", function () {

    $(".dialCode").html($(this).val().split("_")[1]);

})

/*================================================================
    TODO: Función para crear Url's
================================================================*/

function createUrl(event, name) {

    var value = event.target.value;
    value = value.toLowerCase();
    value = value.replace(/[#\\;\\$\\&\\%\\=\\(\\)\\:\\,\\.\\¿\\¡\\!\\?\\]/g, "");
    value = value.replace(/[ ]/g, "-");
    value = value.replace(/[á]/g, "a");
    value = value.replace(/[é]/g, "e");
    value = value.replace(/[í]/g, "i");
    value = value.replace(/[ó]/g, "o");
    value = value.replace(/[ú]/g, "u");
    value = value.replace(/[ñ]/g, "n");

    $('[name="' + name + '"]').val(value);
}

/*================================================================
    TODO: Tags Input
================================================================*/

if ($('.tags-input').length > 0) {

    $('.tags-input').tagsinput({
        maxTags: 10
    });

}

/*================================================================
    TODO: Traer subcategorias de acuerdo a la categoría
================================================================*/

function changeCategory(event) {

    $(".titleList").show();

    var idCategory = event.target.value;

    var data = new FormData();
    data.append("data", idCategory);
    data.append("select", "title_list_category");
    data.append("table", "categories");
    data.append("suffix", "id_category");

    $.ajax({
        url: "ajax/ajax-select.php",
        method: "POST",
        data: data,
        contentType: false,
        cache: false,
        processData: false,
        success: function (response) {

            var arrayResponse = JSON.parse(response);

            if (arrayResponse["status"] == 200) {

                var optTitleList = $(".optTitleList");

                optTitleList.each(i => {

                    $(optTitleList[i]).remove();

                })

                JSON.parse(arrayResponse["results"][0]["title_list_category"]).forEach(value => {

                    $('[name="titleList-subcategory"]').append(`<option class="optTitleList" value="` + value + `">` + value + `</option>`)

                });

            }

        }

    })

}