<?php

	if(isset($routesArray[3])){

		$security = explode("~",base64_decode($routesArray[3]));

		if($security[1] == $_SESSION["admin"]->token_user){

			$select = "*";

			$url = "stores?select=".$select."&linkTo=id_store&equalTo=".$security[0];;
			$method = "GET";
			$fields = array();

			$response = CurlController::request($url,$method,$fields);

			if($response->status == 200){

				$store = $response->results[0];

			}else{

				echo '<script>

				window.location = "/tiendas";

				</script>';
			}

		}else{

			echo '<script>

			window.location = "/tiendas";

			</script>';

		}

	}


?>

<div class="card card-dark card-outline">

    <form method="post" class="needs-validation" novalidate enctype="multipart/form-data">

        <input type="hidden" value="<?php echo $store->id_store ?>" name="idStore">

        <div class="card-header">

            <div class="col-md-8 offset-md-2">

                <?php

                    require_once "controllers/stores.controller.php";

                    $create = new StoresController();
                    $create -> edit($store->id_store);

                ?>

                <label class="text-danger float-right"><sup>*</sup> Requerido</label>

                <!--==================================================
                    TODO: Nombre de la Tienda
                ==================================================-->

                <div class="form-group mt-5">
                        <label>Nombre de la Tienda<sup class="text-danger">*</sup></label>

                        <input
                            type="text"
                            class="form-control"
                            pattern="[0-9A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,50}"
                            onchange="validateJS(event,'text&number')"
                            maxlength="50"
                            name="name-store"
                            value="<?php echo $store->name_store ?>"
                            required>

                            <div class="valid-feedback">Campo Valido.</div>
                            <div class="invalid-feedback">Por favor rellene este campo.</div>

                </div>

                <!--==================================================
                    TODO: URL de la Tienda
                ==================================================-->

                <div class="form-group mt-2">

                        <label>Url de la Tienda<sup class="text-danger">*</sup></label>

                        <input
                        type="text"
                        class="form-control"
                        readonly
                        name="url-name_store"
                        value="<?php echo $store->url_store ?>"
                        required>

                </div>

                <!--==================================================
                    TODO: Información de la Tienda
                ==================================================-->

                <div class="form-group mt-5">
                        <label>Información de la Tienda<sup class="text-danger">*</sup></label>

                        <textarea
                            rows="7"
                            type="text"
                            class="form-control"
                            pattern="[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\'\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,500}"
                            onchange="validateJS(event,'regex')"
                            maxlength="500"
                            name="informacion-tienda"
                            required><?php echo $store->about_store ?></textarea>

                            <div class="valid-feedback">Campo Valido.</div>
                            <div class="invalid-feedback">Por favor rellene este campo.</div>

                </div>

                <!--==================================================
                    TODO: Correo electrónico de la Tienda
                ==================================================-->

                <div class="form-group mt-2">
                        <label>Correo Electrónico de la Tienda<sup class="text-danger">*</sup></label>
                        <input
                            type="email"
                            class="form-control"
                            pattern="[.a-zA-Z0-9_]+([.][.a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}"
                            onchange="validateRepeat(event,'email','stores','email_store')"
                            name="correo-tienda"
                            value="<?php echo $store->email_store ?>"
                            required>

                            <div class="valid-feedback">Campo Valido.</div>
                            <div class="invalid-feedback">Por favor rellene este campo.</div>

                </div>

                <!--==================================================
                    TODO: País donde se encuentra la Tienda
                ==================================================-->

                <div class="form-group mt-2">
                        <label>País<sup class="text-danger">*</sup></label>

                        <?php

                            $countries = file_get_contents("views/assets/json/countries.json");
                            $countries = json_decode($countries, true);

                        ?>

                        <select class="form-control select2 changeCountry" name="pais-tienda" required>
                            <option value="<?php echo $store->country_store?>_<?php echo explode("_",$store->phone_store)[0] ?>"><?php echo $store->country_store ?></option>

                            <?php foreach ($countries as $key => $value): ?>

                                <option value="<?php echo $value["name"] ?>_<?php echo $value["dial_code"] ?>"><?php echo $value["name"] ?></option>

                            <?php endforeach ?>

                        </select>

                        <div class="valid-feedback">Campo Valido.</div>
                        <div class="invalid-feedback">Por favor rellene este campo.</div>

                </div>

                <!--==================================================
                    TODO: Ciudad
                ==================================================-->

                <div class="form-group mt-2">
                        <label>Ciudad<sup class="text-danger">*</sup></label>
                        <input
                            type="text"
                            class="form-control"
                            pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}"
                            onchange="validateJS(event,'text')"
                            name="ciudad-tienda"
                            value="<?php echo $store->city_store ?>"
                            required>

                            <div class="valid-feedback">Campo Valido.</div>
                            <div class="invalid-feedback">Por favor rellene este campo.</div>

                </div>

                <!--==================================================
                    TODO: Dirección
                ==================================================-->

                <div class="form-group mt-2">
                        <label>Dirección<sup class="text-danger">*</sup></label>
                        <input
                            type="text"
                            class="form-control"
                            pattern='[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                            onchange="validateJS(event,'regex')"
                            name="direccion-tienda"
                            value="<?php echo $store->address_store ?>"
                            required>

                            <div class="valid-feedback">Campo Valido.</div>
                            <div class="invalid-feedback">Por favor rellene este campo.</div>

                </div>

                <!--==================================================
                    TODO: Teléfono
                ==================================================-->

                <div class="form-group mt-2 mb-5">
                        <label>Teléfono<sup class="text-danger">*</sup></label>
                        <div class="input-group">

                            <div class="input-group-append">
                                <span class="input-group-text dialCode"><?php echo explode("_",$store->phone_store)[0] ?></span>
                            </div>

                            <input
                            type="text"
                            class="form-control"
                            pattern="[-\\(\\)\\0-9 ]{1,}"
                            onchange="validateJS(event,'phone')"
                            name="telefono-tienda"
                            value="<?php echo $store->phone_store ? explode("_",$store->phone_store)[1] : null ?>"
                            required>

                        </div>

                            <div class="valid-feedback">Campo Valido.</div>
                            <div class="invalid-feedback">Por favor rellene este campo.</div>

                </div>

                <!--==================================================
                    TODO: Logo de la Tienda
                ==================================================-->

                <div class="form-group mt-2">
                        <label>Logo de la Tienda</label>

                        <label for="customFile" class="d-flex justify-content-center">
                            <figure class="text-center py-3">
                                <img src="<?php echo TemplateController::srcImg() ?>views/img/stores/<?php echo $store->url_store ?>/<?php echo $store->logo_store ?>" class="img-fluid changeLogo" style="width:150px">
                            </figure>
                        </label>

                        <div class="custom-file">
                            <input
                                type="file"
                                id="customFile"
                                class="custom-file-input"
                                accept="image/*"
                                onchange="validateImageJS(event,'changeLogo')"
                                name="logo-tienda">

                                <div class="valid-feedback">Campo Valido.</div>
                                <div class="invalid-feedback">Por favor rellene este campo.</div>

                            <label for="customFile" class="custom-file-label">Buscar Archivo</label>
                        </div>

                </div>

                <!--==================================================
                    TODO: Portada de la Tienda
                ==================================================-->

                <div class="form-group mt-2">
                        <label>Portada de la Tienda</label>

                        <label for="customFilePortada" class="d-flex justify-content-center">
                            <figure class="text-center py-3">
                                <img src="<?php echo TemplateController::srcImg() ?>views/img/stores/<?php echo $store->url_store ?>/<?php echo $store->cover_store ?>" class="img-fluid changeCover">
                            </figure>
                        </label>

                        <div class="custom-file">
                            <input
                                type="file"
                                id="customFilePortada"
                                class="custom-file-input"
                                accept="image/*"
                                onchange="validateImageJS(event,'changePortada')"
                                name="portada-tienda">

                                <div class="valid-feedback">Campo Valido.</div>
                                <div class="invalid-feedback">Por favor rellene este campo.</div>

                            <label for="customFilePortada" class="custom-file-label">Buscar Archivo</label>
                        </div>

                </div>

                <!--==================================================
                    TODO: Redes sociales de la Tienda
                ==================================================-->

                <div class="form-group mt-2">

                        <label>Redes Sociales</label>

                        <?php

                            $facebook = "";
                            $instagram = "";
                            $twitter = "";
                            $linkedin = "";
                            $youtube = "";

                            if($store->socialnetwork_store != null){

                                foreach (json_decode($store->socialnetwork_store, true) as $key => $value) {

                                    if(array_keys($value)[0] == "facebook"){

                                        $facebook = explode("/",$value[array_keys($value)[0]])[3];

                                    }

                                    if(array_keys($value)[0] == "instagram"){

                                        $instagram = explode("/",$value[array_keys($value)[0]])[3];

                                    }

                                    if(array_keys($value)[0] == "twitter"){

                                        $twitter = explode("/",$value[array_keys($value)[0]])[3];

                                    }

                                    if(array_keys($value)[0] == "linkedin"){

                                        $linkedin = explode("/",$value[array_keys($value)[0]])[3];

                                    }

                                    if(array_keys($value)[0] == "youtube"){

                                        $youtube = explode("/",$value[array_keys($value)[0]])[3];

                                    }

                                }

                            }

                        ?>

                        <!--==================================================
                            TODO: Facebook
                        ==================================================-->

                        <div class="input-group mb-5">

                            <div class="input-group-append">
                                <span class="input-group-text">https://facebook.com/</span>
                            </div>

                            <input type="text"
                            class="form-control"
                            name="facebook-tienda"
                            pattern='[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                            onchange="validateJS(event,'regex')"+
                            value="<?php echo $facebook ?>"
                            >

                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>

                        </div>

                        <!--==================================================
                            TODO: Instagram
                        ==================================================-->

                        <div class="input-group mb-5">

                            <div class="input-group-append">
                                <span class="input-group-text">https://instagram.com/</span>
                            </div>

                            <input type="text"
                            class="form-control"
                            name="instagram-tienda"
                            pattern='[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                            onchange="validateJS(event,'regex')"
                            value="<?php echo $instagram ?>"
                            >

                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>

                        </div>

                        <!--==================================================
                            TODO: Twitter
                        ==================================================-->

                        <div class="input-group mb-5">

                            <div class="input-group-append">
                                <span class="input-group-text">https://twitter.com/</span>
                            </div>

                            <input type="text"
                            class="form-control"
                            name="twitter-tienda"
                            pattern='[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                            onchange="validateJS(event,'regex')"
                            value="<?php echo $twitter ?>"
                            >

                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>

                        </div>

                        <!--==================================================
                            TODO: Linkedin
                        ==================================================-->

                        <div class="input-group mb-5">

                            <div class="input-group-append">
                                <span class="input-group-text">https://linkedin.com/</span>
                            </div>

                            <input type="text"
                            class="form-control"
                            name="linkedin-tienda"
                            pattern='[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                            onchange="validateJS(event,'regex')"
                            value="<?php echo $linkedin ?>"
                            >

                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>

                        </div>

                        <!--==================================================
                            TODO: Youtube
                        ==================================================-->

                        <div class="input-group mb-5">

                            <div class="input-group-append">
                                <span class="input-group-text">https://youtube.com/</span>
                            </div>

                            <input type="text"
                            class="form-control"
                            name="youtube-tienda"
                            pattern='[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                            onchange="validateJS(event,'regex')"
                            value="<?php echo $youtube ?>"
                            >

                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>

                        </div>

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