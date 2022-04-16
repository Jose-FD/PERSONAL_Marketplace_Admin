<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Tiendas</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>

                    <?php

                        if(isset($routesArray[2])){

                            if($routesArray[2] == "nuevo" || $routesArray[2] == "editar"){

                                echo '<li class="breadcrumb-item"><a href="/tiendas">Tiendas</a></li>';
                                echo '<li class="breadcrumb-item active">'.$routesArray[2].'</li>';

                            }

                        }else{

                            echo '<li class="breadcrumb-item active">Tiendas</li>';

                        }

                    ?>

                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content pb-1">

    <div class="container-fluid">

    <?php

        if(isset($routesArray[2])){

            if($routesArray[2] == "nuevo" || $routesArray[2] == "editar"){

                include "acciones/".$routesArray[2].".php";
            }

        }else{

            include "acciones/listar.php";

        }

    ?>

    </div>

</section>
<!-- /.content -->