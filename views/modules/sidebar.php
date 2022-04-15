<aside class="main-sidebar sidebar-light-warning elevation-4">
    <!-- Brand Logo -->
    <a href="../../index3.html" class="brand-link navbar-warning">
        <img src="views/assets/img/template/logo_light.png" style="opacity: .8">
        <!-- <span class="brand-text font-weight-light">AdminLTE 3</span> -->
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">

                    <img src="<?php echo TemplateController::returnImg($_SESSION["admin"]->id_user, $_SESSION["admin"]->picture_user, $_SESSION["admin"]->method_user) ?>" class="img-circle elevation-2" alt="User Image">

            </div>
            <div class="info">
                <a href="#" class="d-block"><?php echo $_SESSION["admin"]->displayname_user ?></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->

                <li class="nav-item">
                    <a href="/" class="nav-link <?php if(empty($routesArray)): ?>active<?php endif ?>">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Home
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/administradores" class="nav-link <?php if(!empty($routesArray) && $routesArray[1] == "administradores"): ?>active<?php endif ?>">
                        <i class="nav-icon fas fa-tasks"></i>
                        <p>
                            Administradores
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/usuarios" class="nav-link <?php if(!empty($routesArray) && $routesArray[1] == "usuarios"): ?>active<?php endif ?>">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Usuarios
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/categorias" class="nav-link <?php if(!empty($routesArray) && $routesArray[1] == "categorias"): ?>active<?php endif ?>">
                        <i class="nav-icon fas fa-list"></i>
                        <p>
                            Categorias
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/subcategorias" class="nav-link <?php if(!empty($routesArray) && $routesArray[1] == "subcategorias"): ?>active<?php endif ?>">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Sub-Categorias
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/tiendas" class="nav-link <?php if(!empty($routesArray) && $routesArray[1] == "tiendas"): ?>active<?php endif ?>">
                        <i class="nav-icon fas fa-store"></i>
                        <p>
                            Tiendas
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/productos" class="nav-link <?php if(!empty($routesArray) && $routesArray[1] == "productos"): ?>active<?php endif ?>">
                        <i class="nav-icon fas fa-shopping-bag"></i>
                        <p>
                            Productos
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/ordenes" class="nav-link <?php if(!empty($routesArray) && $routesArray[1] == "ordenes"): ?>active<?php endif ?>">
                        <i class="nav-icon fas fa-shopping-basket"></i>
                        <p>
                            Ordenes
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/ventas" class="nav-link <?php if(!empty($routesArray) && $routesArray[1] == "ventas"): ?>active<?php endif ?>">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>
                            Ventas
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/disputas" class="nav-link <?php if(!empty($routesArray) && $routesArray[1] == "disputas"): ?>active<?php endif ?>">
                        <i class="nav-icon fas fa-comment-alt"></i>
                        <p>
                            Disputas
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/mensajes" class="nav-link <?php if(!empty($routesArray) && $routesArray[1] == "mensajes"): ?>active<?php endif ?>">
                        <i class="nav-icon fas fa-comments"></i>
                        <p>
                            Mensajes
                        </p>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>