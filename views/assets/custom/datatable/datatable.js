var page;

function execDatatable(text){

/*=====================================================================
    TODO: Validamos tabla de administradores
=====================================================================*/

if($(".tableAdmins").length > 0){

    var url = "ajax/data-administradores.php?text="+text+"&between1="+$("#between1").val()+"&between2="+$("#between2").val()+"&token="+localStorage.getItem("token_user");

    var columns = [
        {"data": "id_user"},
        {"data": "picture_user", "orderable":false, "search":false},
        {"data": "displayname_user"},
        {"data": "username_user"},
        {"data": "email_user"},
        {"data": "country_user"},
        {"data": "city_user"},
        {"data": "date_created_user"},
        {"data": "actions", "orderable":false}
    ];

    page = "administradores";

}

/*=====================================================================
    TODO: Validamos tabla de usuarios
=====================================================================*/

if($(".tableUsers").length > 0){

    var url = "ajax/data-usuarios.php?text="+text+"&between1="+$("#between1").val()+"&between2="+$("#between2").val()+"&token="+localStorage.getItem("token_user");

    var columns = [
        {"data": "id_user"},
        {"data": "picture_user", "orderable":false, "search":false},
        {"data": "displayname_user"},
        {"data": "username_user"},
        {"data": "email_user"},
        {"data": "method_user"},
        {"data": "country_user"},
        {"data": "city_user"},
        {"data": "address_user"},
        {"data": "phone_user"},
        {"data": "date_created_user"}
    ];

    page = "usuarios";

}

/*=====================================================================
    TODO: Validamos tabla de categorias
=====================================================================*/

if($(".tableCategories").length > 0){

    var url = "ajax/data-categorias.php?text="+text+"&between1="+$("#between1").val()+"&between2="+$("#between2").val()+"&token="+localStorage.getItem("token_user");

    var columns = [
        {"data": "id_category"},
        {"data": "image_category", "orderable":false, "search":false},
        {"data": "name_category"},
        {"data": "title_list_category"},
        {"data": "url_category"},
        {"data": "icon_category"},
        {"data": "views_category"},
        {"data": "date_created_category"},
        {"data": "actions", "orderable":false}
    ];

    page = "categorias";

}

/*=====================================================================
    TODO: Validamos tabla de Subcategorias
=====================================================================*/

if($(".tableSubcategories").length > 0){

    var url = "ajax/data-subcategorias.php?text="+text+"&between1="+$("#between1").val()+"&between2="+$("#between2").val()+"&token="+localStorage.getItem("token_user");

    var columns = [
        {"data": "id_subcategory"},
        {"data": "name_subcategory"},
        {"data": "name_category"},
        {"data": "title_list_subcategory"},
        {"data": "url_subcategory"},
        {"data": "views_subcategory"},
        {"data": "date_created_subcategory"},
        {"data": "actions", "orderable":false}
    ];

    page = "subcategorias";

}

/*=====================================================================
    TODO: Validamos tabla de Tiendas
=====================================================================*/

if($(".tableStores").length > 0){

    var url = "ajax/data-stores.php?text="+text+"&between1="+$("#between1").val()+"&between2="+$("#between2").val()+"&token="+localStorage.getItem("token_user")+"&idAdmin="+$("#idAdmin").val();

    var columns = [
        {"data": "id_store"},
        {"data": "logo_store", "orderable":false},
        {"data": "name_store"},
        {"data": "url_store"},
        {"data": "displayname_user"},
        {"data": "cover_store", "orderable":false},
        {"data": "abstract_store", "orderable":false},
        {"data": "email_store"},
        {"data": "country_store"},
        {"data": "city_store"},
        {"data": "address_store"},
        {"data": "phone_store"},
        {"data": "socialnetwork_store", "orderable":false},
        {"data": "products_store"},
        {"data": "date_created_store"},
        {"data": "actions", "orderable":false}
    ];

    page = "tiendas";

}

/*=====================================================================
    TODO: Validamos tabla de Productos
=====================================================================*/

if($(".tableProducts").length > 0){

    var url = "ajax/data-products.php?text="+text+"&between1="+$("#between1").val()+"&between2="+$("#between2").val()+"&token="+localStorage.getItem("token_user")+"&idAdmin="+$("#idAdmin").val();

    var columns = [
        { "data": "id_product" },
        { "data": "actions", "orderable": false  },
        { "data": "feedback", "orderable": false },
        { "data": "state", "orderable": false },
        { "data": "name_store" },
        { "data": "image_product", "orderable": false  },
        { "data": "name_product" },
        { "data": "name_category" },
        { "data": "name_subcategory" },
        { "data": "price_product" },
        { "data": "shipping_product" },
        { "data": "stock_product" },
        { "data": "delivery_time_product" },
        { "data": "offer_product", "orderable": false   } ,
        { "data": "summary_product", "orderable": false   },
        { "data": "specifications_product", "orderable": false   },
        { "data": "details_product", "orderable": false   },
        { "data": "description_product", "orderable": false   },
        { "data": "gallery_product", "orderable": false   },
        { "data": "top_banner_product", "orderable": false   },
        { "data": "default_banner_product", "orderable": false   },
        { "data": "horizontal_slider_product", "orderable": false   },
        { "data": "vertical_slider_product", "orderable": false   },
        { "data": "video_product", "orderable": false   },
        { "data": "tags_product", "orderable": false   },
        { "data": "views_product"  },
        { "data": "sales_product" },
        { "data": "reviews_product", "orderable": false },
        { "data": "date_created_product" }
    ];

    page = "productos";

}

/*=====================================================================
    TODO: Ejecutamos DataTable
=====================================================================*/

    var adminsTable = $("#TablaAdministradores").DataTable({

        "responsive": true,
        "lengthChange": true,
        "aLengthMenu":[[10, 50, 100, 500, 1000],[10, 50, 100, 500, 1000]],
        "autoWidth": false,
        "processing": true,
        "serverSide": true,
        "order": [[0,"desc"]],
        "ajax":{
            "url": url,
            "type":"POST"
        },
        "columns": columns,
        "language": {

            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
            "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        },
        "buttons": [

            { extend:"copy",className:"btn-dark"},
            { extend:"csv",className:"btn-dark"},
            { extend:"excel",className:"btn-dark"},
            { extend:"pdf",className:"btn-dark",orientation:"landscape"},
            { extend:"print",className:"btn-dark"},
            { extend:"colvis",className:"btn-dark"}

        ],
        fnDrawCallback:function(oSettings){
            if(oSettings.aoData.length == 0){
                $('.dataTables_paginate').hide();
                $('.dataTables_info').hide();
            }
        }

    })

        if(text == "flat"){

            $("#TablaAdministradores").on("draw.dt", function(){

                setTimeout(function(){

                    adminsTable.buttons().container().appendTo('#TablaAdministradores_wrapper .col-md-6:eq(0)');

                },100);

            })

        }

};

execDatatable("html");

/*================================================================
    TODO: Ejecutar reporte
================================================================*/

function reportActive(event){

    if(event.target.checked){

        $("#TablaAdministradores").dataTable().fnClearTable();
        $("#TablaAdministradores").dataTable().fnDestroy();

        setTimeout(function(){

            execDatatable("flat");

        },100);

    }else{

        $("#TablaAdministradores").dataTable().fnClearTable();
        $("#TablaAdministradores").dataTable().fnDestroy();

        setTimeout(function(){

            execDatatable("html");

        },100);

    }

}

/*================================================================
    TODO: Rango de fechas
================================================================*/

$('#daterange-btn').daterangepicker(
    {

        /*================================================================
            TODO: Traducir daterangepicker a español
        ================================================================*/

    "locale": {
        "format": "YYYY-MM-DD",
        "separator": " - ",
        "applyLabel": "Aplicar",
        "cancelLabel": "Cancelar",
        "fromLabel": "Desde",
        "toLabel": "Hasta",
        "customRangeLabel": "Rango Personalizado",
        "daysOfWeek": [
            "Do",
            "Lu",
            "Ma",
            "Mi",
            "Ju",
            "Vi",
            "Sa"
        ],
        "monthNames": [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre"
        ],
        "firstDay": 1
    },

        ranges   : {
        'Hoy'       : [moment(), moment()],
        'Ayer'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Últimos 7 días' : [moment().subtract(6, 'days'), moment()],
        'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
        'Este Mes'  : [moment().startOf('month'), moment().endOf('month')],
        'Último Mes'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
        'Este Año': [moment().startOf('year'), moment().endOf('year')],
        'Último Año'  : [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
    },

        startDate: moment($("#between1").val()),
        endDate  : moment($("#between2").val())

    },

    function (start, end) {

        window.location = page+"?start="+start.format('YYYY-MM-DD')+"&end="+end.format('YYYY-MM-DD');

    },

)


/*================================================================
    TODO: Eliminar registro
================================================================*/

$(document).on("click",".removeItem",function(){

    var idItem = $(this).attr("idItem");
    var table = $(this).attr("table");
    var suffix = $(this).attr("suffix");
    var deleteFile = $(this).attr("deleteFile");
    var page = $(this).attr("page");

    fncSweetAlert("confirm","¿Estás segur@ de eliminar este registro?","").then(resp=>{

        if(resp){

            var data = new FormData();
            data.append("idItem", idItem);
            data.append("table", table);
            data.append("suffix", suffix);
            data.append("token", localStorage.getItem("token_user"));
            data.append("deleteFile", deleteFile);

            $.ajax({

                url: "ajax/ajax-delete.php",
                method: "POST",
                data: data,
                contentType: false,
                cache: false,
                processData: false,
                success: function (response){

                    if(response == 200){

                        fncSweetAlert(
                            "success",
                            "El registro ha sido eliminado con éxito.",
                            "/"+page
                        );

                    }else if(response == "no-delete"){

                        fncSweetAlert(
                            "error",
                            "El registro tiene datos relacionados.",
                            "/"+page
                        );

                    }else{

                        fncNotie(3, "Error al eliminar el registro.");

                    }

                }

            })

        }

    })
})


/*================================================================
    TODO: Cambiar estado del producto
================================================================*/

function changeState(event, idProduct){

    if(event.target.checked){

        var state = "show";

    }else{

        var state = "hidden";

    }


    var data = new FormData();
    data.append("state", state);
    data.append("idProduct", idProduct);
    data.append("token", localStorage.getItem("token_user"));


    $.ajax({
        url: "ajax/ajax-state.php",
        method: "POST",
        data: data,
        contentType: false,
        cache: false,
        processData: false,
        success: function(response){

            if(response == 200){

                fncNotie(1, "El registro a sido actualizado");

            }else{

                fncNotie(3, "Error al actualizar el registro");
            }

        }

    })

}


/*================================================================
    TODO: Feedback
================================================================*/

$(document).on("click",".feedback", function(){

    var  idProduct = $(this).attr("idProduct");
    var  approval = $(this).attr("approval");

    $("[name='idProduct']").val(idProduct);

    if(approval == "approved"){

        $("#approval_product").prop("checked",true);

    }else{

        $("#approval_product").prop("checked",false);
    }

    $("#myFeedback").modal();

    })