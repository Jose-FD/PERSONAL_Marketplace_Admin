<?php

    class ProductsController{

        /*===========================================================================================
            TODO: Creación de Productos
        ===========================================================================================*/

        public function create(){

            if(isset($_POST["name-product"])){

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

                if( preg_match('/^[0-9A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST["name-product"] ) &&
                    preg_match('/^[.\\,\\0-9]{1,}$/', $_POST["precio-producto"] ) &&
                    preg_match('/^[.\\,\\0-9]{1,}$/', $_POST["precioenvio-producto"] ) &&
                    preg_match('/^[0-9]{1,}$/', $_POST["delivery_time-producto"] ) &&
                    preg_match('/^[0-9]{1,}$/', $_POST["stock-producto"] )){


                        /*=============================================
                            TODO: Proceso para configurar la galería
                        =============================================*/

                        $galleryProduct = array();
                        $countGallery = 0;

                        foreach (json_decode($_POST["galeria-producto"],true) as $key => $value) {

                            $countGallery++;

                            $fields = array(

                                "file"=>$value["file"],
                                "type"=>$value["type"],
                                "folder"=>"products/".explode("_",$_POST["name-category"])[1]."/gallery",
                                "name"=>$_POST["url-name_product"]."_".mt_rand(100000000, 9999999999),
                                "width"=>$value["width"],
                                "height"=>$value["height"]
                            );

                            $saveImageGaleria = CurlController::requestFile($fields);

                            array_push($galleryProduct, $saveImageGaleria);

                        }

                        if($countGallery == count($galleryProduct)){

                            /*=============================================
                                TODO: Validación de Imagen del Producto
                            =============================================*/

                            if(isset($_FILES["imagen-producto"]["tmp_name"]) && !empty($_FILES["imagen-producto"]["tmp_name"])){

                                $fields = array(

                                    "file"=>$_FILES["imagen-producto"]["tmp_name"],
                                    "type"=>$_FILES["imagen-producto"]["type"],
                                    "folder"=>"products/".explode("_",$_POST["name-category"])[1],
                                    "name"=>$_POST["url-name_product"],
                                    "width"=>300,
                                    "height"=>300
                                );

                                $saveImageProducto = CurlController::requestFile($fields);

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
                                TODO: Agrupamos el resumen
                            =============================================*/

                            if(isset($_POST["inputSummary"])){

                                $summaryProduct = array();

                                for($i = 0; $i < $_POST["inputSummary"]; $i++){

                                    array_push($summaryProduct, trim($_POST["summary-product_".$i]));

                                }

                            }

                            /*=============================================
                                TODO: Agrupamos el detalle
                            =============================================*/

                            if(isset($_POST["inputDetails"])){

                                $detailsProduct = array();

                                for($i = 0; $i < $_POST["inputDetails"]; $i++){

                                    $detailsProduct[$i] = (object)["title"=>trim($_POST["details-title-product_".$i]),"value"=>trim($_POST["details-value-product_".$i])];

                                }

                            }

                            /*=============================================
                                TODO: Agrupamos especificaciones técnicas
                            =============================================*/

                            if(isset($_POST["inputSpecifications"])){

                                $specificationsProduct = array();

                                for($i = 0; $i < $_POST["inputSpecifications"]; $i++){

                                    $specificationsProduct[$i] = (object)[trim($_POST["spec-type-product_".$i])=>explode(",",trim($_POST["spec-value-product_".$i]))];

                                }

                                $specificationsProduct = json_encode($specificationsProduct);

                                if($specificationsProduct == '[{"":[""]}]'){

                                    $specificationsProduct = null;

                                }

                            }else{

                                $specificationsProduct = null;

                            }

                            /*=============================================
                                TODO: Agrupamos data del video
                            =============================================*/

                            if(!empty($_POST['type_video']) && !empty($_POST['id_video'])){

                                $video_product = array();

                                if(preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,100}$/', $_POST['id_video'])){

                                    array_push($video_product, $_POST['type_video']);
                                    array_push($video_product, $_POST['id_video']);

                                    $video_product = json_encode($video_product);

                                }else{

                                    echo '<script>

                                        fncFormatInputs();
                                        matPreloader("off");
                                        fncSweetAlert("close", "", "");
                                        fncNotie(3, "Error en sintaxis en los campos del Video");

                                    </script>';

                                    return;

                                }


                            }else{

                                $video_product = null;

                            }

                            /*=====================================================
                                TODO: Agrupar información para Top Banner
                            =====================================================*/

                            if(isset($_FILES['topBanner']["tmp_name"]) && !empty($_FILES['topBanner']["tmp_name"])){

                                $fields = array(

                                    "file"=>$_FILES['topBanner']["tmp_name"],
                                    "type"=>$_FILES['topBanner']["type"],
                                    "folder"=>"products/".explode("_",$_POST["name-category"])[1]."/top",
                                    "name"=>$_POST["url-name_product"]."_".mt_rand(100000000, 9999999999),
                                    "width"=>1920,
                                    "height"=>80
                                );

                                $saveImageTopBanner = CurlController::requestFile($fields);

                                if($saveImageTopBanner != "error"){

                                    if( isset($_POST['topBannerH3Tag']) &&
                                        preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST['topBannerH3Tag']) &&
                                        isset($_POST['topBannerP1Tag']) &&
                                        preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST['topBannerP1Tag']) &&
                                        isset($_POST['topBannerH4Tag']) &&
                                        preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST['topBannerH4Tag']) &&
                                        isset($_POST['topBannerP2Tag']) &&
                                        preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST['topBannerP2Tag']) &&
                                        isset($_POST['topBannerSpanTag']) &&
                                        preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST['topBannerSpanTag']) &&
                                        isset($_POST['topBannerButtonTag']) &&
                                        preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST['topBannerButtonTag'])
                                    ){

                                        $topBanner = (object)[

                                            "H3 tag"=>TemplateController::capitalize($_POST['topBannerH3Tag']),
                                            "P1 tag"=>TemplateController::capitalize($_POST['topBannerP1Tag']),
                                            "H4 tag"=>TemplateController::capitalize($_POST['topBannerH4Tag']),
                                            "P2 tag"=>TemplateController::capitalize($_POST['topBannerP2Tag']),
                                            "Span tag"=>TemplateController::capitalize($_POST['topBannerSpanTag']),
                                            "Button tag"=>TemplateController::capitalize($_POST['topBannerButtonTag']),
                                            "IMG tag"=>$saveImageTopBanner

                                        ];

                                    }else{

                                        echo '<script>

                                            fncFormatInputs();

                                            fncNotie(3, "Error en la sintaxis de los campos de Top Banner.");

                                        </script>';

                                        return;

                                    }


                                }


                            }else{

                                echo '<script>

                                fncFormatInputs();

                                fncNotie(3, "Error al guardar el banner superior del producto.");

                                </script>';

                                return;

                            }

                            /*=====================================================
                                TODO: Agrupar información para Default Banner
                            =====================================================*/

                            if(isset($_FILES['defaultBanner']["tmp_name"]) && !empty($_FILES['defaultBanner']["tmp_name"])){

                                $fields = array(

                                    "file"=>$_FILES['defaultBanner']["tmp_name"],
                                    "type"=>$_FILES['defaultBanner']["type"],
                                    "folder"=>"products/".explode("_",$_POST["name-category"])[1]."/default",
                                    "name"=>$_POST["url-name_product"]."_".mt_rand(100000000, 9999999999),
                                    "width"=>570,
                                    "height"=>210
                                );

                                $saveImageDefaultBanner = CurlController::requestFile($fields);

                                if($saveImageDefaultBanner == "error"){

                                    echo '<script>

                                        fncFormatInputs();

                                        fncNotie(3, "Error al guardar la imagen del banner predeterminado.");

                                    </script>';

                                    return;
                                }

                            }else{

                                echo '<script>

                                    fncFormatInputs();

                                    fncNotie(3, "Error al guardar el banner predeterminado del producto.");

                                </script>';

                                return;

                            }

                            /*=====================================================
                                TODO: Agrupar información para Horizontal Slider
                            =====================================================*/

                            if(isset($_FILES['hSlider']["tmp_name"]) && !empty($_FILES['hSlider']["tmp_name"])){

                                $fields = array(

                                    "file"=>$_FILES['hSlider']["tmp_name"],
                                    "type"=>$_FILES['hSlider']["type"],
                                    "folder"=>"products/".explode("_",$_POST["name-category"])[1]."/horizontal",
                                    "name"=>$_POST["url-name_product"]."_".mt_rand(100000000, 9999999999),
                                    "width"=>1920,
                                    "height"=>358
                                );

                                $saveImageHSlider = CurlController::requestFile($fields);

                                if($saveImageHSlider != "error"){

                                        if( isset($_POST['hSliderH4Tag']) &&
                                            preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST['hSliderH4Tag']) &&
                                            isset($_POST['hSliderH3_1Tag']) &&
                                            preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST['hSliderH3_1Tag']) &&
                                            isset($_POST['hSliderH3_2Tag']) &&
                                            preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST['hSliderH3_2Tag']) &&
                                            isset($_POST['hSliderH3_3Tag']) &&
                                            preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST['hSliderH3_3Tag']) &&
                                            isset($_POST['hSliderH3_4sTag']) &&
                                            preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST['hSliderH3_4sTag']) &&
                                            isset($_POST['hSliderButtonTag']) &&
                                            preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST['hSliderButtonTag'])
                                        ){

                                        $hSlider = (object)[

                                            "H4 tag"=>TemplateController::capitalize($_POST['hSliderH4Tag']),
                                            "H3-1 tag"=>TemplateController::capitalize($_POST['hSliderH3_1Tag']),
                                            "H3-2 tag"=>TemplateController::capitalize($_POST['hSliderH3_2Tag']),
                                            "H3-3 tag"=>TemplateController::capitalize($_POST['hSliderH3_3Tag']),
                                            "H3-4s tag"=>TemplateController::capitalize($_POST['hSliderH3_4sTag']),
                                            "Button tag"=>TemplateController::capitalize($_POST['hSliderButtonTag']),
                                            "IMG tag"=>$saveImageHSlider

                                        ];

                                    }else{

                                        echo '<script>

                                            fncFormatInputs();

                                            fncNotie(3, "Error en la sintaxis de los campos de Top Banner.");

                                        </script>';

                                        return;

                                    }

                                }

                            }else{

                                echo '<script>

                                        fncFormatInputs();

                                        fncNotie(3, "Error al guardar el control deslizante horizontal del producto.");

                                    </script>';

                                return;

                            }

                            /*=====================================================
                                TODO: Agrupar información para Vertical Slider
                            =====================================================*/

                            if(isset($_FILES['vSlider']["tmp_name"]) && !empty($_FILES['vSlider']["tmp_name"])){

                                $fields = array(

                                    "file"=>$_FILES['vSlider']["tmp_name"],
                                    "type"=>$_FILES['vSlider']["type"],
                                    "folder"=>"products/".explode("_",$_POST["name-category"])[1]."/vertical",
                                    "name"=>$_POST["url-name_product"]."_".mt_rand(100000000, 9999999999),
                                    "width"=>263,
                                    "height"=>629
                                );

                                $saveImageVSlider = CurlController::requestFile($fields);

                                if($saveImageVSlider == "error"){

                                    echo '<script>

                                        fncFormatInputs();

                                        fncNotie(3, "Error al guardar la imagen del control deslizante vertical.");

                                    </script>';

                                    return;
                                }


                            }else{

                                echo '<script>

                                    fncFormatInputs();

                                    fncNotie(3, "Error al guardar el control deslizante vertical del producto.");

                                </script>';

                                return;

                            }

                            /*=====================================================
                                TODO: Agrupar información de oferta
                            =====================================================*/

                            if(!empty($_POST["type_offer"]) && !empty($_POST["value_offer"]) && !empty($_POST["date_offer"])){

                                if(preg_match('/^[.\\,\\0-9]{1,}$/', $_POST['value_offer'])){

                                    $offer_product = array($_POST["type_offer"], $_POST["value_offer"], $_POST["date_offer"] );

                                    $offer_product = json_encode($offer_product);

                                }else{

                                    echo '<script>

                                        fncFormatInputs();

                                        fncNotie(3, "Error en la sintaxis de los campos de Oferta.");

                                    </script>';

                                    return;

                                }

                            }else{

                                $offer_product = null;

                            }

                            /*=============================================
                                TODO: Agrupamos la información
                            =============================================*/

                            $data = array(

                                /* "approval_product" => "Aprovado",
                                "feedback_product" => "El producto ya esta aprovado", */
                                "approval_product" => "approved",
                                "feedback_product" => "Your product was approved",
                                "state_product" => "show",
                                "id_store_product" => $_POST["nombre-tienda"],
                                "name_product" => trim(TemplateController::capitalize($_POST["name-product"])),
                                "url_product" => trim($_POST["url-name_product"]),
                                "id_category_product" => explode("_",$_POST["name-category"])[0],
                                "id_subcategory_product" => explode("_",$_POST["name-subcategory"])[0],
                                "title_list_product" =>  explode("_",$_POST["name-subcategory"])[1],
                                "price_product" => str_replace(",", ".", $_POST["precio-producto"]),
                                "shipping_product" => str_replace(",", ".", $_POST["precioenvio-producto"]),
                                "delivery_time_product" =>$_POST["delivery_time-producto"],
                                "stock_product" => $_POST["stock-producto"],
                                "image_product" => $saveImageProducto,
                                "description_product" => trim(TemplateController::htmlClean($_POST["descripcion-producto"])),
                                "tags_product" => json_encode(explode(",",$_POST["tags-producto"])),
                                "summary_product" => json_encode($summaryProduct),
                                "details_product" => json_encode($detailsProduct),
                                "specifications_product" => $specificationsProduct,
                                "gallery_product" => json_encode($galleryProduct),
                                "video_product" => $video_product,
                                "top_banner_product" => json_encode($topBanner),
                                "default_banner_product" => $saveImageDefaultBanner,
                                "horizontal_slider_product"=>json_encode($hSlider),
                                "vertical_slider_product"=>$saveImageVSlider,
                                "offer_product" => $offer_product,
                                "date_created_product" => date("Y-m-d")

                            );

                            /*=============================================
                                TODO: Solicitud a la API
                            =============================================*/

                            $url = "products?token=".$_SESSION["admin"]->token_user."&table=users&suffix=user";
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
                                        fncSweetAlert("success", "Sus registros fueron creados con éxito.", "/productos");

                                    </script>';

                            }else{

                                echo '<script>

                                        //fncFormatInputs();
                                        matPreloader("off");
                                        fncSweetAlert("close", "", "");
                                        fncNotie(3, "Error al guardar el producto.");

                                    </script>';

                            }
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