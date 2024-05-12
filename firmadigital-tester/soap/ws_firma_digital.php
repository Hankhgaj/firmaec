<?php
/**
*------------------------------------------------------------------------------
*    This program is free software: you can redistribute it and/or modify
*    it under the terms of the GNU Affero General Public License as
*    published by the Free Software Foundation, either version 3 of the
*    License, or (at your option) any later version.
*    This program is distributed in the hope that it will be useful,
*    but WITHOUT ANY WARRANTY; without even the implied warranty of
*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*    GNU Affero General Public License for more details.
*
*    You should have received a copy of the GNU Affero General Public License
*    along with this program.  If not, see http://www.gnu.org/licenses. 
*------------------------------------------------------------------------------
**/
/**
* Cliente para guardar los documentos firmados
*/
	function grabar_archivos_firmados($usuario, $nombre_doc, $archivo, $datos_firmante, $fecha, $institucion, $cargo) {
		$carpeta = "C:/xampp/htdocs/firmadigital-tester/soap/tmp/".date('YmdHis');  // --> Carpeta donde se guardan los archivos local 👀
		if(!file_exists($carpeta)){
			mkdir($carpeta,0777,true);
		}
		$ruta_destino_archivo = $carpeta."/".$nombre_doc;
		//grabamos en servidor
                $archivo_ok = file_put_contents($ruta_destino_archivo, $archivo);
        	//retorno de bandera para el servicio web
		if($archivo_ok) {
			return 1;
		} else {
			return 0;
		}
	}
	// Averiguar ruta servidor
	ini_set("soap.wsdl_cache_enabled", "0");
	$sServer = new SoapServer("http://localhost/firmadigital-tester/soap/firma_digital.wsdl"); // --> Ruta del soap local 👀
	$sServer->addFunction("grabar_archivos_firmados");
	$sServer->handle();
?>
