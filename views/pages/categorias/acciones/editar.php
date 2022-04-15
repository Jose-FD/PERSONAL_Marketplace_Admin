<?php

	if(isset($routesArray[3])){

		$security = explode("~",base64_decode($routesArray[3]));

		if($security[1] == $_SESSION["admin"]->token_user){

			$select = "*";

			$url = "categories?select=".$select."&linkTo=id_category&equalTo=".$security[0];;
			$method = "GET";
			$fields = array();

			$response = CurlController::request($url, $method, $fields);

			if($response->status == 200){

				$category = $response->results[0];

			}else{

				echo '<script>

				window.location = "/categorias";

				</script>';
			}

		}else{

			echo '<script>

				window.location = "/categorias";

				</script>';
			}

		}

?>

<div class="card card-dark card-outline">

    <form method="post" class="needs-validation" novalidate enctype="multipart/form-data">

        <input type="hidden" value="<?php echo $category->id_category ?>" name="idCategory">

        <div class="card-header">

            <div class="col-md-8 offset-md-2">

                <?php

                    require_once "controllers/categories.controller.php";

                    $create = new CategoriesController();
                    $create -> edit($category->id_category);

                ?>

                    <!--==================================================
                        TODO: Nombre de categoria
                    ==================================================-->

                    <div class="form-group mt-5">
                        <label>Nombre</label>
                        <input
                            type="text"
                            class="form-control"
                            pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}"
                            onchange="validateJS(event,'text')"
                            name="nombre-category"
                            value="<?php echo $category->name_category ?>"
                            required>

                            <div class="valid-feedback">Campo Valido.</div>
                            <div class="invalid-feedback">Por favor rellene este campo.</div>

                    </div>

                    <!--==================================================
                        TODO: URL de la categoria
                    ==================================================-->

                    <div class="form-group mt-2">
                        <label>URL</label>
                        <input
                            type="text"
                            class="form-control"
                            readonly
                            name="url-name_category"
                            value="<?php echo $category->url_category ?>"
                            required>

                    </div>

                    <!--==================================================
                        TODO: Listado de títulos de la categoria
                    ==================================================-->

                    <div class="form-group mt-2">
                        <label>Titulo de Lista</label>
                        <input
                            type="text"
                            class="form-control tags-input"
                            pattern='[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                            onchange="validateJS(event,'regex')"
                            name="tituloLista-category"
                            value="<?php echo implode(",",json_decode($category->title_list_category,true)) ?>"
                            required>

                            <div class="valid-feedback">Campo Valido.</div>
                            <div class="invalid-feedback">Por favor rellene este campo.</div>

                    </div>

                    <!--==================================================
                        TODO: Icono de categoria
                    ==================================================-->

                    <div class="form-group mt-2">
                        <label>Icono | <a href="https://fontawesome.com/v5.15/icons" target="_blank">Buscar Icono</a></label>

                        <div class="input-group mb-3">

                            <div class="input-group-append input-group-text viewIcon">
                                <i class="fas fa-tags"></i>
                            </div>

                            <input
                                type="text"
                                class="form-control"
                                pattern='[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                                onchange="validateJS(event,'icon')"
                                name="icono-category"
                                value="<?php echo $category->icon_category ?>"
                                required>

                                <div class="valid-feedback">Campo Valido.</div>
                                <div class="invalid-feedback">Por favor rellene este campo.</div>

                        </div>

                    </div>

                    <!--==================================================
                        TODO: Fotografia
                    ==================================================-->

                    <div class="form-group mt-2">
                        <label>Imagen</label>

                        <label for="customFile" class="d-flex justify-content-center">
                            <figure class="text-center py-3">
                            <img src="<?php echo TemplateController::srcImg() ?>views/img/categories/<?php echo $category->image_category ?>" class="img-fluid changePicture" style="width:150px">
                            </figure>
                        </label>

                        <div class="custom-file">
                            <input
                                type="file"
                                id="customFile"
                                class="custom-file-input"
                                accept="image/*"
                                onchange="validateImageJS(event,'changePicture')"
                                name="imagen-category">

                                <div class="valid-feedback">Campo Valido.</div>
                                <div class="invalid-feedback">Por favor rellene este campo.</div>

                            <label for="customFile" class="custom-file-label">Buscar Archivo</label>
                        </div>

                    </div>

            </div>

        </div>

        <div class="card-footer">

            <div class="col-md-8 offset-md-2">

                <div class="form-group mt-3">

                    <a href="/categorias" class="btn btn-light border text-left">Volver</a>

                    <button type="submit" class="btn bg-dark float-right">Guardar</button>

                </div>

            </div>

        </div>

    </form>

</div>