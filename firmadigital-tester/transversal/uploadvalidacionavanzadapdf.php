<?php
$file_tmp = $_FILES['fileToUpload']['tmp_name'];
$data = file_get_contents($file_tmp);
$filename = $_FILES['fileToUpload']['name'];
// Documento en Base64
$documento_base64 = base64_encode($data);
//URl del WS REST para validar PDFs
$url = "https://impws.firmadigital.gob.ec/servicio/validacionavanzadapdf";
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
    echo "firmasValidas: ".$data->firmasValidas."<br/>";
    echo "integridadDocumento: ".$data->integridadDocumento."<br/>";
    echo "error: ".$data->error."<br/><br/>";
    foreach($data->certificado as $certificado){
            echo "certificado->emitidoPara: ".$certificado->emitidoPara."<br/>";
            echo "certificado->emitidoPor: ".$certificado->emitidoPor."<br/>";
            echo "certificado->validoDesde: ".$certificado->validoDesde."<br/>";
            echo "certificado->validoHasta: ".$certificado->validoHasta."<br/>";
            echo "certificado->fechaFirma: ".$certificado->fechaFirma."<br/>";
            echo "certificado->fechaRevocado: ".$certificado->fechaRevocado."<br/>";
            echo "certificado->certificadoVigente: ".$certificado->certificadoVigente."<br/>";
            echo "certificado->clavesUso: ".$certificado->clavesUso."<br/>";
            echo "certificado->fechaSelloTiempo: ".$certificado->fechaSelloTiempo."<br/>";
            echo "certificado->integridadFirma: ".$certificado->integridadFirma."<br/>";
            echo "certificado->razonFirma: ".$certificado->razonFirma."<br/>";
            echo "certificado->localizacion: ".$certificado->localizacion."<br/>";
            echo "certificado->cedula: ".$certificado->cedula."<br/>";
            echo "certificado->nombre: ".$certificado->nombre."<br/>";
            echo "certificado->apellido: ".$certificado->apellido."<br/>";
            echo "certificado->institucion: ".$certificado->institucion."<br/>";
            echo "certificado->cargo: ".$certificado->cargo."<br/>";
            echo "certificado->entidadCertificadora: ".$certificado->entidadCertificadora."<br/>";
            echo "certificado->serial: ".$certificado->serial."<br/>";
            echo "certificado->selladoTiempo: ".$certificado->selladoTiempo."<br/>";
            echo "certificado->certificadoDigitalValido: ".$certificado->certificadoDigitalValido."<br/><br/>";
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
