@echo off

rem Establecer la ubicación del archivo JAR de PostgreSQL
set "POSTGRESQL_JAR=C:\Users\Henry\Desktop\FIRMA EC\postgresql-42.7.3.jar"

rem Establecer la ubicación del archivo jboss-cli.bat
set "JBOSS_CLI=C:\wildfly-32.0.0.Final\bin\jboss-cli.bat"

rem Establecer la ubicación del archivo temporal en la misma carpeta que el script batch
set "TEMP_FILE=%~dp0comandosjboss.txt"

rem Crear el archivo temporal para almacenar los comandos
(
  echo module add --name=org.postgresql --resources="%POSTGRESQL_JAR%" --dependencies=javax.api,javax.transaction.api
  echo /subsystem=datasources/jdbc-driver=postgresql:add(driver-name=postgresql,driver-module-name=org.postgresql,driver-xa-datasource-class-name=org.postgresql.xa.PGXADataSource)
  echo data-source add --name=FirmaDigitalDS --jndi-name=java:/FirmaDigitalDS --driver-name=postgresql --connection-url=jdbc:postgresql://localhost:5432/firmadigital --user-name=firmadigital --password=firmadigital --valid-connection-checker-class-name=org.jboss.jca.adapters.jdbc.extensions.postgres.PostgreSQLValidConnectionChecker --exception-sorter-class-name=org.jboss.jca.adapters.jdbc.extensions.postgres.PostgreSQLExceptionSorter
) > "%TEMP_FILE%"

rem Verificar si el archivo temporal fue creado correctamente
if exist "%TEMP_FILE%" (
    rem Ejecutar los comandos desde el archivo temporal
    "%JBOSS_CLI%" --connect --file="%TEMP_FILE%"
    
    rem Eliminar el archivo temporal después de usarlo
    del "%TEMP_FILE%"
) else (
    echo Error: El archivo de comandos no se pudo crear.
)
