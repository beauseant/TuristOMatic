# TuristOMatic
Segunda parte del procesado de webs turisticas. En la primera parte, ConsultasT, se generaba una interfaz web para realizar la clasificación de las consultas.

Ahora, en esta segunda parte, se procesarán las clasificaciones anteriores junto con otros datos y se mostrarán los datos vía web.

## Completar la base de datos en MongoDB:

Para rellenar la base de datos contamos con los siguientes ficheros en la carpeta principal:

- Carpeta example: Esta carpete contiene un ejemplo de los ficheros para el idioma alemán. Es una versión mínima, unas diez líneas de cada fichero frente a las cientos de miles de las originales, pero sirve para hacerse un idea.
- Carpeta principal. En esta carpeta tenemos diferentes programas en python que se encargan de subir los datos de los destinos, las busquedas y las consultas. Deben lanzarse en orden. Para no tener que recordar ese orden se ha creado el siguiente programa.
- lanzar.sh: Este script bash se encarga de ejecutar todas las operaciones necesarias para rellenar la base de datos:

```
./lanzar.sh 
    example/DE/categorias/categorias.csv 
    example/DE/busquedas/
    /usr/local/anaconda3/bin/python
    <DBHOST>
    <DBNAME>
    <DBUSER>
    <DBPWD>
    example/DE/destinos.csv 
    <CODIFICACION CSVs (UTF-8, Windows-8251)>
```
- Para comprobar la codificación de los ficheros, nada mejor que usar:
```
chardetect nombredelfichero
```

## Ver la base de datos vía Web:

En la carpeta Web tenemos la aplicación Web que permite trabajar sobre la base de datos. Se ha escrito en PHP por lo que será necesario instalar un servidor Web como Apache.

## Notas adicionales para la instalación:

### Instalar controlador MongoDB en PHP:
```
sudo dnf install openssl openssl-devel
sudo dnf install php-mongodb
sudo dnf -y install gcc php-pear php-devel
sudo dnf install composer
sudo pecl install mongodb

Editar php.ini para meter en la Dynamics Library:
		extension=mongodb.so

Y después:
http://php.net/manual/en/mongodb.tutorial.library.php

```

En el PHP.ini conviene subir el tiempo de ejecución del script y la memoria usada al máximo que nos permita el sistema y nuestra paciencia.







