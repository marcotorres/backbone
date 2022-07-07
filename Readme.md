# Proyecto Backbone

Project Backbone Challenge Senior Backend Developer.

## Requisitos

* docker 20.10
* docker-composer 1.29 


## Instalación

Agrega la siguiente configuración en tu archivo /etc/hosts
    
    127.0.0.1   api.backbone.localhost

Ejecuta:

    make setup_project

## Desarrollo

El proyecto se ha construido en base a Laravel 9.x, localmente el desarrollo se gestiona con docker y podrás realizar procesos básicos como:

- **make start**: para iniciar todo el proyecto
- **make restart**: si queremos reiniciar los contenedores
- **make stop**: para detener todo el proyecto
- **make clean**: para limpiar la configuración de cache y vistas del proyecto
- **make optimize**: para ejecutar optimize de artisan
- **make status**: para conocer el estado de los servicios levantados con docker
- **make logs**: para mostrar todos los logs de los servicios levantados con docker
- **make cli**: para poder ingresar al contenedor de la aplicación
- **make cli_db**: para poder ingresar al contenedor de la base de datos
- **make cli_node**: para poder ingresar al contenedor nodejs de la aplicación
- **make node_build**: para transpilar la aplicación 
- **make setup_project**: configuración inicial del proyecto (solo se debe de ejecutar una vez)
- **make phpcs**: para el análisis de código con PHP_CodeSniffer (PHPCS)
- **make qa**: para el análisis de código con PHPLINT, PHPCS y PHPSTAN
- **make key**: genera la clave de la aplicación
- **make migrate**: ejecuta la migración de estructura de base de datos
- **make populate**: migra los datos del xml a la base de datos

Los ambientes del proyecto son:

- Local: http://api.backbone.localhost
- Develop: https://api.backbone.marcotorres.pe

## Migración de estructura de base de datos

Para crear las tablas executa:

    make migrate

## Popular datos de código postal

Ejecuta:

    make populate
