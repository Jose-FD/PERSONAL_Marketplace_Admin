<div class="card card-dark card-outline">

    <form method="post" class="needs-validation" novalidate>

        <div class="card-header">

            <div class="col-md-8 offset-md-2">

                <?php

                    require_once "controllers/subcategories.controller.php";

                    $create = new SubcategoriesController();
                    $create -> create();

                ?>

                    <!--==================================================
                        TODO: Nombre de Subcategoria
                    ==================================================-->

                    <div class="form-group mt-5">
                        <label>Nombre</label>
                        <input
                            type="text"
                            class="form-control"
                            pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}"
                            onchange="validateRepeat(event,'text','subcategories','name_subcategory')"
                            name="nombre-subcategory"
                            required>

                            <div class="valid-feedback">Campo Valido.</div>
                            <div class="invalid-feedback">Por favor rellene este campo.</div>

                    </div>

                    <!--==================================================
                        TODO: URL de la Subcategoria
                    ==================================================-->

                    <div class="form-group mt-2">
                        <label>URL</label>
                        <input
                            type="text"
                            class="form-control"
                            readonly
                            name="url-name_subcategory"
                            required>

                    </div>

                    <!--==================================================
                        TODO: Categoria
                    ==================================================-->

                    <div class="form-group mt-2">

                        <label>Categoria<sup class="text-danger">*</sup></label>

                        <?php

                            $url = "categories?select=id_category,name_category";
                            $method = "GET";
                            $fields = array();

                            $categories = CurlController::request($url, $method, $fields)->results;

                        ?>

                        <div class="form-group">

                            <select
                                class="form-control select2"
                                name="category-subcategory"
                                style="width:100%"
                                onchange="changeCategory(event, 'subcategories')"
                                required>

                                <option value="">Seleccionar categoria</option>

                                <?php foreach ($categories as $key => $value): ?>

                                    <option value="<?php echo $value->id_category ?>"><?php echo $value->name_category ?></option>

                                <?php endforeach ?>

                            </select>

                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>

                        </div>

                    </div>

                    <!--==================================================
                        TODO: Listado de títulos de subcategoría
                    ==================================================-->

                    <div class="form-group titleList" style="display:none">

                        <label>Listado de títulos<sup class="text-danger">*</sup></label>

                        <div class="form-group__content">

                            <select class="form-control" name="titleList-subcategory" required>

                                <option value="">Select Title List</option>

                            </select>

                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>

                        </div>

                    </div>



            </div>

        </div>

        <div class="card-footer">

            <div class="col-md-8 offset-md-2">

                <div class="form-group mt-3">

                    <a href="/subcategorias" class="btn btn-light border text-left">Volver</a>

                    <button type="submit" class="btn bg-dark float-right">Guardar</button>

                </div>

            </div>

        </div>

    </form>

</div>