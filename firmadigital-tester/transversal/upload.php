<?php
	//var_dump($_POST);
	//no superar el peso en MB establecido por el servicio web (unico archivo)
	if (isset($_SERVER["CONTENT_LENGTH"])) {
		$post_max_size = (int)ini_get('post_max_size');
		if ($_SERVER["CONTENT_LENGTH"] > ($post_max_size * 1024 * 1024)) {
			echo "<script>
				alert('Documento(s) exede(n) peso permitido para firmar, máximo hasta $post_max_size MB');
				window.history.go(-1);
			</script>";
		}
	}
        $mb = 1024;//representación MB
	// Leer archivo de propiedades
	$fpconfig = fopen("propiedades.config","r"); // --> Cambiar las url de propiedades.config a local 👀
		$i=0;
		$linea = array();
		while(!feof($fpconfig)){
		$linea[$i] = fgets($fpconfig);
		$i++;
	}
	fclose($fpconfig);
	// Limite peso total para firmar
	$sizeDocumento = trim($linea[0]);
	// Limite caracteres nombre documento
	$sizeNombreDocumento = trim($linea[1]);
	// Leer archivo de propiedades
	// Sistema
	$sistema = "pruebas"; // --> Sistema desde donde se hace la petición campo de la base de datos 👀
	// x-api-key
	$x_api_key = "e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855"; // --> API KEY 👀
	// Cedula
	$cedula = $_POST['cedula'];
	// n Copias
	$copia = (int) $_POST['copia'];
	// Recibir el upload:
	$file_tmp= $_FILES['fileToUpload']['tmp_name'];
	$data = file_get_contents($file_tmp);
	// Documento en Base64
	$base64 = base64_encode($data);
	$nombre_documento = $_FILES['fileToUpload']['name'];
	$documento_base64 = $base64;
	// URL servicio REST
	if(isset($_POST['ambiente'])){
		$select = $_POST['ambiente'];
		switch ($select) {
                        case 'des':
                                $urlws = trim($linea[2]);
                                $pre="&des=true";
                                break;
			case 'pre':
				$urlws = trim($linea[3]);
				$pre="&pre=true";
				break;
			case 'pro':
				$urlws = trim($linea[4]);
				$pre="";
				break;
			case 'error':
				$urlws = "error";
				$pre="error";
				break;
		}
	}
	// Tipo FirmaEC
        if(isset($_POST['tipoFirmaEC'])){
                $select = $_POST['tipoFirmaEC'];
                switch ($select) {
			case 'centralizada':
                                $url="";
                                break;
			case 'descentralizada':
				if($pre == "&des=true") {
					$url="&url=".urlencode("http://127.0.0.1:8080/api"); // --> URL de la API 👀
				}
				if($pre == "&pre=true") {
					$url="&url=".urlencode("http://127.0.0.1:8080/api"); // --> URL de la API 👀
                                }
				break;
                        case 'error':
				$url="error";
				break;
                }
        }
	// Certificado Digital
	if(isset($_POST['certificadoDigital'])){
		$select = $_POST['certificadoDigital'];
		switch ($select) {
			case 'token':
				$certificadoDigital = "&tipo_certificado=1";
				break;
			case 'archivo':
				$certificadoDigital = "&tipo_certificado=2";
				break;
			case 'error':
				$certificadoDigital = "error";
				break;
		}
	}
	// Estampado
	if(isset($_POST['estampado'])){
		$select = $_POST['estampado'];
		switch ($select) {
			case 'qr':
				$estampado = "&llx=260&lly=91&estampado=QR&razon=firmaEC";
				break;
			case 'information1':
				$estampado = "&llx=260&lly=91&estampado=information1";
				break;
			case 'information2':
				$estampado = "&llx=260&lly=91&estampado=information2";
				break;
			case 'invisible':
				$estampado = "";
				break;
			case 'error':
				$estampado = "error";
				break;
		}
	}
	// Tipo Documento
        if(isset($_POST['tipoDocumento'])){
                $select = $_POST['tipoDocumento'];
                switch ($select) {
                        case 'pdf':
                                $tipoDocumento = "";
                                break;
                        case 'xml':
                                $tipoDocumento = "&format=xml";
                                break;
                        case 'error':
                                $tipoDocumento = "error";
                                break;
                }
        }
	//no superar el limite de caracteres establecido para el nombre del documento
	if(strlen($nombre_documento)>=$sizeNombreDocumento){
	echo "<script>
			alert('Nombre del documento es muy extenso y no debe exeder $sizeNombreDocumento caracteres'); 
			window.history.go(-1);
		</script>";
	}
	//no permitir caracteres especiales
	$pattern =  '/["!@#$%&\/()]/';
	if (preg_match($pattern, $nombre_documento)) {
		echo "<script>
                        alert('Nombre del documento contiene caracteres especiales no permitidos'); 
                        window.history.go(-1);
                </script>";

	}
	//repetir n veces documento
	$repeatBody = "";
	for($i=0;$i<$copia;$i++) {
		$repeatBody = $repeatBody."{
			\"nombre\": \"".$i."-firmado-".$nombre_documento."\",
			\"documento\": \""."$documento_base64"."\"
		},";
	}
	$repeatBody = substr($repeatBody, 0 ,-1);
	// Body
	$body = "{
                \"cedula\": \"".$cedula."\",
                \"sistema\": \"".$sistema."\",
                \"documentos\":[".$repeatBody."]
        }";
	// ------------------------------------------------------------------
	//no superar el peso en MB establecido por el servicio web (varios archivos)
	if(strlen($body)<=$sizeDocumento){
		$headers = array("Content-Type: application/json", "X-API-KEY: ".$x_api_key);
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $urlws);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$token = curl_exec($curl);
		curl_close($curl);
	}else{
		$mb = 1024;
		$size_limit = ($sizeDocumento-3145728)/$mb/$mb;
		echo "<script>
			alert('Documento(s) exede(n) peso permitido para firmar, máximo hasta $size_limit MB'); 
			window.history.go(-1);
		</script>";
	}
	// ------------------------------------------------------------------
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8" />
		<link href="bootstrap.min.css" rel="stylesheet" />
		<title>Sistema Transversal X</title>
	</head>
	<body>
		<h1>Sistema Transversal X</h1>
		<p>Presione el siguiente link para firmar el documento</p>
		<a href="firmaec://<?php print $sistema ?>/firmar?token=
			<?php print $token ?>
			<?php print $certificadoDigital ?>
			<?php print $estampado ?>
			<?php print $tipoDocumento ?>
			<?php print $pre ?>
			<?php print $url ?>
		"><button type="button" class="btn">Firmar</button></a>
		<p>En caso de completar el proceso de forma exitosa, el documento firmado se encontrará en:</p>
		<a href="http://localhost/firmadigital-tester/soap/tmp/"><button type="button" class="btn">Documento Firmado</button></a>  <!-- URL del soap local 👀  -->
	</body>
</html>
