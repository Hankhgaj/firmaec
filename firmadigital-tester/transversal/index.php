<!DOCTYPE html>
<html lang="es">
        <head>
                <meta charset="utf-8" />
                <link href="bootstrap.min.css" rel="stylesheet" />
                <title>Sistema Transversal X</title>
        </head>
        <body>
                <h1>Sistema Transversal X</h1>
                <p>*No subir archivo con peso mayor a 8mb</p>
                <p>*Si se firma en lote, el total de todos los documentos no puede ser mayor a 10mb</p>
                <p>*Nombre del documento no debe exeder 180 caracteres</p>
                <p>*Nombre del documento no debe tener caracteres especiales</p>
                <h2>Firmar en Sistema Transversal X</h2>
                <form action="upload.php" id="formData" method="post" enctype="multipart/form-data">
                <table class="default">
                    <tr>
                        <td>
                                <label for="cedula">Cédula: </label>
                        </td>
                        <td>
                                <input type="text" name="cedula" id="cedula" required />
                        </td>
                    </tr>
                    <tr>
                        <td>
                                <label for="ambiente">Ambiente: </label>
                        </td>
                        <td>
                                <select name="ambiente" id="ambiente">
                                        <option value="pro">Producción</option>
                                        <option value="pre">PreProducción</option>
                                        <option value="des" selected>Desarrollo</option>
                                        <option value="error">Error</option>
                                </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                                <label for="tipoFirmaEC">Tipo FirmaEC: </label>
                        </td>
                        <td>
                                <select name="tipoFirmaEC" id="tipoFirmaEC">
                                        <option value="centralizada">Centralizada</option>
                                        <option value="descentralizada" selected>Descentralizada</option>
                                        <option value="error">Error</option>
                                </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                                <label for="certificadoDigital">Certificado Digital: </label>
                        </td>
                        <td>
                                <select name="certificadoDigital" id="certificadoDigital">
                                        <option value="archivo" selected>Archivo</option>
                                        <option value="token">Token</option>
                                        <option value="error">Error</option>
                                </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                                <label for="estampado">Estampado: </label>
                        </td>
                        <td>
                                <select name="estampado" id="estampado">
                                        <option value="qr" selected>QR</option>
                                        <option value="information1">Información 1</option>
                                        <option value="information2">Información 2</option>
                                        <option value="invisible">Invisible</option>
                                        <option value="error">Error</option>
                                </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                                <label for="tipoDocumento">Tipo de Documento: </label>
                        </td>
                        <td>
                                <select name="tipoDocumento" id="estampado">
                                        <option value="pdf" selected>pdf</option>
                                        <option value="xml">xml</option>
                                        <option value="error">Error</option>
                                </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                                <label for="copia">Nro copias: </label>
                        </td>
                        <td>
                                <input type="number" name="copia" id="copia" step="1" value="1" required/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                                <label for="posX">Posición horizontal estampado X: </label>
                        </td>
                        <td>
                                <input type="number" name="posX" id="posX" step="1" value="105" required/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                                <label for="posY">Posición Vertical estampado Y: </label>
                        </td>
                        <td>
                                <input type="number" name="posY" id="posY" step="1" value="148" required/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                                <label for="fileToUpload">Documento: </label>
                        </td>
                        <td>
                                <input type="file" name="fileToUpload" id="fileToUpload" accept="application/pdf, application/xml"required/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                                <input type="submit" value="Upload"/>
                        </td>
                    </tr>
                </table>
                </form>

                <!-- <h2>Verificar documento en servicio validacionavanzadapdf</h2>
                <form action="uploadvalidacionavanzadapdf.php" id="formDataRest" method="post" enctype="multipart/form-data">
                <table class="defaultRest" border-collapse: separate;>
                    <tr>
                        <td>
                                <label for="fileToUpload">Documento: </label>
                        </td>
                        <td>
                                <input type="file" name="fileToUpload" id="fileToUpload" accept="application/pdf"required/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                                <input type="submit" value="Upload"/>
                        </td>
                    </tr>
                </table>
                </form>

                <h2>Verificar documento en servicio validacionpdf</h2>
                <form action="uploadvalidacionpdf.php" id="formDataRest" method="post" enctype="multipart/form-data">
                <table class="defaultRest" border-collapse: separate;>
                    <tr>
                        <td>
                                <label for="fileToUpload">Documento: </label>
                        </td>
                        <td>
                                <input type="file" name="fileToUpload" id="fileToUpload" accept="application/pdf"required/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                                <input type="submit" value="Upload"/>
                        </td>
                    </tr>
                </table>
                </form>

                <h2>Verificar documento en servicio validacioncms</h2>
                <form action="uploadvalidacioncms.php" id="formDataRest" method="post" enctype="multipart/form-data">
                <table class="defaultRest" border-collapse: separate;>
                    <tr>
                        <td>
                                <label for="fileToUpload">Documento: </label>
                        </td>
                        <td>
                                <input type="file" name="fileToUpload" id="fileToUpload" accept="application/p7m"required/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                                <input type="submit" value="Upload"/>
                        </td>
                    </tr>
                </table>
                </form> -->

        </body>
</html>

<script>
        var uploadField = document.getElementById("fileToUpload");
        uploadField.onchange = function() {
                if(this.files[0].name.length >= 180){
                        alert("Nombre del documento es muy extenso y no debe exeder 180 caracteres");
                        this.value = "";
                };
                if(this.files[0].size >= 8388608){
                        alert("Documento(s) exede(n) peso permitido para firmar, máximo hasta 8 MB");
                        this.value = "";
                };
        };
</script>

