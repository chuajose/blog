# Blog
## Instalación y puesta en marcha
El aplicativo dispone de una carpeta docker, donde están los archivos necesarios para la creación de los contenedores de la aplicación. Para ello, se debe ejecutar el siguiente comando:
```bash
/usr/bin/docker compose -f docker/docker-compose.yml -p docker up -d
```
Esto instalará un servidor http Nginx una base de datos Postgresql y un servidor de aplicaciones PHP-FPM. Para acceder a la aplicación, se debe ingresar a la siguiente URL:
```bash
http://localhost
```
## Instalación Symfony
Para ello, se debe ejecutar el siguiente comando:
Accedemos al contenedor de php-fpm
```bash
docker exec -it php-fpm-blog sh
```
e instalamos las dependencias de Symfony 7
```bash
composer install
```

## Pasos para puesta en marcha
Lo primero que debemos hacer es crear la base de datos y cargar los datos de prueba. 
Para ello, ejecutamos los siguientes comandos:
```bash
bin/console doctrine:schema:update --force
```
y generamos los datos de prueba

```bash
php bin/console doctrine:fixtures:load
```
Una vez hecho esto, ya podemos acceder a la aplicación. Para ello, debemos acceder a la siguiente URL:
```bash
http://localhost/
```

## Api Docs
La aplicación dispone de una documentación de la API. Para acceder a ella, se debe acceder a la siguiente URL:
```bash
http://localhost/api/doc
```
