@echo off

REM Genera una cadena aleatoria de longitud 32 para el API KEY
setlocal enabledelayedexpansion
set "API_KEY="
for /l %%i in (1,1,32) do (
    set /a "char = !random! %% 94 + 33"
    for %%a in (!char!) do set "API_KEY=!API_KEY!%%a"
)

REM Calcula el hash SHA-256 del API KEY
echo %API_KEY% > temp.txt
certutil -hashfile temp.txt SHA256 | findstr /R "^[0-9a-fA-F]*$" > hash.txt
set /p API_KEY_HASH=<hash.txt

REM Guardar el API KEY y su hash SHA-256 en un archivo de texto
echo El API-KEY a utilizar es %API_KEY% > keys.txt
echo El HASH-256 del API-KEY, a insertar en la base de datos, es %API_KEY_HASH% >> keys.txt

REM Crear un archivo temporal con los comandos SQL
echo CREATE DATABASE firmadigital; > temp.sql
echo ALTER DATABASE firmadigital OWNER TO firmadigital; >> temp.sql
echo GRANT ALL PRIVILEGES ON DATABASE firmadigital TO firmadigital; >> temp.sql
echo \connect firmadigital; >> temp.sql
echo CREATE TABLE IF NOT EXISTS sistema (id SERIAL PRIMARY KEY, nombre VARCHAR(100), url VARCHAR(255), apikey VARCHAR(64), descripcion VARCHAR(255),apikeyrest VARCHAR(64)); >> temp.sql
echo INSERT INTO sistema(nombre,url,apikey,descripcion,apikeyrest) VALUES ('pruebas', 'http://localhost/firmadigital-tester/rest/api_rest.php', '%API_KEY_HASH%', 'pruebas', 'pruebas'); >> temp.sql

REM Ejecutar los comandos SQL utilizando psql
psql -U postgres -f temp.sql

REM Eliminar archivos temporales
del temp.txt
del hash.txt
del temp.sql

pause
