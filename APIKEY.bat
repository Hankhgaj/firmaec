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

REM Guarda el API KEY y el hash SHA-256 en un archivo de texto
echo El API-KEY a utilizar es %API_KEY% > keys.txt
echo El HASH-256 del API-KEY, a insertar en la base de datos, es %API_KEY_HASH% >> keys.txt

REM Elimina archivos temporales
del temp.txt
del hash.txt

echo Se ha guardado el API-KEY y el HASH-256 en keys.txt
pause

