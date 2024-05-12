<?php
header("X-API-KEY:pruebas");  // X-API-KEY debe ser el valor de base de datos {apikeyrest} 👀

#if (isset($_POST['grabar_archivos_firmados']) && $_POST['grabar_archivos_firmados']!="") {
$json = file_get_contents('php://input');
if ($json!="" && $_SERVER["REQUEST_METHOD"]=="POST"){
        $data=json_decode($json);
        $carpeta = "C:/xampp/htdocs/firmadigital-tester/soap/tmp/".date('YmdHis');  // --> Carpeta donde se guardan los archivos local 👀
        if(!file_exists($carpeta)){
                mkdir($carpeta,0777,true);
        }
        $ruta_destino_archivo = $carpeta."/".$data->nombreDocumento;
        //grabamos en servidor
        $archivo_ok = file_put_contents($ruta_destino_archivo, base64_decode($data->archivo));
        //retorno de bandera para el servicio web
        if($archivo_ok) {
                response("OK");
        } else {
                response("NO SE GUARDO EL DOCUMENTO");
        }
}else{
        response("Invalid Request");
}

function response($response){
        echo $response;
}
?>
