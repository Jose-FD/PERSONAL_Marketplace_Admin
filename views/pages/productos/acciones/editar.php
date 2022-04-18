<?php

	if(isset($routesArray[3])){

		$security = explode("~",base64_decode($routesArray[3]));

		if($security[1] == $_SESSION["admin"]->token_user){

			$select = "*";

			$url = "relations?rel=products,categories,subcategories,stores&type=product,category,subcategory,store&select=".$select."&linkTo=id_product&equalTo=".$security[0];
			$method = "GET";
			$fields = array();

			$response = CurlController::request($url,$method,$fields);

			if($response->status == 200){

				$product = $response->results[0];

			}else{

				echo '<script>

				window.location = "/productos";

				</script>';
			}

		}else{

			echo '<script>

			window.location = "/productos";

			</script>';

		}

		/*================================================
            TODO: Seleccionar tienda del administrador
		================================================*/

		$url = "stores?select=id_store,name_store&linkTo=id_user_store&equalTo=".$_SESSION["admin"]->id_user;

		$stores = CurlController::request($url,$method,$fields);

		if($stores->status == 200){

			$stores = $stores->results;

		}else{

			echo '<script>

			fncSweetAlert("error", "El administrador no tiene una tienda creada.", "/tiendas");

			</script>';

		}

	}


?>

<div class="card card-dark card-outline">

    <form method="post" class="needs-validation" novalidate enctype="multipart/form-data">

        <input type="hidden" value="<?php echo $product->id_product ?>" name="idProduct">

        <div class="card-header">

            <div class="col-md-8 offset-md-2">

                <?php

                    require_once "controllers/products.controller.php";

                    $create = new ProductsController();
                    $create -> edit($product->id_product);

                ?>

                    <label class="text-danger float-right"><sup>*</sup> Requerido</label>

                    <!--==================================================
                        TODO: Nombre de la Tienda
                    ===================================================-->

                    <div class="form-group mt-5">
                        <label>Nombre de la Tienda<sup class="text-danger">*</sup></label>

                        <select class="form-control select2" name="nombre-tienda" required>

                            <option value="<?php echo $product->id_store ?>"><?php echo $product->name_store ?></option>

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
                            onchange="validateJS(event,'text&number')"
                            maxlength="50"
                            name="name-product"
                            value="<?php echo $product->name_product ?>"
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
                        value="<?php echo $product->url_product ?>"
                        required>

                    </div>

                    <!--==================================================
                        TODO: Categoria del Producto
                    ===================================================-->

                    <!-- <div class="form-group mt-2">

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

                    </div> -->


                    <div class="form-group mt-2">

                        <label>Categoria<sup class="text-danger">*</sup></label>

                        <input
                        type="text"
                        class="form-control"
                        value="<?php echo $product->name_category ?>"
                        readonly>

                        <input type="hidden"  name="name-category" value="<?php echo $product->id_category ?>_<?php echo $product->url_category ?>"  >

                    </div>

                    <!--==================================================
                        TODO: Subcategoría del Producto
                    ===================================================-->

                    <!-- <div class="form-group selectSubcategory">

                        <label>Subcategoría<sup class="text-danger">*</sup></label>

                        <div class="form-group__content">

                            <select class="form-control" name="name-subcategory" required>

                                <option value="">Seleccionar Subcategoría</option>

                            </select>

                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>

                        </div>

                    </div> -->

                    <div class="form-group mt-2">

                        <label>Subcategoría<sup class="text-danger">*</sup></label>


                        <?php

                            $url = "subcategories?select=id_subcategory,name_subcategory,title_list_subcategory&linkTo=id_category_subcategory&equalTo=".$product->id_category;
                            $method = "GET";
                            $fields = array();

                            $subcategories = CurlController::request($url, $method, $fields)->results;

                        ?>

                        <div class="form-group__content">

                            <select
                            class="form-control"
                            name="name-subcategory"
                            required>

                                <?php foreach ($subcategories as $key => $value): ?>

                                    <?php if ($value->id_subcategory == $product->id_subcategory_product): ?>

                                        <option value="<?php echo $product->id_subcategory_product ?>_<?php echo $product->title_list_product ?>" selected><?php echo $product->name_subcategory ?></option>

                                    <?php else: ?>

                                        <option value="<?php echo $value->id_subcategory ?>_<?php echo $value->title_list_subcategory ?>" selected><?php echo $value->name_subcategory ?></option>

                                    <?php endif ?>

                                <?php endforeach ?>

                            </select>

                            <div class="valid-feedback">Campo Valido.</div>
                            <div class="invalid-feedback">Por favor rellene este campo.</div>

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
                                value="<?php echo $product->price_product ?>"
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
                                value="<?php echo $product->shipping_product ?>"
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
                                value="<?php echo $product->delivery_time_product ?>"
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
                                value="<?php echo $product->stock_product ?>"
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
                                <img src="<?php echo TemplateController::srcImg() ?>views/img/products/<?php echo $product->url_category ?>/<?php echo $product->image_product ?>" class="img-fluid changeImagen" style="width:150px">
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
                                >

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
                        ><?php echo $product->description_product ?></textarea>

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
                            value="<?php echo implode(",",json_decode($product->tags_product,true)) ?>"
                            required>

                            <div class="valid-feedback">Campo Valido.</div>
                            <div class="invalid-feedback">Por favor rellene este campo.</div>

                    </div>

                    <!--==================================================
                        TODO: Resumen del Producto
                    ==================================================-->

                    <div class="form-group mt-2">

						<label>Resumen del Producto<sup class="text-danger">*</sup> Ex: 20 hours of portable capabilities</label>

                        <?php foreach (json_decode($product->summary_product, true) as $key => $value): ?>

                            <input type="hidden" name="inputSummary" value="<?php echo $key+1 ?>">

                            <div class="input-group mb-3 inputSummary">

                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <button type="button" class="btn btn-danger btn-sm border-0" onclick="removeInput(<?php echo $key ?>,'inputSummary')">&times;</button>
                                    </span>
                                </div>

                                <input
                                class="form-control py-4"
                                type="text"
                                name="summary-product_<?php echo $key ?>"
                                pattern='[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                                onchange="validateJS(event,'regex')"
                                value="<?php echo $value ?>"
                                required>

                                <div class="valid-feedback">Campo Valido.</div>
                                <div class="invalid-feedback">Por favor rellene este campo.</div>

                            </div>

                        <?php endforeach ?>

						<button type="button" class="btn btn-primary mb-2" onclick="addInput(this, 'inputSummary')">Adicionar Resumen</button>

					</div>

                    <!--==================================================
                        TODO: Detalles del Producto
                    ==================================================-->

                    <div class="form-group mt-2">

						<label>Detalles del Producto<sup class="text-danger">*</sup> Ex: <strong>Title:</strong> Bluetooth, <strong>Value:</strong> Yes</label>

                        <?php foreach (json_decode($product->details_product, true) as $key => $value): ?>

                            <input type="hidden" name="inputDetails" value="<?php echo $key+1 ?>">

                            <div class="input-group mb-3 inputDetails">

                                <!--==================================================
                                    TODO: Entrada para el título del detalle
                                ==================================================-->

                                <div class="col-12 col-lg-6 input-group">

                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <button type="button" class="btn btn-danger btn-sm border-0" onclick="removeInput(<?php echo $key ?>,'inputDetails')">&times;</button>
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
                                    name="details-title-product_<?php echo $key ?>"
                                    pattern='[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                                    onchange="validateJS(event,'regex')"
                                    value="<?php echo $value["title"] ?>"
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
                                    name="details-value-product_<?php echo $key ?>"
                                    pattern='[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                                    onchange="validateJS(event,'regex')"
                                    value="<?php echo $value["value"] ?>"
                                    required>

                                    <div class="valid-feedback">Campo Valido.</div>
                                    <div class="invalid-feedback">Por favor rellene este campo.</div>

                                </div>

                            </div>

                        <?php endforeach ?>

						<button type="button" class="btn btn-primary mb-2" onclick="addInput(this, 'inputDetails')">Adicionar Detalle</button>

					</div>

                    <!--==================================================
                        TODO: Especificaciones técnicas del Producto
                    ==================================================-->

                    <div class="form-group mt-2">

						<label>Especificaciones del Producto<strong>Type:</strong> Color, <strong>Values:</strong> Black, Red, White</label>

                        <?php if ($product->specifications_product != null): ?>

                            <?php foreach (json_decode($product->specifications_product, true) as $key => $value): ?>

                                <input type="hidden" name="inputSpecifications" value="<?php echo $key+1 ?>">

                                <div class="input-group mb-3 inputSpecifications">

                                    <!--==================================================
                                        TODO: Entrada para el tipo de especificación
                                    ==================================================-->

                                    <div class="col-12 col-lg-6 input-group">

                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <button type="button" class="btn btn-danger btn-sm border-0" onclick="removeInput(<?php echo $key ?>,'inputSpecifications')">&times;</button>
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
                                        name="spec-type-product_<?php echo $key ?>"
                                        pattern='[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                                        onchange="validateJS(event,'regex')"
                                        value="<?php echo array_keys($value)[0] ?>"
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
                                        name="spec-value-product_<?php echo $key ?>"
                                        pattern='[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                                        onchange="validateJS(event,'regex')"
                                        value="<?php echo implode(",", array_values($value)[0]); ?>"
                                        required>

                                        <div class="valid-feedback">Campo Valido.</div>
                                        <div class="invalid-feedback">Por favor rellene este campo.</div>

                                    </div>

                                </div>

                            <?php endforeach ?>

                        <?php else: ?>

                            <input type="hidden" name="inputSpecifications" value="1">

                            <div class="row mb-3 inputSpecifications">

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
                                    value="<?php echo array_keys($value)[0] ?>"
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
                                    value="<?php echo implode(",", array_values($value)[0]); ?>"
                                    required>

                                    <div class="valid-feedback">Campo Valido.</div>
                                    <div class="invalid-feedback">Por favor rellene este campo.</div>

                                </div>


                            </div>

                        <?php endif ?>

						<button type="button" class="btn btn-primary mb-2" onclick="addInput(this, 'inputSpecifications')">Adicionar Especificaciones</button>

					</div>

                    <!--==================================================
                        TODO: Galería del Producto
                    ==================================================-->

                    <div class="form-group mt-2">

                        <label>Galería del Producto: <sup class="text-danger">*</sup></label> 

                        <div class="dropzone mb-3">

                            <?php foreach (json_decode($product->gallery_product,true) as $value): ?>

                                <div class="dz-preview dz-file-preview">

                                    <div class="dz-image">

                                        <img class="img-fluid" src="<?php echo TemplateController::srcImg() ?>views/img/products/<?php echo $product->url_category ?>/gallery/<?php echo $value ?>">

                                    </div>

                                    <a class="dz-remove" data-dz-remove remove="<?php echo $value?>" onclick="removeGallery(this)">Remove file</a>

                                </div>

                            <?php endforeach ?>

                            <div class="dz-message">

                                Suelta tus imágenes aquí, tamaño máximo 500px * 500px

                            </div>

                        </div>

                        <input type="hidden" name="galeria-producto-old" value='<?php echo $product->gallery_product ?>'>

                        <input type="hidden" name="galeria-producto">

                        <input type="hidden" name="delete-galeria-producto">

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
                                        Tipo:
                                    </span>
                                </div>

                                <select
                                class="form-control"
                                name="type_video"
                                >
                                    <?php if ($product->video_product != null): ?>

                                        <?php if (json_decode($product->video_product, true)[0] == "youtube"): ?>

                                            <option value="youtube">YouTube</option>
                                            <option value="vimeo">Vimeo</option>

                                        <?php else: ?>

                                            <option value="vimeo">Vimeo</option>
                                            <option value="youtube">YouTube</option>

                                        <?php endif ?>

                                    <?php else: ?>

                                        <option value="">Seleccionar Plataforma</option>
                                        <option value="youtube">YouTube</option>
                                        <option value="vimeo">Vimeo</option>

                                    <?php endif ?>

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
                                <?php if ($product->video_product != null): ?>
                                    value="<?php echo json_decode($product->video_product, true)[1] ?>"
                                <?php endif ?>
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
                                value="<?php echo json_decode($product->top_banner_product, true)["H3 tag"] ?>"
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
                                value="<?php echo json_decode($product->top_banner_product, true)["P1 tag"] ?>"
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
                                value="<?php echo json_decode($product->top_banner_product, true)["H4 tag"] ?>"
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
                                value="<?php echo json_decode($product->top_banner_product, true)["P2 tag"] ?>"
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
                                value="<?php echo json_decode($product->top_banner_product, true)["Span tag"] ?>"
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
                                value="<?php echo json_decode($product->top_banner_product, true)["Button tag"] ?>"
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
                                        <img src="<?php echo TemplateController::srcImg() ?>views/img/products/<?php echo $product->url_category ?>/top/<?php echo json_decode($product->top_banner_product, true)["IMG tag"] ?>" class="img-fluid changeTopBanner">
                                    </label>

                                    <div class="custom-file">

                                        <input type="file"
                                        class="custom-file-input"
                                        id="topBanner"
                                        name="topBanner"
                                        accept="image/*"
                                        maxSize="2000000"
                                        onchange="validateImageJS(event, 'changeTopBanner')"
                                        >

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
                                <img src="<?php echo TemplateController::srcImg() ?>views/img/products/<?php echo $product->url_category ?>/default/<?php echo $product->default_banner_product ?>" class="img-fluid changeDefaultBanner" style="width:500px">
                            </label>

                            <div class="custom-file">

                                <input type="file"
                                class="custom-file-input"
                                id="defaultBanner"
                                name="defaultBanner"
                                accept="image/*"
                                maxSize="2000000"
                                onchange="validateImageJS(event, 'changeDefaultBanner')"
                                >

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
                                value="<?php echo json_decode($product->horizontal_slider_product, true)["H4 tag"] ?>"
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
                                value="<?php echo json_decode($product->horizontal_slider_product, true)["H3-1 tag"] ?>"
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
                                value="<?php echo json_decode($product->horizontal_slider_product, true)["H3-2 tag"] ?>"
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
                                value="<?php echo json_decode($product->horizontal_slider_product, true)["H3-3 tag"] ?>"
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
                                value="<?php echo json_decode($product->horizontal_slider_product, true)["H3-4s tag"] ?>"
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
                                value="<?php echo json_decode($product->horizontal_slider_product, true)["Button tag"] ?>"
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
                                        <img src="<?php echo TemplateController::srcImg() ?>views/img/products/<?php echo $product->url_category ?>/horizontal/<?php echo json_decode ($product->horizontal_slider_product, true)["IMG tag"] ?>" class="img-fluid changeHSlider">
                                    </label>

                                    <div class="custom-file">

                                        <input type="file"
                                        class="custom-file-input"
                                        id="hSlider"
                                        name="hSlider"
                                        accept="image/*"
                                        maxSize="2000000"
                                        onchange="validateImageJS(event, 'changeHSlider')"
                                        >

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

                                <img src="<?php echo TemplateController::srcImg() ?>views/img/products/<?php echo $product->url_category ?>/vertical/<?php echo $product->vertical_slider_product ?>" class="img-fluid changeVSlider" style="width:260px">

                            </label>

                            <div class="custom-file">

                                <input type="file"
                                class="custom-file-input"
                                id="vSlider"
                                name="vSlider"
                                accept="image/*"
                                maxSize="2000000"
                                onchange="validateImageJS(event, 'changeVSlider')"
                                >

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

                                    <?php if ($product->offer_product != null): ?>

                                        <?php if (json_decode($product->offer_product, true)[0] == "Discount"): ?>

                                            <option value="Discount">Descuento</option>
                                            <option value="Fixed">Precio</option>

                                        <?php else: ?>

                                            <option value="Fixed">Precio</option>
                                            <option value="Discount">Descuento</option>

                                        <?php endif ?>

                                    <?php else: ?>

                                        <option value="Discount">Descuento</option>
                                        <option value="Fixed">Precio</option>

                                    <?php endif ?>

                                </select>

                                <div class="valid-feedback">Campo Valido.</div>
                                <div class="invalid-feedback">Por favor rellene este campo.</div>

                            </div>

                            <!--==================================================
                                TODO: El valor de la oferta
                            ===================================================-->

                            <div class="col-12 col-lg-4 input-group mx-0 pr-0">

                                <?php if ($product->offer_product != null): ?>

                                    <div class="input-group-append">

                                        <?php if (json_decode($product->offer_product, true)[0] == "Discount"): ?>

                                            <span
                                                class="input-group-text typeOffer">
                                                Porcentaje %:
                                            </span>

                                        <?php else: ?>

                                            <span
                                                class="input-group-text typeOffer">
                                                Precio $:
                                            </span>

                                        <?php endif ?>

                                    </div>

                                    <input type="number"
                                    class="form-control"
                                    name="value_offer"
                                    min="0"
                                    step="any"
                                    pattern="[.\\,\\0-9]{1,}"
                                    onchange="validateJS(event, 'numbers')"
                                    value="<?php echo json_decode($product->offer_product, true)[1] ?>">


                                <?php else: ?>

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

                                <?php endif ?>

                                <div class="valid-feedback">Campo Valido.</div>
                                <div class="invalid-feedback">Por favor rellene este campo.</div>

                            </div>

                            <!--==================================================
                                TODO: Fecha de vencimiento de la oferta
                            ===================================================-->

                            <div class="col-12 col-lg-4 input-group mx-0 pr-0">

                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        End Offer:
                                    </span>
                                </div>

                                <?php if ($product->offer_product != null): ?>

                                    <input type="date"
                                    class="form-control"
                                    name="date_offer"
                                    value="<?php echo json_decode($product->offer_product, true)[2] ?>">

                                <?php else: ?>

                                    <input type="date"
                                    class="form-control"
                                    name="date_offer">

                                <?php endif ?>

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