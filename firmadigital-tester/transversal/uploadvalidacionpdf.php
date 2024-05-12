<?php
$file_tmp = $_FILES['fileToUpload']['tmp_name'];
$data = file_get_contents($file_tmp);
$filename = $_FILES['fileToUpload']['name'];
// Documento en Base64
$documento_base64 = base64_encode($data);
//URl del WS REST para validar PDFs
$url = "https://impws.firmadigital.gob.ec/servicio/validacionpdf";
//Consumiendo el servicio
try {
    $headers = array("Content-Type: text/plain");
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $documento_base64);
    curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $json = curl_exec($curl);
    curl_close($curl);

    //echo json_decode($json, true);
    //var_dump(json_decode($json, true));
    $data=json_decode($json);
    foreach($data->firmantes as $certificado){
            echo "firmantes->fecha: ".$certificado->fecha."<br/>";
            echo "firmantes->cedula: ".$certificado->cedula."<br/>";
            echo "firmantes->nombre: ".$certificado->nombre."<br/>";
            echo "firmantes->cargo: ".$certificado->cargo."<br/>";
            echo "firmantes->institucion: ".$certificado->institucion."<br/><br/>";
    }
    die();
    processResponse(json_decode($json, true));
} catch (Exception $e) {
    echo 'Excepción capturada: ',  $e->getMessage(), "\n";
}
// ------------------------------------------------------------------
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <link href="bootstrap.min.css" rel="stylesheet"/>
    <title>Sistema Transversal X</title>
</head>
    <body>
        <h1>Sistema Transversal X</h1>
    </body>
</html>
