# Millnium Group Backend

## Descripción

Aplicación desarrollada en Symfony (Framewrok PHP)

## Dependencias

- [Git](https://git-scm.com/) Control Version
- [Docker](https://docs.docker.com/get-docker/) container and image manager
- [Millenium-Docker](https://github.com/ivanmendoza20111/millenium-docker) Docker para levantar la aplicación
- [Composer](https://getcomposer.org/) A Dependency Manager for PHP
- [NPM](https://www.npmjs.com/) package manager
- [PHP](https://www.php.net/downloads.php) Download PHP 7.4.29
- [MYSQL](https://www.mysql.com/downloads/) Database

#### Clonar repositorio dentro de millenium-docker con nombre backend

**HTTPS:**

```bash
$ git clone https://github.com/ivanmendoza20111/millenium-backend.git backend
```

### Ir a la carpeta backend que se acaba de clonar

```bash
$ cd backend
```

### Dentro hay que ejecutar composer para instalar las depencias de PHP:

```bash
$ composer update
```

### Luego hay que ejecutar npm para instalar las depencias de JS:

```bash
$ npm i
```

### Luego debemos de levantar nuestra aplicación en el proyecto millenium-backend, para esto nos devolvemos un folder atrás:

```bash
$ cd ..
```

### Ya ubicados dentro de **millenium-docker**, vamos a modificar a crear las variables de entornos:

```bash
$ cp .env.sample .env
```

### Ahora vamos a modificar las variables de entornos:

```bash
# Application
APP_ENV=dev
BASE_URL=https://appexternalurl/
DATA_DIR=/var/www/data

# Database
DATABASE_HOST=127.0.0.1
DATABASE_NAME=your_databasename
DATABASE_PASSWORD=your_databasepassword
DATABASE_USER=your_databaseuser
```

### Luego salvamos nuestras variables de entornos con los datos correspondientes de la Base de Datos y ejecutamos lo siguiente para levantar nuestra aplicación:

```bash
$ docker-compose up -d --build
```

### Si esta todo correcto debemos de entrar a nuestro container de backend para ejecutar las migraciones y limpiar la cache de nuestra aplicación:

### Entrar al container:

```bash
$ docker exec -it millenium-group-backend bash
```

### Luego dentro del container ejecutamos la migración:

```bash
$ php bin/console doctrine:migrations:migrate
```

### Luego limpiamos la cache de nuestra aplicación

```bash
$ php bin/console cache:clear
```

### Si esta todo correcto podemos ingresar a nuestra aplicación:

```bash
http://your_ip_address:8882/login
```

### Cualquier consulta comunicarse con **Iván Mendoza**
