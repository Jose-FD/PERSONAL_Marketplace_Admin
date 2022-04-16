<?php

    class StoresController{

        /*===========================================================================================
            TODO: Creación de Tiendas
        ===========================================================================================*/

        public function create(){

            if(isset($_POST["name-store"])){

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

                if( preg_match('/^[0-9A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST["name-store"] ) &&
                preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,500}$/', $_POST["informacion-tienda"] ) &&
                preg_match('/^[.a-zA-Z0-9_]+([.][.a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["correo-tienda"] ) &&
                preg_match('/^[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["ciudad-tienda"]) &&
                preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["direccion-tienda"]) &&
                preg_match('/^[-\\(\\)\\0-9 ]{1,}$/', $_POST["telefono-tienda"] )){


                        /*=============================================
                            TODO: Validación logo
                        =============================================*/

                        if(isset($_FILES["logo-tienda"]["tmp_name"]) && !empty($_FILES["logo-tienda"]["tmp_name"])){

                            $fields = array(

                                "file"=>$_FILES["logo-tienda"]["tmp_name"],
                                "type"=>$_FILES["logo-tienda"]["type"],
                                "folder"=>"stores/".$_POST["url-name_store"],
                                "name"=>"logo",
                                "width"=>270,
                                "height"=>270
                            );

                            $saveImageLogo = CurlController::requestFile($fields);

                        }else{

                            echo '<script>

                                    fncFormatInputs();
                                    matPreloader("off");
                                    fncSweetAlert("close", "", "");
                                    fncNotie(3, "Campo de Imagen del logo con error.");

                                </script>';

                            return;
                        }

                        /*=============================================
                            TODO: Validación Portada
                        =============================================*/

                        if(isset($_FILES["portada-tienda"]["tmp_name"]) && !empty($_FILES["portada-tienda"]["tmp_name"])){

                            $fields = array(

                                "file"=>$_FILES["portada-tienda"]["tmp_name"],
                                "type"=>$_FILES["portada-tienda"]["type"],
                                "folder"=>"stores/".$_POST["url-name_store"],
                                "name"=>"portada",
                                "width"=>1424,
                                "height"=>768
                            );

                            $saveImagePortada = CurlController::requestFile($fields);

                        }else{

                            echo '<script>

                                    fncFormatInputs();
                                    matPreloader("off");
                                    fncSweetAlert("close", "", "");
                                    fncNotie(3, "Campo de Imagen de la Portada con error.");

                                </script>';

                            return;
                        }


                    /*=============================================
                        TODO: Agrupamos Redes Sociales
                    =============================================*/

                    $socialNetwork = array();

                    if(isset($_POST["facebook-tienda"]) && !empty($_POST["facebook-tienda"])){

                        array_push($socialNetwork, ["facebook"=> "https://facebook.com/".$_POST["facebook-tienda"]]);

                    }

                    if(isset($_POST["instagram-tienda"]) && !empty($_POST["instagram-tienda"])){

                        array_push($socialNetwork, ["instagram"=> "https://instagram.com/".$_POST["instagram-tienda"]]);

                    }

                    if(isset($_POST["twitter-tienda"]) && !empty($_POST["twitter-tienda"])){

                        array_push($socialNetwork, ["twitter"=> "https://twitter.com/".$_POST["twitter-tienda"]]);

                    }

                    if(isset($_POST["linkedin-tienda"]) && !empty($_POST["linkedin-tienda"])){

                        array_push($socialNetwork, ["linkedin"=> "https://linkedin.com/".$_POST["linkedin-tienda"]]);

                    }

                    if(isset($_POST["youtube-tienda"]) && !empty($_POST["youtube-tienda"])){

                        array_push($socialNetwork, ["youtube"=> "https://youtube.com/".$_POST["youtube-tienda"]]);

                    }

                    if(count($socialNetwork) > 0){

                        $socialNetwork = json_encode($socialNetwork);

                    }else{

                        $socialNetwork = null;
                    }

                    /*=============================================
                        TODO: Agrupamos la información
                    =============================================*/

                    $data = array(

                        "id_user_store" => $_SESSION["admin"]->id_user,
                        "name_store" => trim(TemplateController::capitalize($_POST["name-store"])),
                        "url_store" => trim($_POST["url-name_store"]),
                        "about_store" => trim($_POST["informacion-tienda"]),
                        "abstract_store" => substr(trim($_POST["informacion-tienda"]), 0, 100)."...",
                        "email_store" => trim(strtolower($_POST["correo-tienda"])),
                        "country_store" => trim(explode("_",$_POST["pais-tienda"])[0]),
                        "city_store" => trim(TemplateController::capitalize($_POST["ciudad-tienda"])),
                        "address_store" => trim($_POST["direccion-tienda"]),
                        "phone_store" =>  trim(explode("_",$_POST["pais-tienda"])[1]."_".$_POST["telefono-tienda"]),
                        "logo_store" => $saveImageLogo,
                        "cover_store" => $saveImagePortada,
                        "socialnetwork_store" => $socialNetwork,
                        "date_created_store" => date("Y-m-d")

                    );

                    /*=============================================
                        TODO: Solicitud a la API
                    =============================================*/

                    $url = "stores?token=".$_SESSION["admin"]->token_user."&table=users&suffix=user";
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
                                fncSweetAlert("success", "Sus registros fueron creados con éxito.", "/tiendas");

                            </script>';

                    }else{

                        echo '<script>

                                fncFormatInputs();
                                matPreloader("off");
                                fncSweetAlert("close", "", "");
                                fncNotie(3, "Error al guardar la tienda.");

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
            TODO: Editar Tiendas
        ===========================================================================================*/

        public function edit($id){

            if(isset($_POST["idStore"])){

                echo '<script>

                        matPreloader("on");
                        fncSweetAlert("loading", "Loading...", "");

                    </script>';

                if($id == $_POST["idStore"]){

                    $select = "logo_store,cover_store";

                    $url = "stores?select=".$select."&linkTo=id_store&equalTo=".$id;
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

                        if( preg_match('/^[0-9A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST["name-store"] ) &&
                            preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,500}$/', $_POST["informacion-tienda"] ) &&
                            preg_match('/^[.a-zA-Z0-9_]+([.][.a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["correo-tienda"] ) &&
                            preg_match('/^[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["ciudad-tienda"]) &&
                            preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["direccion-tienda"]) &&
                            preg_match('/^[-\\(\\)\\0-9 ]{1,}$/', $_POST["telefono-tienda"] )){

                            /*=============================================
                                TODO: Validar cambio de logo
                            =============================================*/

                            if(isset($_FILES["logo-tienda"]["tmp_name"]) && !empty($_FILES["logo-tienda"]["tmp_name"])){

                                $fields = array(

                                    "file"=>$_FILES["logo-tienda"]["tmp_name"],
                                    "type"=>$_FILES["logo-tienda"]["type"],
                                    "folder"=>"stores/".$_POST["url-name_store"],
                                    "name"=>"logo",
                                    "width"=>270,
                                    "height"=>270
                                );

                                $saveImageLogo = CurlController::requestFile($fields);

                            }else{

                                $saveImageLogo = $response->results[0]->logo_store;

                            }

                            /*=============================================
                                TODO: Validar cambio de Portada
                            =============================================*/

                            if(isset($_FILES["portada-tienda"]["tmp_name"]) && !empty($_FILES["portada-tienda"]["tmp_name"])){

                                $fields = array(

                                    "file"=>$_FILES["portada-tienda"]["tmp_name"],
                                    "type"=>$_FILES["portada-tienda"]["type"],
                                    "folder"=>"stores/".$_POST["url-name_store"],
                                    "name"=>"portada",
                                    "width"=>1424,
                                    "height"=>768
                                );

                                $saveImagePortada = CurlController::requestFile($fields);

                            }else{

                                $saveImagePortada = $response->results[0]->cover_store;

                            }

                            /*=============================================
                                TODO: Agrupamos Redes Sociales
                            =============================================*/

                            $socialNetwork = array();

                            if(isset($_POST["facebook-tienda"]) && !empty($_POST["facebook-tienda"])){

                                array_push($socialNetwork, ["facebook"=> "https://facebook.com/".$_POST["facebook-tienda"]]);

                            }

                            if(isset($_POST["instagram-tienda"]) && !empty($_POST["instagram-tienda"])){

                                array_push($socialNetwork, ["instagram"=> "https://instagram.com/".$_POST["instagram-tienda"]]);

                            }

                            if(isset($_POST["twitter-tienda"]) && !empty($_POST["twitter-tienda"])){

                                array_push($socialNetwork, ["twitter"=> "https://twitter.com/".$_POST["twitter-tienda"]]);

                            }

                            if(isset($_POST["linkedin-tienda"]) && !empty($_POST["linkedin-tienda"])){

                                array_push($socialNetwork, ["linkedin"=> "https://linkedin.com/".$_POST["linkedin-tienda"]]);

                            }

                            if(isset($_POST["youtube-tienda"]) && !empty($_POST["youtube-tienda"])){

                                array_push($socialNetwork, ["youtube"=> "https://youtube.com/".$_POST["youtube-tienda"]]);

                            }

                            if(count($socialNetwork) > 0){

                                $socialNetwork = json_encode($socialNetwork);

                            }else{

                                $socialNetwork = null;
                            }

                            /*=============================================
                                TODO: Agrupamos la información
                            =============================================*/

                            $data ="name_store=".trim(TemplateController::capitalize($_POST["name-store"]))."&url_store=".trim($_POST["url-name_store"])."&about_store=".trim($_POST["informacion-tienda"])."&abstract_store=".substr(trim($_POST["informacion-tienda"]), 0, 100)."..."."&email_store=".trim(strtolower($_POST["correo-tienda"]))."&country_store=".trim(explode("_",$_POST["pais-tienda"])[0])."&city_store=".trim(TemplateController::capitalize($_POST["ciudad-tienda"]))."&address_store=".trim($_POST["direccion-tienda"])."&phone_store=". trim(explode("_",$_POST["pais-tienda"])[1]."_".$_POST["telefono-tienda"])."&logo_store=".$saveImageLogo."&cover_store=".$saveImagePortada."&socialnetwork_store=".$socialNetwork;

                            /*=============================================
                                TODO: Solicitud a la API
                            =============================================*/

                            $url = "stores?id=".$id."&nameId=id_store&token=".$_SESSION["admin"]->token_user."&table=users&suffix=user";
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
                                        fncSweetAlert("success", "Sus registros fueron actualizados con éxito.", "/tiendas");

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