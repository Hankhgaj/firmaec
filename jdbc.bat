@echo off

rem Establecer la ubicación del archivo JAR de PostgreSQL
set POSTGRESQL_JAR=C:\Users\Henry\Desktop\FIRMA EC\postgresql-42.7.3.jar

rem Navegar al directorio bin de WildFly
cd /d "C:\wildfly-31.0.1.Final\bin"

rem Ejecutar el script de JBoss CLI
jboss-cli.bat --command="batch"
jboss-cli.bat --command="module add --name=org.postgresql --resources=%POSTGRESQL_JAR% --dependencies=javax.api,javax.transaction.api"
jboss-cli.bat --command="/subsystem=datasources/jdbc-driver=postgresql:add(driver-name=postgresql,driver-module-name=org.postgresql,driver-xa-datasource-class-name=org.postgresql.xa.PGXADataSource)"
jboss-cli.bat --command="data-source add --name=FirmaDigitalDS --jndi-name=java:/FirmaDigitalDS --driver-name=postgresql --connection-url=jdbc:postgresql://localhost:5432/firmadigital --user-name=firmadigital --password=firmadigital --valid-connection-checker-class-name=org.jboss.jca.adapters.jdbc.extensions.postgres.PostgreSQLValidConnectionChecker --exception-sorter-class-name=org.jboss.jca.adapters.jdbc.extensions.postgres.PostgreSQLExceptionSorter"
jboss-cli.bat --command="run-batch"