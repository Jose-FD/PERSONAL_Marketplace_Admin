<?php

    class CategoriesController{

        /*===========================================================================================
            TODO: Creación de Categorias
        ===========================================================================================*/

        public function create(){

            if(isset($_POST["nombre-category"])){

                echo '<script>

                        matPreloader("on");
                        fncSweetAlert("loading", "Loading...", "");

                    </script>';


                /*================================================================
                    TODO: Validación de lado del servidor
                ================================================================*/

                /*=============================================
                    TODO: Validamos la sintaxis de los campos
                =============================================*/

                if( preg_match('/^[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["nombre-category"] ) &&
                    preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["tituloLista-category"] ) &&
                    preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["icono-category"] )){


                        if(isset($_FILES["imagen-category"]["tmp_name"]) && !empty($_FILES["imagen-category"]["tmp_name"])){

                            $fields = array(

                                "file"=>$_FILES["imagen-category"]["tmp_name"],
                                "type"=>$_FILES["imagen-category"]["type"],
                                "folder"=>"categories",
                                "name"=>$_POST["url-name_category"],
                                "width"=>170,
                                "height"=>170
                            );

                            $saveImageCategory = CurlController::requestFile($fields);

                        }else{

                            echo '<script>

                                    fncFormatInputs();
                                    matPreloader("off");
                                    fncSweetAlert("close", "", "");
                                    fncNotie(3, "Campo de Imagen con error.");

                                </script>';

                            return;
                        }

                    /*=============================================
                        TODO: Agrupamos la información
                    =============================================*/

                    $data = array(

                        "name_category" => trim(TemplateController::capitalize($_POST["nombre-category"])),
                        "title_list_category" => json_encode(explode(",",$_POST["tituloLista-category"])),
                        "url_category" => trim($_POST["url-name_category"]),
                        "icon_category" => trim($_POST["icono-category"]),
                        "image_category" => $saveImageCategory,
                        "date_created_category" => date("Y-m-d")

                    );

                    /*=============================================
                        TODO: Solicitud a la API
                    =============================================*/

                    $url = "categories?token=".$_SESSION["admin"]->token_user."&table=users&suffix=user";
                    $method = "POST";
                    $fields = $data;

                    $response = CurlController::request($url, $method, $fields);

                    /*=============================================
                        TODO: Respuesta de la API
                    =============================================*/

                    if($response->status == 200){

                        echo '<script>

                                fncFormatInputs();
                                matPreloader("off");
                                fncSweetAlert("close", "", "");
                                fncSweetAlert("success", "Sus registros fueron creados con éxito.", "/categorias");

                            </script>';

                    }else{

                        echo '<script>

                                fncFormatInputs();
                                matPreloader("off");
                                fncSweetAlert("close", "", "");
                                fncNotie(3, "Error al guardar la categoria.");

                            </script>';

                        }

                }else{

                    echo '<script>

                            fncFormatInputs();
                            matPreloader("off");
                            fncSweetAlert("close", "", "");
                            fncNotie(3, "Field syntax error");

                        </script>';


                }
            }

        }

        /*===========================================================================================
            TODO: Editar Categorias
        ===========================================================================================*/

        public function edit($id){

            if(isset($_POST["idCategory"])){

                echo '<script>

                        matPreloader("on");
                        fncSweetAlert("loading", "Loading...", "");

                    </script>';

                if($id == $_POST["idCategory"]){

                    $select = "image_category";

                    $url = "categories?select=".$select."&linkTo=id_category&equalTo=".$id;
                    $method = "GET";
                    $fields = array();

                    $response = CurlController::request($url, $method, $fields);

                    if($response->status == 200){

                        /*================================================================
                            TODO: Validación de lado del servidor
                        ================================================================*/

                        /*=============================================
                            TODO: Validamos la sintaxis de los campos
                        =============================================*/

                        if( preg_match('/^[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["nombre-category"] ) &&
                            preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["tituloLista-category"] ) &&
                            preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["icono-category"] )){

                            /*=============================================
                                TODO: Validar cambio imagen
                            =============================================*/

                            if(isset($_FILES["imagen-category"]["tmp_name"]) && !empty($_FILES["imagen-category"]["tmp_name"])){

                                $fields = array(

                                    "file"=>$_FILES["imagen-category"]["tmp_name"],
                                    "type"=>$_FILES["imagen-category"]["type"],
                                    "folder"=>"categories",
                                    "name"=>$_POST["url-name_category"],
                                    "width"=>170,
                                    "height"=>170
                                );

                                    $saveImageCategory = CurlController::requestFile($fields);

                            }else{

                                $saveImageCategory = $response->results[0]->image_category;

                            }

                            /*=============================================
                                TODO: Agrupamos la información
                            =============================================*/

                            $data = "name_category=".trim(TemplateController::capitalize($_POST["nombre-category"]))."&title_list_category=".json_encode(explode(",",$_POST["tituloLista-category"]))."&url_category=".trim($_POST["url-name_category"])."&icon_category=".trim($_POST["icono-category"])."&image_category=".$saveImageCategory;

                            /*=============================================
                                TODO: Solicitud a la API
                            =============================================*/

                            $url = "categories?id=".$id."&nameId=id_category&token=".$_SESSION["admin"]->token_user."&table=users&suffix=user";
                            $method = "PUT";
                            $fields = $data;

                            $response = CurlController::request($url, $method, $fields);

                            /*=============================================
                                TODO: Respuesta de la API
                            =============================================*/

                            if($response->status == 200){

                                echo '<script>

                                        fncFormatInputs();
                                        matPreloader("off");
                                        fncSweetAlert("close", "", "");
                                        fncSweetAlert("success", "Sus registros fueron actualizados con éxito.", "/categorias");

                                    </script>';

                            }else{

                                echo '<script>

                                        fncFormatInputs();
                                        matPreloader("off");
                                        fncSweetAlert("close", "", "");
                                        fncNotie(3, "Error al editar el registro.");

                                    </script>';

                            }

                        }else{

                            echo '<script>

                                    fncFormatInputs();
                                    matPreloader("off");
                                    fncSweetAlert("close", "", "");
                                    fncNotie(3, "Error en los campos de sintaxis.");

                                </script>';

                        }

                    }else{

                        echo '<script>

                                fncFormatInputs();
                                matPreloader("off");
                                fncSweetAlert("close", "", "");
                                fncNotie(3, "Error al editar el registro.");

                            </script>';
                    }
                }else{

                    echo '<script>

                            fncFormatInputs();
                            matPreloader("off");
                            fncSweetAlert("close", "", "");
                            fncNotie(3, "Error al editar el registro.");

                        </script>';
                }
            }

        }

    }

?>