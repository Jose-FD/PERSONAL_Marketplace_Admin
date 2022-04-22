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

        <table id="TablaAdministradores" class="table table-bordered table-striped tableSales">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Status</th>
                    <th>Comision</th>
                    <th>Precio Unitario</th>
                    <th>Total</th>
                    <th>Tienda</th>
                    <th>Cliente</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Método de Pago</th>
                    <th>ID de Pago</th>
                    <th>Fecha</th>
                </tr>
            </thead>

        </table>
    </div>
    <!-- /.card-body -->
</div>

<script src="views/assets/custom/datatable/datatable.js"></script>