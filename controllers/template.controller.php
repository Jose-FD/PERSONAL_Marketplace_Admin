<?php

    class TemplateController{

        /*================================================================
            TODO: Ruta del Sistema Administrativo
        ================================================================*/

        static public function path(){

            return "http://adminsystem2.com/";
        }

        /*================================================================
            TODO: Traemos la vista de la plantilla
        ================================================================*/

        public function index(){

            include "views/template.php";
        }

        /*================================================================
            TODO: Ruta para las imagenes del sistema
        ================================================================*/

        static public function srcImg(){

            return "http://marketplace.com/";

        }

        /*================================================================
            TODO: Devolver la imagen del Market Place
        ================================================================*/

        static public function returnImg($id, $picture, $method){

            if($method == "direct"){

                if($picture != null){

                    return TemplateController::srcImg()."views/img/users/".$id."/".$picture;

                }else{

                    return TemplateController::srcImg()."views/img/users/default/default.png";

                }

            }else{

                return $picture;

            }

        }

        /*================================================================
            TODO: Función para mayúscula inicial
        ================================================================*/

        static public function capitalize($value){

            $value = mb_convert_case($value, MB_CASE_TITLE, "UTF-8");
            return $value;
        }

        /*================================================================
            TODO: Función limpiar HTML
        ================================================================*/

        static public function htmlClean($code){

            $search = array('/\>[^\S ]+/s','/[^\S ]+\</s','/(\s)+/s');

            $replace = array('>','<','\\1');

            $code = preg_replace($search, $replace, $code);

            $code = str_replace("> <", "><", $code);

            return $code;

        }

        /*================================================================
            TODO: Promediar reseñas
        ================================================================*/

        static public function averageReviews($reviews){

            $totalReviews = 0;

            if($reviews != null){

                foreach ($reviews as $key => $value) {

                    $totalReviews += $value["review"];

                }

            return round($totalReviews/count($reviews));

            }else{

                return 0;

            }

        }




    }

?>