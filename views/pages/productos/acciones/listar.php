<?php

    if(isset($_GET["start"]) && isset($_GET["end"])){

        $between1 = $_GET["start"];
        $between2 = $_GET["end"];

    }else{

        $between1 = date("Y-m-d", strtotime("-100000 day", strtotime(date("Y-m-d"))));
        $between2 = date("Y-m-d");

    }

?>

<input type="hidden" id="between1" value="<?php echo $between1 ?>">
<input type="hidden" id="between2" value="<?php echo $between2 ?>">

<div class="card">
    <div class="card-header">
        <h3 class="card-title">

            <a class="btn bg-dark btn-sm" href="/productos/nuevo">Nuevo Producto</a>

        </h3>

        <div class="card-tools">

            <div class="d-flex">

                <div class="d-flex mr-2">
                    <span class="mr-2">Reportes</span>
                    <input type="checkbox" name="my-checkbox" data-bootstrap-switch data-off-color="light" data-on-color="dark" data-size="mini" data-handle-width="70" onchange="reportActive(event)">
                </div>

                <div class="input-group">
                    <button type="button" class="btn float-right" id="daterange-btn">
                        <i class="far fa-calendar-alt mr-2"></i>
                        <?php if($between1 < "2000"){ echo "Start"; }else{ echo $between1; } ?> - <?php echo $between2 ?>
                        <i class="fas fa-caret-down ml-2"></i>
                    </button>
                </div>

            </div>

        </div>

    </div>
    <!-- /.card-header -->
    <div class="card-body">

        <input type="hidden" id="idAdmin" value="<?php echo $_SESSION["admin"]->id_user ?>">

        <table id="TablaAdministradores" class="table table-bordered table-striped tableProducts">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Acciones</th>
                    <th>Feedback</th>
                    <th>Estado</th>
                    <th>Tienda</th>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Categoria</th>
                    <th>Subcategoria</th>
                    <th>Precio</th>
                    <th>Precio de Envio</th>
                    <th>Stock</th>
                    <th>Tiempo de Entrega</th>
                    <th>Oferta</th>
                    <th>Resumen</th>
                    <th>Especificaciones</th>
                    <th>Detalles</th>
                    <th>Descripción</th>
                    <th>Galleria</th>
                    <th>Banner Superior</th>
                    <th>Banner por defecto</th>
                    <th>Horzontal Slider</th>
                    <th>Vertical Slider</th>
                    <th>Video</th>
                    <th>Tags</th>
                    <th>Vistas</th>
                    <th>Ventas</th>
                    <th>Reseñas</th>
                    <th>Fecha de Creación</th>
                </tr>
            </thead>

        </table>
    </div>
    <!-- /.card-body -->
</div>

<script src="views/assets/custom/datatable/datatable.js"></script>

<!-- Modal de FeedBack-->
<div class="modal" id="myFeedback">
    <div class="modal-dialog">
        <div class="modal-content">

            <form method="post" class="needs-validation" novalidate >

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Proceso de Aprobación</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">

                    <input type="hidden" name="idProduct">

                    <div class="form-group">

                        <div class='custom-control custom-switch'>

                            <input type='checkbox' class='custom-control-input' id="approval_product" name='approval_product'>

                            <label class='custom-control-label' for='approval_product'>Aprovar</label>

                        </div>

                        <hr>

                        <label>Escribe tu feedback</label>

                        <textarea
                        class="form-control"
                        name="feedback_product"
                        pattern='[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                        onchange="validateJS(event,'regex')"
                        required
                        ></textarea>

                        <div class="valid-feedback">Campo Valido.</div>
                        <div class="invalid-feedback">Por favor rellene este campo.</div>

                    </div>

                </div>

                <!-- Modal footer -->
                <div class="modal-footer d-flex justify-content-between">

                <?php

                    require_once "controllers/products.controller.php";

                    $approval = new ProductsController();
                    $approval -> approval();

                ?>

                <div><button type="button" class="btn btn-light border" data-dismiss="modal">Cerrar</button></div>
                <div><button type="submit" class="btn btn-dark">Guardar</button></div>

                </div>

            </form>

        </div>
    </div>
</div>