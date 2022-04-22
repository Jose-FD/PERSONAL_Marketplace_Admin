<?php

    class DisputesController{

        /*=============================================
            TODO: Responder la disputa
        =============================================*/

        public function answerDispute(){

            if(isset($_POST["answerDispute"])){

                $url = "disputes?id=".$_POST["idDispute"]."&nameId=id_dispute&token=".$_SESSION["admin"]->token_user."&table=users&suffix=user";
                $method = "PUT";
                $fields = "answer_dispute=".$_POST["answerDispute"]."&date_answer_dispute=".date("Y-m-d");

                $answerDispute = CurlController::request($url, $method, $fields);

                if($answerDispute->status == 200){

                    /*===============================================================================================
                        TODO: Enviamos notificación de la respuesta de la disputa al correo electrónico del cliente
                    ===============================================================================================*/

                    $name = $_POST["clientDispute"];
                    $subject = "Su disputa ha sido respondida.";
                    $email = $_POST["emailDispute"];
                    $message =  "Su disputa ha sido respondida.";
                    $url = TemplateController::srcImg()."account&my-shopping";

                    $sendEmail = TemplateController::sendEmail($name, $subject, $email, $message, $url);

                    if($sendEmail == "ok"){

                        echo '<script>

                                fncFormatInputs();

                                fncNotie(1, "La respuesta se ha guardado.");

                            </script>
                        ';

                    }


                }

            }

        }


    }

?>