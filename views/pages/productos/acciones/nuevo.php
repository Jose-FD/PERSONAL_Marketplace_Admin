<?php

	$url = "stores?select=id_store,name_store&linkTo=id_user_store&equalTo=".$_SESSION["admin"]->id_user;
	$method = "GET";
	$fields = array();

	$stores = CurlController::request($url,$method,$fields);

	if($stores->status == 200){

		$stores = $stores->results;

	}else{

		echo '<script>

                fncSweetAlert("error", "El administrador no tiene una tienda creada.", "/tiendas");

            </script>';

	}


?>

<div class="card card-dark card-outline">

    <form method="post" class="needs-validation" novalidate enctype="multipart/form-data">

        <div class="card-header">

            <div class="col-md-8 offset-md-2">

                <?php

                    require_once "controllers/products.controller.php";

                    $create = new ProductsController();
                    $create -> create();

                ?>

                    <label class="text-danger float-right"><sup>*</sup> Requerido</label>

                    <!--==================================================
                        TODO: Nombre de la Tienda
                    ===================================================-->

                    <div class="form-group mt-5">
                        <label>Nombre de la Tienda<sup class="text-danger">*</sup></label>

                        <select class="form-control select2" name="nombre-tienda" required>
                            <option value>Seleccionar Tienda</option>

                            <?php foreach ($stores as $key => $value): ?>

                                <option value="<?php echo $value->id_store ?>"><?php echo $value->name_store ?></option>

                            <?php endforeach ?>

                        </select>

                            <div class="valid-feedback">Campo Valido.</div>
                            <div class="invalid-feedback">Por favor rellene este campo.</div>

                    </div>

                    <!--==================================================
                        TODO: Nombre del Producto
                    ===================================================-->

                    <div class="form-group mt-2">
                        <label>Nombre del Producto<sup class="text-danger">*</sup></label>

                        <input
                            type="text"
                            class="form-control"
                            pattern="[0-9A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,50}"
                            onchange="validateRepeat(event,'text&number','products','name_product')"
                            maxlength="50"
                            name="name-product"
                            required>

                            <div class="valid-feedback">Campo Valido.</div>
                            <div class="invalid-feedback">Por favor rellene este campo.</div>

                    </div>

                    <!--==================================================
                        TODO: URL del Producto
                    ===================================================-->

                    <div class="form-group mt-2">

                        <label>Url del Producto<sup class="text-danger">*</sup></label>

                        <input
                        type="text"
                        class="form-control"
                        readonly
                        name="url-name_product"
                        required>

                    </div>

                    <!--==================================================
                        TODO: Categoria del Producto
                    ===================================================-->

                    <div class="form-group mt-2">

                        <label>Categoria<sup class="text-danger">*</sup></label>

                        <?php

                            $url = "categories?select=id_category,name_category,url_category";
                            $method = "GET";
                            $fields = array();

                            $categories = CurlController::request($url, $method, $fields)->results;

                        ?>

                        <div class="form-group">

                            <select
                                class="form-control select2"
                                name="name-category"
                                style="width:100%"
                                onchange="changeCategory(event, 'products')"
                                required>

                                <option value="">Seleccionar categoria</option>

                                <?php foreach ($categories as $key => $value): ?>

                                    <option value="<?php echo $value->id_category ?>_<?php echo $value->url_category ?>"><?php echo $value->name_category ?></option>

                                <?php endforeach ?>

                            </select>

                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>

                        </div>

                    </div>

                    <!--==================================================
                        TODO: Subcategoría del Producto
                    ===================================================-->

                    <div class="form-group selectSubcategory" style="display:none">

                        <label>Subcategoría<sup class="text-danger">*</sup></label>

                        <div class="form-group__content">

                            <select class="form-control" name="name-subcategory" required>

                                <option value="">Seleccionar Subcategoría</option>

                            </select>

                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>

                        </div>

                    </div>

                    <!--==================================================================
                        TODO: Precio de venta, precio de envío, dias de entrega y stock
                    ===================================================================-->

                    <div class="form-group mt-2">
                        <div class="row mb-3">

                            <!--==================================================
                                TODO: Precio de Venta
                            ===================================================-->

                            <div class="col-12 col-lg-3">

                                <label>Precio del Producto<sup class="text-danger">*</sup></label>

                                <input type="number"
                                class="form-control"
                                name="precio-producto"
                                min="0"
                                step="any"
                                pattern="[.\\,\\0-9]{1,}"
                                onchange="validateJS(event, 'numbers')"
                                required>

                                <div class="valid-feedback">Campo Valido.</div>
                                <div class="invalid-feedback">Por favor rellene este campo.</div>

                            </div>

                            <!--==================================================
                                TODO: Precio de Envío
                            ===================================================-->

                            <div class="col-12 col-lg-3">

                                <label>Precio del Envío<sup class="text-danger">*</sup></label>

                                <input type="number"
                                class="form-control"
                                name="precioenvio-producto"
                                min="0"
                                step="any"
                                pattern="[.\\,\\0-9]{1,}"
                                onchange="validateJS(event, 'numbers')"
                                required>

                                <div class="valid-feedback">Campo Valido.</div>
                                <div class="invalid-feedback">Por favor rellene este campo.</div>

                            </div>

                            <!--==================================================
                                TODO: Días de entrega
                            ===================================================-->

                            <div class="col-12 col-lg-3">

                                <label>Tiempo de envío<sup class="text-danger">*</sup></label>

                                <input type="number"
                                class="form-control"
                                name="delivery_time-producto"
                                min="0"
                                step="any"
                                pattern="[.\\,\\0-9]{1,}"
                                onchange="validateJS(event, 'numbers')"
                                required>

                                <div class="valid-feedback">Campo Valido.</div>
                                <div class="invalid-feedback">Por favor rellene este campo.</div>

                            </div>

                            <!--==================================================
                                TODO: Stock
                            ===================================================-->

                            <div class="col-12 col-lg-3">

                                <label>Stock<sup class="text-danger">*</sup> (Max:100 unit)</label>

                                <input type="number"
                                class="form-control"
                                name="stock-producto"
                                min="0"
                                step="any"
                                pattern="[.\\,\\0-9]{1,}"
                                onchange="validateJS(event, 'numbers')"
                                required>

                                <div class="valid-feedback">Campo Valido.</div>
                                <div class="invalid-feedback">Por favor rellene este campo.</div>

                            </div>

                        </div>

                    </div>

                    <!--==================================================
                        TODO: Imagen del Producto
                    ==================================================-->

                    <div class="form-group mt-2">
                        <label>Imagen del Producto<sup class="text-danger">*</sup></label>

                        <label for="customFile" class="d-flex justify-content-center">
                            <figure class="text-center py-3">
                                <img src="<?php echo TemplateController::srcImg() ?>views/img/products/default/default-image.jpg" class="img-fluid changeImagen" style="width:150px">
                            </figure>
                        </label>

                        <div class="custom-file">
                            <input
                                type="file"
                                id="customFile"
                                class="custom-file-input"
                                accept="image/*"
                                onchange="validateImageJS(event,'changeImagen')"
                                name="imagen-producto"
                                required>

                                <div class="valid-feedback">Campo Valido.</div>
                                <div class="invalid-feedback">Por favor rellene este campo.</div>

                            <label for="customFile" class="custom-file-label">Buscar Archivo</label>
                        </div>

                    </div>

                    <!--==================================================
                        TODO: Descripción del Producto
                    ===================================================-->

                    <div class="form-group mt-2">
                        <label>Descripción del Producto<sup class="text-danger">*</sup></label>

                        <textarea
                        class="summernote"
                        name="descripcion-producto"
                        required
                        ></textarea>

                            <div class="valid-feedback">Campo Valido.</div>
                            <div class="invalid-feedback">Por favor rellene este campo.</div>

                    </div>




                    

            </div>

        </div>

        <div class="card-footer">

            <div class="col-md-8 offset-md-2">

                <div class="form-group mt-3">

                    <a href="/tiendas" class="btn btn-light border text-left">Volver</a>

                    <button type="submit" class="btn bg-dark float-right">Guardar</button>

                </div>

            </div>

        </div>

    </form>

</div>