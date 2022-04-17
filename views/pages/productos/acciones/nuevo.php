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

                    <!--==================================================
                        TODO: Palabras Claves
                    ==================================================-->

                    <div class="form-group mt-2">
                        <label>Tags Producto</label>
                        <input
                            type="text"
                            class="form-control tags-input"
                            pattern='[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                            onchange="validateJS(event,'regex')"
                            name="tags-producto"
                            required>

                            <div class="valid-feedback">Campo Valido.</div>
                            <div class="invalid-feedback">Por favor rellene este campo.</div>

                    </div>

                    <!--==================================================
                        TODO: Resumen del Producto
                    ==================================================-->

                    <div class="form-group mt-2">

						<label>Resumen del Producto<sup class="text-danger">*</sup> Ex: 20 hours of portable capabilities</label>

						<input type="hidden" name="inputSummary" value="1">

						<div class="input-group mb-3 inputSummary">

							<div class="input-group-append">
								<span class="input-group-text">
									<button type="button" class="btn btn-danger btn-sm border-0" onclick="removeInput(0,'inputSummary')">&times;</button>
								</span>
							</div>

							<input
							class="form-control py-4"
							type="text"
							name="summary-product_0"
							pattern='[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
							onchange="validateJS(event,'regex')"
							required>

							<div class="valid-feedback">Campo Valido.</div>
                            <div class="invalid-feedback">Por favor rellene este campo.</div>

						</div>

						<button type="button" class="btn btn-primary mb-2" onclick="addInput(this, 'inputSummary')">Adicionar Resumen</button>

					</div>

                    <!--==================================================
                        TODO: Detalles del Producto
                    ==================================================-->

                    <div class="form-group mt-2">

						<label>Detalles del Producto<sup class="text-danger">*</sup> Ex: <strong>Title:</strong> Bluetooth, <strong>Value:</strong> Yes</label>

						<input type="hidden" name="inputDetails" value="1">

						<div class="input-group mb-3 inputDetails">

                            <!--==================================================
                                TODO: Entrada para el título del detalle
                            ==================================================-->

							<div class="col-12 col-lg-6 input-group">

                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <button type="button" class="btn btn-danger btn-sm border-0" onclick="removeInput(0,'inputDetails')">&times;</button>
                                    </span>
                                </div>

                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        Titulo:
                                    </span>
                                </div>

                                <input
                                class="form-control py-4"
                                type="text"
                                name="details-title-product_0"
                                pattern='[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                                onchange="validateJS(event,'regex')"
                                required>

                                <div class="valid-feedback">Campo Valido.</div>
                                <div class="invalid-feedback">Por favor rellene este campo.</div>

                            </div>

                            <!--==================================================
                                TODO: Entrada para valores del detalle
                            ==================================================-->

							<div class="col-12 col-lg-6 input-group">

                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        Valor:
                                    </span>
                                </div>

                                <input
                                class="form-control py-4"
                                type="text"
                                name="details-value-product_0"
                                pattern='[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                                onchange="validateJS(event,'regex')"
                                required>

                                <div class="valid-feedback">Campo Valido.</div>
                                <div class="invalid-feedback">Por favor rellene este campo.</div>

                            </div>

                        </div>

						<button type="button" class="btn btn-primary mb-2" onclick="addInput(this, 'inputDetails')">Adicionar Detalle</button>

					</div>

                    <!--==================================================
                        TODO: Especificaciones técnicas del Producto
                    ==================================================-->

                    <div class="form-group mt-2">

						<label>Especificaciones del Producto<strong>Type:</strong> Color, <strong>Values:</strong> Black, Red, White</label>

						<input type="hidden" name="inputSpecifications" value="1">

						<div class="input-group mb-3 inputSpecifications">

                            <!--==================================================
                                TODO: Entrada para el tipo de especificación
                            ==================================================-->

							<div class="col-12 col-lg-6 input-group">

                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <button type="button" class="btn btn-danger btn-sm border-0" onclick="removeInput(0,'inputSpecifications')">&times;</button>
                                    </span>
                                </div>

                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        Tipo:
                                    </span>
                                </div>

                                <input
                                class="form-control py-4"
                                type="text"
                                name="spec-type-product_0"
                                pattern='[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                                onchange="validateJS(event,'regex')"
                                required>

                                <div class="valid-feedback">Campo Valido.</div>
                                <div class="invalid-feedback">Por favor rellene este campo.</div>

                            </div>

                            <!--==================================================
                                TODO: Entrada para valores de la especificación
                            ==================================================-->

							<div class="col-12 col-lg-6 input-group">

                                <input
                                class="form-control py-4 tags-input"
                                type="text"
                                name="spec-value-product_0"
                                pattern='[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                                onchange="validateJS(event,'regex')"
                                required>

                                <div class="valid-feedback">Campo Valido.</div>
                                <div class="invalid-feedback">Por favor rellene este campo.</div>

                            </div>

                        </div>

						<button type="button" class="btn btn-primary mb-2" onclick="addInput(this, 'inputSpecifications')">Adicionar Especificaciones</button>

					</div>

                    <!--==================================================
                        TODO: Galería del Producto
                    ==================================================-->

                    <div class="form-group mt-2">

                        <label>Galería del Producto: <sup class="text-danger">*</sup></label> 

                        <div class="dropzone mb-3">

                            <div class="dz-message">

                                Suelta tus imágenes aquí, tamaño máximo 500px * 500px

                            </div>

                        </div>

                        <input type="hidden" name="galeria-producto">

                    </div>

                    <!--==================================================
                        TODO: Video del Producto
                    ==================================================-->

                    <div class="form-group mt-2">

                        <label>Video del Producto | Ejem: <strong>Type:</strong> YouTube, <strong>Id:</strong> Sl5FaskVpD4</label> 

                        <div class="row mb-3">

                            <div class="col-12 col-lg-6 input-group mx-0 pr-0">

                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        Type:
                                    </span>
                                </div>

                                <select
                                class="form-control"
                                name="type_video"
                                >
                                    <option value="">Seleccionar Plataforma</option>
                                    <option value="youtube">YouTube</option>
                                    <option value="vimeo">Vimeo</option>

                                </select>

                            </div>

                            <div class="col-12 col-lg-6  input-group mx-0">

                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        Id:
                                    </span>
                                </div>

                                <input
                                type="text"
                                class="form-control"
                                name="id_video"
                                pattern="[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\'\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,100}"
                                maxlength="100"
                                onchange="validateJS(event,'regex')"
                                >

                                <div class="valid-feedback">Campo Valido.</div>
                                <div class="invalid-feedback">Por favor rellene este campo.</div>

                            </div>

                        </div>


                    </div>


                    <!--==================================================
                        TODO: Banner Top del Producto
                    ==================================================-->

                    <div class="form-group mt-2">

                        <label>Banner Top del Producto<sup class="text-danger">*</sup>, Ejem:</label>

                        <figure class="pb-5">

                            <img src="<?php echo TemplateController::srcImg() ?>views/img/products/default/example-top-banner.png" class="img-fluid">

                        </figure>

                        <div class="row mb-5">

                            <!--==================================================
                                TODO: H3 Tag
                            ==================================================-->

                            <div class="col-12 col-lg-6 input-group mx-0 pr-0 mb-3">

                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        H3 Tag:
                                    </span>
                                </div>

                                <input
                                type="text"
                                class="form-control"
                                placeholder="Ex: 20%"
                                name="topBannerH3Tag"
                                pattern="[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\'\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}"
                                maxlength="50"
                                onchange="validateJS(event,'regex')"
                                required
                                >

                                <div class="valid-feedback">Campo Valido.</div>
                                <div class="invalid-feedback">Por favor rellene este campo.</div>

                            </div>

                            <!--==================================================
                                TODO: P1 Tag
                            ==================================================-->

                            <div class="col-12 col-lg-6 input-group mx-0 mb-3">

                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        P1 Tag:
                                    </span>
                                </div>

                                <input type="text"
                                class="form-control"
                                placeholder="Ex: Disccount"
                                name="topBannerP1Tag"
                                pattern="[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\'\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}"
                                maxlength="50"
                                onchange="validateJS(event,'regex')"
                                required
                                >

                                <div class="valid-feedback">Campo Valido.</div>
                                <div class="invalid-feedback">Por favor rellene este campo.</div>

                            </div>

                            <!--==================================================
                                TODO: H4 Tag
                            ==================================================-->

                            <div class="col-12 col-lg-6 input-group mx-0 pr-0 mb-3">

                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        H4 Tag:
                                    </span>
                                </div>

                                <input type="text"
                                class="form-control"
                                placeholder="Ex: For Books Of March"
                                name="topBannerH4Tag"
                                pattern="[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\'\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}"
                                maxlength="50"
                                onchange="validateJS(event,'regex')"
                                required
                                >

                                <div class="valid-feedback">Campo Valido.</div>
                                <div class="invalid-feedback">Por favor rellene este campo.</div>

                            </div>

                            <!--==================================================
                                TODO: P2 Tag
                            ==================================================-->

                            <div class="col-12 col-lg-6 input-group mx-0 mb-3">

                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        P2 Tag:
                                    </span>
                                </div>

                                <input type="text"
                                class="form-control"
                                placeholder="Ex: Enter Promotion"
                                name="topBannerP2Tag"
                                pattern="[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\'\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}"
                                maxlength="50"
                                onchange="validateJS(event,'regex')"
                                required
                                >

                                <div class="valid-feedback">Campo Valido.</div>
                                <div class="invalid-feedback">Por favor rellene este campo.</div>

                            </div>

                            <!--==================================================
                                TODO: Span Tag
                            ==================================================-->

                            <div class="col-12 col-lg-6 input-group mx-0 pr-0 mb-3">

                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        Span Tag:
                                    </span>
                                </div>

                                <input
                                type="text"
                                class="form-control"
                                placeholder="Ex: Sale2019"
                                name="topBannerSpanTag"
                                pattern="[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\'\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}"
                                maxlength="50"
                                onchange="validateJS(event,'regex')"
                                required
                                >

                                <div class="valid-feedback">Campo Valido.</div>
                                <div class="invalid-feedback">Por favor rellene este campo.</div>

                            </div>

                            <!--==================================================
                                TODO: Button Tag
                            ==================================================-->

                            <div class="col-12 col-lg-6 input-group mx-0 mb-3">

                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        Button Tag:
                                    </span>
                                </div>

                                <input
                                type="text"
                                class="form-control"
                                placeholder="Ex: Shop now"
                                name="topBannerButtonTag"
                                pattern="[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\'\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}"
                                maxlength="50"
                                onchange="validateJS(event,'regex')"
                                required
                                >

                                <div class="valid-feedback">Campo Valido.</div>
                                <div class="invalid-feedback">Por favor rellene este campo.</div>

                            </div>

                            <!--==================================================
                                TODO: IMG Tag
                            ==================================================-->

                            <div class="col-12">

                                <label>IMG Tag:</label>

                                <div class="form-group__content">

                                    <label class="pb-5" for="topBanner">
                                    <img src="<?php echo TemplateController::srcImg() ?>views/img/products/default/default-top-banner.jpg" class="img-fluid changeTopBanner">
                                    </label>

                                    <div class="custom-file">

                                        <input type="file"
                                        class="custom-file-input"
                                        id="topBanner"
                                        name="topBanner"
                                        accept="image/*"
                                        maxSize="2000000"
                                        onchange="validateImageJS(event, 'changeTopBanner')"
                                        required>

                                        <div class="valid-feedback">Campo Valido.</div>
                                        <div class="invalid-feedback">Por favor rellene este campo.</div>

                                        <label class="custom-file-label" for="topBanner">Choose file</label>

                                    </div>

                                </div>

                            </div>


                        </div>

                    </div>

                    <!--==================================================
                        TODO: Banner por defecto del Producto
                    ==================================================-->

                    <div class="form-group mt-2">

                        <label>Banner por defecto del Producto<sup class="text-danger">*</sup></label>

                        <div class="form-group__content">

                            <label class="pb-5" for="defaultBanner">
                            <img src="<?php echo TemplateController::srcImg() ?>views/img/products/default/default-banner.jpg" class="img-fluid changeDefaultBanner" style="width:500px">
                            </label>

                            <div class="custom-file">

                                <input type="file"
                                class="custom-file-input"
                                id="defaultBanner"
                                name="defaultBanner"
                                accept="image/*"
                                maxSize="2000000"
                                onchange="validateImageJS(event, 'changeDefaultBanner')"
                                required>

                                <div class="valid-feedback">Campo Valido.</div>
                                <div class="invalid-feedback">Por favor rellene este campo.</div>

                                <label class="custom-file-label" for="defaultBanner">Choose file</label>

                            </div>

                        </div>

                    </div>

                    <!--==================================================
                        TODO: Slider Horizontal del Producto
                    ==================================================-->

                    <div class="form-group mt-2">

                        <label>Slider Horizontal del Producto<sup class="text-danger">*</sup>, Ex:</label>

                        <figure class="pb-5">

                            <img src="<?php echo TemplateController::srcImg() ?>views/img/products/default/example-horizontal-slider.png" class="img-fluid">

                        </figure>

                        <div class="row mb-3">

                            <!--==================================================
                                TODO: H4 Tag
                            ==================================================-->

                            <div class="col-12 col-lg-6 input-group mx-0 pr-0 mb-3">

                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        H4 Tag:
                                    </span>
                                </div>

                                <input type="text"
                                class="form-control"
                                placeholder="Ex: Limit Edition"
                                name="hSliderH4Tag"
                                pattern="[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\'\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}"
                                maxlength="50"
                                onchange="validateJS(event,'regex')"
                                required
                                >

                                <div class="valid-feedback">Campo Valido.</div>
                                <div class="invalid-feedback">Por favor rellene este campo.</div>

                            </div>

                            <!--==================================================
                                TODO: H3-1 Tag
                            ==================================================-->

                            <div class="col-12 col-lg-6 input-group mx-0 mb-3">

                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        H3-1 Tag:
                                    </span>
                                </div>

                                <input type="text"
                                class="form-control"
                                placeholder="Ex: Happy Summer"
                                name="hSliderH3_1Tag"
                                pattern="[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\'\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}"
                                maxlength="50"
                                onchange="validateJS(event,'regex')"
                                required
                                >

                                <div class="valid-feedback">Campo Valido.</div>
                                <div class="invalid-feedback">Por favor rellene este campo.</div>

                            </div>

                            <!--==================================================
                                TODO: H3-2 Tag
                            ==================================================-->

                            <div class="col-12 col-lg-6 input-group mx-0 pr-0 mb-3">

                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        H3-2 Tag:
                                    </span>
                                </div>

                                <input type="text"
                                class="form-control"
                                placeholder="Ex: Combo Super Cool"
                                name="hSliderH3_2Tag"
                                pattern="[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\'\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}"
                                maxlength="50"
                                onchange="validateJS(event,'regex')"
                                required
                                >

                                <div class="valid-feedback">Campo Valido.</div>
                                <div class="invalid-feedback">Por favor rellene este campo.</div>

                            </div>

                            <!--==================================================
                                TODO: H3-3 Tag
                            ==================================================-->

                            <div class="col-12 col-lg-6 input-group mx-0 mb-3">

                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        H3-3 Tag:
                                    </span>
                                </div>

                                <input type="text"
                                class="form-control"
                                placeholder="Ex: Up to"
                                name="hSliderH3_3Tag"
                                pattern="[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\'\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}"
                                maxlength="50"
                                onchange="validateJS(event,'regex')"
                                required
                                >

                                <div class="valid-feedback">Campo Valido.</div>
                                <div class="invalid-feedback">Por favor rellene este campo.</div>

                            </div>

                            <!--==================================================
                                TODO: H3-4s Tag
                            ==================================================-->

                            <div class="col-12 col-lg-6 input-group mx-0 pr-0 mb-3">

                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        H3-4s Tag:
                                    </span>
                                </div>

                                <input type="text"
                                class="form-control"
                                placeholder="Ex: 40%"
                                name="hSliderH3_4sTag"
                                pattern="[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\'\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}"
                                maxlength="50"
                                onchange="validateJS(event,'regex')"
                                required
                                >

                                <div class="valid-feedback">Campo Valido.</div>
                                <div class="invalid-feedback">Por favor rellene este campo.</div>

                            </div>

                            <!--==================================================
                                TODO: Button Tag
                            ==================================================-->

                            <div class="col-12 col-lg-6 input-group mx-0 mb-3">

                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        Button Tag:
                                    </span>
                                </div>

                                <input type="text"
                                class="form-control"
                                placeholder="Ex: Shop now"
                                name="hSliderButtonTag"
                                pattern="[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\'\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}"
                                maxlength="50"
                                onchange="validateJS(event,'regex')"
                                required
                                >

                                <div class="valid-feedback">Campo Valido.</div>
                                <div class="invalid-feedback">Por favor rellene este campo.</div>

                            </div>

                            <!--==================================================
                                TODO: IMG Tag
                            ==================================================-->

                            <div class="col-12">

                                <label>IMG Tag:</label>

                                <div class="form-group__content">

                                    <label class="pb-5" for="hSlider">
                                    <img src="<?php echo TemplateController::srcImg() ?>views/img/products/default/default-horizontal-slider.jpg" class="img-fluid changeHSlider">
                                    </label>

                                    <div class="custom-file">

                                        <input type="file"
                                        class="custom-file-input"
                                        id="hSlider"
                                        name="hSlider"
                                        accept="image/*"
                                        maxSize="2000000"
                                        onchange="validateImageJS(event, 'changeHSlider')"
                                        required>

                                        <div class="valid-feedback">Campo Valido.</div>
                                        <div class="invalid-feedback">Por favor rellene este campo.</div>

                                        <label class="custom-file-label" for="hSlider">Choose file</label>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <!--==================================================
                        TODO: Slider Vertical del Producto
                    ==================================================-->

                    <div class="form-group mt-2">

                        <label>Slider Vertical del Producto<sup class="text-danger">*</sup></label>

                        <div class="form-group__content">

                            <label class="pb-5" for="vSlider">

                                <img src="<?php echo TemplateController::srcImg() ?>views/img/products/default/default-vertical-slider.jpg" class="img-fluid changeVSlider" style="width:260px">

                            </label>

                            <div class="custom-file">

                                <input type="file" 
                                class="custom-file-input" 
                                id="vSlider"
                                name="vSlider"
                                accept="image/*"
                                maxSize="2000000"
                                onchange="validateImageJS(event, 'changeVSlider')"
                                required>

                                <div class="valid-feedback">Campo Valido.</div>
                                <div class="invalid-feedback">Por favor rellene este campo.</div>

                                <label class="custom-file-label" for="vSlider">Choose file</label>

                            </div>

                        </div>

                    </div>

                    <!--==================================================
                        TODO: Oferta del Producto
                    ==================================================-->

                    <div class="form-group mt-2">

                        <label>Oferta del Producto Ej: <strong>Tipo:</strong> Descuento, <strong>Porcentaje %:</strong> 25, <strong>End offer:</strong> 30/06/2020</label>

                        <div class="row mb-3">

                            <!--==================================================
                                TODO: Tipo de Oferta
                            ===================================================-->

                            <div class="col-12 col-lg-4 form-group__content input-group mx-0 pr-0">

                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        Tipo:
                                    </span>
                                </div>

                                <select
                                class="form-control"
                                name="type_offer"
                                onchange="changeOffer(event)">

                                    <option value="Discount">Descuento</option>
                                    <option value="Fixed">Precio</option>

                                </select>

                                <div class="valid-feedback">Campo Valido.</div>
                                <div class="invalid-feedback">Por favor rellene este campo.</div>

                            </div>

                            <!--==================================================
                                TODO: El valor de la oferta
                            ===================================================-->

                            <div class="col-12 col-lg-4 form-group__content input-group mx-0 pr-0">

                                <div class="input-group-append">

                                    <span
                                    class="input-group-text typeOffer">
                                        Porcentaje %:
                                    </span>

                                </div>

                                <input type="number"
                                class="form-control"
                                name="value_offer"
                                min="0"
                                step="any"
                                pattern="[.\\,\\0-9]{1,}"
                                onchange="validateJS(event, 'numbers')">

                                <div class="valid-feedback">Campo Valido.</div>
                                <div class="invalid-feedback">Por favor rellene este campo.</div>

                            </div>

                            <!--==================================================
                                TODO: Fecha de vencimiento de la oferta
                            ===================================================-->

                            <div class="col-12 col-lg-4 form-group__content input-group mx-0 pr-0">

                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        End Offer:
                                    </span>
                                </div>

                                <input type="date"
                                class="form-control"
                                name="date_offer">

                                <div class="valid-feedback">Campo Valido.</div>
                                <div class="invalid-feedback">Por favor rellene este campo.</div>

                            </div>

                        </div>

                    </div>

            </div>

        </div>

        <div class="card-footer">

            <div class="col-md-8 offset-md-2">

                <div class="form-group mt-3">

                    <a href="/productos" class="btn btn-light border text-left">Volver</a>

                    <button type="submit" class="btn bg-dark float-right saveBtn">Guardar</button>

                </div>

            </div>

        </div>

    </form>

</div>