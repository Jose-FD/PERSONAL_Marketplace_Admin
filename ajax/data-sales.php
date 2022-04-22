<?php

    require_once "../controllers/curl.controller.php";
    require_once "../controllers/template.controller.php";

    class DatatableController{

        public function data(){

            if(!empty($_POST)){

                /*=====================================================================
                    TODO: Capturando y organizando las variables POST de DataTable
                =====================================================================*/

                $draw = $_POST["draw"];//Contador utilizado por DataTables para garantizar que los retornos de Ajax de las solicitudes de procesamiento del lado del servidor sean dibujados en secuencia por DataTables

                $orderByColumnIndex = $_POST['order'][0]['column']; //Índice de la columna de clasificación (0 basado en el índice, es decir, 0 es el primer registro)

                $orderBy = $_POST['columns'][$orderByColumnIndex]["data"];//Obtener el nombre de la columna de clasificación de su índice

                $orderType = $_POST['order'][0]['dir'];// Obtener el orden ASC o DESC

                $start  = $_POST["start"];//Indicador de primer registro de paginación.

                $length = $_POST['length'];//Indicador de la longitud de la paginación.

                /*=====================================================================
                    TODO: El total de registros de la data
                =====================================================================*/

                $url = "sales?select=id_sale&linkTo=date_created_sale&between1=".$_GET["between1"]."&between2=".$_GET["between2"];

                $method = "GET";
                $fields = array();

                $response = CurlController::request($url, $method, $fields);

                if($response->status == 200){

                    $totalData = $response->total;

                }else{

                    echo '{"data": []}';
                    return;

                }

                /*=====================================================================
                    TODO: Busqueda de datos
                =====================================================================*/

                $select = "id_sale,status_sale,commission_sale,unit_price_sale,name_store,email_order,name_product_sale,quantity_order,payment_method_sale,id_payment_sale,date_created_sale,id_user_store";

                if(!empty($_POST['search']['value'])){

                    if(preg_match('/^[0-9A-Za-zñÑáéíóú ]{1,}$/',$_POST['search']['value'])){

                        $linkTo = ["name_product_sale","payment_method_sale","id_payment_sale","email_order","name_store","date_created_sale"];

                        $search = str_replace(" ", "_", $_POST['search']['value']);

                        foreach($linkTo as $key => $value) {

                            $url = "relations?rel=sales,orders,stores&type=sale,order,store&select=".$select."&linkTo=".$value."&search=".$search."&orderBy=".$orderBy."&orderMode=".$orderType."&startAt=".$start."&endAt=".$length;

                            $data = CurlController::request($url, $method, $fields)->results;

                            if($data == "Not Found"){

                                $data = array();
                                $recordsFiltered = count($data);

                            }else{

                                $data = $data;
                                $recordsFiltered = count($data);

                                break;

                            }

                        }
                    }else{

                        echo '{"data": []}';
                        return;

                    }

                }else{

                    /*=====================================================================
                        TODO: Seleccionar datos
                    =====================================================================*/

                    $url = "relations?rel=sales,orders,stores&type=sale,order,store&select=".$select."&linkTo=date_created_sale&between1=".$_GET["between1"]."&between2=".$_GET["between2"]."&orderBy=".$orderBy."&orderMode=".$orderType."&startAt=".$start."&endAt=".$length;

                    $data = CurlController::request($url, $method, $fields)->results;

                    $recordsFiltered = $totalData;

                }

                /*=====================================================================
                    TODO: Cuando la data viene vacía
                =====================================================================*/

                if(empty($data)){

                    echo '{"data": []}';
                    return;

                }

                /*=====================================================================
                    TODO: Construimos el dato JSON a regresar
                =====================================================================*/

                $dataJson = '{

                    "Draw": '.intval($draw).',
                    "recordsTotal": '.$totalData.',
                    "recordsFiltered": '.$recordsFiltered.',
                    "data": [';

                    /*=====================================================================
                        TODO: Recorremos la data
                    =====================================================================*/

                    foreach($data as $key => $value){

                        if($_GET["text"] == "flat"){

                            $status_sale = $value->status_sale;

                        }else{

                            if($value->status_sale == 'pending'){

                                if($_GET["idAdmin"] == $value->id_user_store){

                                    $status_sale = "<span class='badge badge-danger p-2'>".$value->status_sale."</span>";

                                }else{

                                    $status_sale = "<span class='badge badge-dark p-2'>".$value->status_sale."</span>";
                                }

                            }else{

                                $status_sale = "<span class='badge badge-success p-2'>".$value->status_sale."</span>";

                            }

                        }

                        /*=====================================================================
                            TODO: Comision gananda por el marketplace
                        =====================================================================*/

                        $commission_sale = $value->commission_sale;

                        /*=====================================================================
                            TODO: Ganancia del vendedor
                        =====================================================================*/

                        $unit_price_sale =  $value->unit_price_sale;

                        /*=====================================================================
                            TODO: Valor de la venta
                        =====================================================================*/

                        $total_sale = $value->commission_sale + $value->unit_price_sale;

                        /*=====================================================================
                            TODO: Nombre de la tienda
                        =====================================================================*/

                        $name_store = $value->name_store;

                        /*=====================================================================
                            TODO: Email del comprador
                        =====================================================================*/

                        $email_order = $value->email_order;

                        /*=====================================================================
                            TODO: Producto de la orden
                        =====================================================================*/

                        $name_product_sale = $value->name_product_sale;

                        /*=====================================================================
                            TODO: Cantidad de la orden
                        =====================================================================*/

                        $quantity_order = $value->quantity_order;

                        /*=====================================================================
                            TODO: Método de pago
                        =====================================================================*/

                        $payment_method_sale = $value->payment_method_sale;

                        /*=====================================================================
                            TODO: ID de pago
                        =====================================================================*/

                        $id_payment_sale = $value->id_payment_sale;

                        /*=====================================================================
                            TODO: Fecha de creación del la orden
                        =====================================================================*/

                        $date_created_sale = $value->date_created_sale;

                        $dataJson.='{

                            "id_sale":"'.($start+$key+1).'",
                            "status_sale":"'.$status_sale.'",
                            "commission_sale":"'.$commission_sale.'",
                            "unit_price_sale":"'.$unit_price_sale.'",
                            "total_sale":"'.$total_sale.'",
                            "name_store":"'.$name_store.'",
                            "email_order":"'.$email_order.'",
                            "name_product_sale":"'.$name_product_sale.'",
                            "quantity_order":"'.$quantity_order.'",
                            "payment_method_sale":"'.$payment_method_sale.'",
                            "id_payment_sale":"'.$id_payment_sale.'",
                            "date_created_sale":"'.$date_created_sale.'"

                        },';

                    }

                $dataJson = substr($dataJson,0,-1); // este substr quita el último caracter de la cadena, que es una coma, para impedir que rompa la tabla

                $dataJson .= ']}';

                echo $dataJson;

            }
        }
    }


    /*=============================================
        TODO: Activar función DataTable
    =============================================*/

    $data = new DatatableController();
    $data -> data();

?>