<?php

    class MessagesController{

        /*=============================================
            TODO: Responder el mensaje
        =============================================*/

        public function answerMessage(){

            if(isset($_POST["answerMessage"])){

                $url = "messages?id=".$_POST["idMessage"]."&nameId=id_message&token=".$_SESSION["admin"]->token_user."&table=users&suffix=user";
                $method = "PUT";
                $fields = "answer_message=".$_POST["answerMessage"]."&date_answer_message=".date("Y-m-d");

                $answerMessage = CurlController::request($url, $method, $fields);

                if($answerMessage->status == 200){

                    /*===============================================================================================
                        TODO: Enviamos notificación de la respuesta de la disputa al correo electrónico del cliente
                    ===============================================================================================*/

                    $name = $_POST["clientMessage"];
                    $subject = "Su mensaje ha sido respondido.";
                    $email = $_POST["emailMessage"];
                    $message =  "Su mensaje ha sido respondido.";
                    $url = TemplateController::srcImg().$_POST["urlProduct"];

                    $sendEmail = TemplateController::sendEmail($name, $subject, $email, $message, $url);

                    if($sendEmail == "ok"){

                        echo '<script>

                                fncFormatInputs();

                                fncNotie(1, "La respuesta se ha enviado.");

                            </script>
                        ';

                    }


                }

            }

        }


    }

?>