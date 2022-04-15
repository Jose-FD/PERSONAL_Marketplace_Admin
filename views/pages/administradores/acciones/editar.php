<?php

	if(isset($routesArray[3])){

		$security = explode("~",base64_decode($routesArray[3]));

		if($security[1] == $_SESSION["admin"]->token_user){

			$select = "id_user,displayname_user,username_user,email_user,picture_user,country_user,city_user,address_user,phone_user";

			$url = "users?select=".$select."&linkTo=id_user&equalTo=".$security[0];
			$method = "GET";
			$fields = array();

			$response = CurlController::request($url, $method, $fields);

			if($response->status == 200){

				$admin = $response->results[0];

			}else{

				echo '<script>

				window.location = "/administradores";

				</script>';
			}

		}else{

			echo '<script>

				window.location = "/administradores";

				</script>';
			}

		}

?>

<div class="card card-dark card-outline">

    <form method="post" class="needs-validation" novalidate enctype="multipart/form-data">

    <input type="hidden" value="<?php echo $admin->id_user ?>" name="idAdmin">

        <div class="card-header">

            <?php

                require_once "controllers/admins.controller.php";

                $create = new AdminsController();
                $create -> edit($admin->id_user);

            ?>

            <div class="col-md-8 offset-md-2">

                    <!--==================================================
                        TODO: Nombre y apellido
                    ==================================================-->

                    <div class="form-group mt-2">
                        <label>Nombre</label>
                        <input
                            type="text"
                            class="form-control"
                            pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}"
                            onchange="validateJS(event,'text')"
                            name="displayname"
                            value="<?php echo $admin->displayname_user ?>"
                            required>

                            <div class="valid-feedback">Campo Valido.</div>
                            <div class="invalid-feedback">Por favor rellene este campo.</div>

                    </div>

                    <!--==================================================
                        TODO: Apodo u seudónimo
                    ==================================================-->

                    <div class="form-group mt-2">
                        <label>Nombre de Usuario</label>
                        <input
                            type="text"
                            class="form-control"
                            pattern="[A-Za-z0-9]{1,}"
                            onchange="validateRepeat(event,'t&n','users','username_user')"
                            name="nombreusuario"
                            value="<?php echo $admin->username_user ?>"
                            required>

                            <div class="valid-feedback">Campo Valido.</div>
                            <div class="invalid-feedback">Por favor rellene este campo.</div>

                    </div>

                    <!--==================================================
                        TODO: Correo electrónico
                    ==================================================-->

                    <div class="form-group mt-2">
                        <label>Correo Electrónico</label>
                        <input
                            type="email"
                            class="form-control"
                            pattern="[.a-zA-Z0-9_]+([.][.a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}"
                            onchange="validateRepeat(event,'email','users','email_user')"
                            name="correo"
                            value="<?php echo $admin->email_user ?>"
                            required>

                            <div class="valid-feedback">Campo Valido.</div>
                            <div class="invalid-feedback">Por favor rellene este campo.</div>

                    </div>

                    <!--==================================================
                        TODO: Contraseña
                    ==================================================-->

                    <div class="form-group mt-2">
                        <label>Contraseña</label>
                        <input
                            type="password"
                            class="form-control"
                            pattern="[#\\=\\$\\;\\*\\_\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-Z]{1,}"
                            onchange="validateJS(event,'pass')"
                            name="password"
                            placeholder="************">

                            <div class="valid-feedback">Campo Valido.</div>
                            <div class="invalid-feedback">Por favor rellene este campo.</div>

                    </div>

                    <!--==================================================
                        TODO: Fotografia
                    ==================================================-->

                    <div class="form-group mt-2">
                        <label>Imagen</label>

                        <label for="customFile" class="d-flex justify-content-center">
                            <figure class="text-center py-3">
                                <img src="<?php echo TemplateController::returnImg($admin->id_user,$admin->picture_user,'direct') ?>" class="img-fluid rounded-circle changePicture" style="width:150px">
                            </figure>
                        </label>

                        <div class="custom-file">
                            <input
                                type="file"
                                id="customFile"
                                class="custom-file-input"
                                accept="image/*"
                                onchange="validateImageJS(event,'changePicture')"
                                name="picture">

                                <div class="valid-feedback">Campo Valido.</div>
                                <div class="invalid-feedback">Por favor rellene este campo.</div>

                            <label for="customFile" class="custom-file-label">Buscar Archivo</label>
                        </div>

                    </div>

                    <!--==================================================
                        TODO: País
                    ==================================================-->

                    <div class="form-group mt-2">
                        <label>País</label>

                        <?php

                            $countries = file_get_contents("views/assets/json/countries.json");
                            $countries = json_decode($countries, true);

                        ?>

                        <select class="form-control select2 changeCountry" name="pais" required>
                            <option value="<?php echo $admin->country_user?>_<?php echo explode("_",$admin->phone_user)[0] ?>"><?php echo $admin->country_user ?></option>

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
                        <label>Ciudad</label>
                        <input
                            type="text"
                            class="form-control"
                            pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}"
                            onchange="validateJS(event,'text')"
                            name="ciudad"
                            value="<?php echo $admin->city_user ?>"
                            required>

                            <div class="valid-feedback">Campo Valido.</div>
                            <div class="invalid-feedback">Por favor rellene este campo.</div>

                    </div>

                    <!--==================================================
                        TODO: Dirección
                    ==================================================-->

                    <div class="form-group mt-2">
                        <label>Dirección</label>
                        <input
                            type="text"
                            class="form-control"
                            pattern='[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
                            onchange="validateJS(event,'regex')"
                            name="direccion"
                            value="<?php echo $admin->address_user ?>"
                            required>

                            <div class="valid-feedback">Campo Valido.</div>
                            <div class="invalid-feedback">Por favor rellene este campo.</div>

                    </div>

                    <!--==================================================
                        TODO: Teléfono
                    ==================================================-->

                    <div class="form-group mt-2 mb-5">
                        <label>Teléfono</label>
                        <div class="input-group">

                            <div class="input-group-append">
                                <span class="input-group-text dialCode"><?php echo explode("_",$admin->phone_user)[0] ?></span>
                            </div>

                            <input
                            type="text"
                            class="form-control"
                            pattern="[-\\(\\)\\0-9 ]{1,}"
                            onchange="validateJS(event,'phone')"
                            name="telefono"
                            value="<?php echo $admin->phone_user ? explode("_",$admin->phone_user)[1] : null ?>"
                            required>

                        </div>

                            <div class="valid-feedback">Campo Valido.</div>
                            <div class="invalid-feedback">Por favor rellene este campo.</div>

                    </div>

            </div>

        </div>

        <div class="card-footer">

            <div class="col-md-8 offset-md-2">

                <div class="form-group mt-3">

                    <a href="/administradores" class="btn btn-light border text-left">Volver</a>

                    <button type="submit" class="btn bg-dark float-right">Guardar</button>

                </div>

            </div>

        </div>

    </form>

</div>