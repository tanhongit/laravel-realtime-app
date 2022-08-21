# Welcome to Laravel Docker Config

This is a simple Docker Compose workflow that sets up a LEMP network of containers for local Laravel development

## Configuration requirements

To use the fpm image, you need an additional web server, such as nginx, that can proxy http-request to the fpm-port of the container. For fpm connection this container exposes port 9000.

 - Web-server: Nginx
 - PHP Version: 8.1
 - DBMS (database management system): mariadb
 - PHP Framework: Laravel 9.x
 - In-memory database: Redis
 - SSL Certificate (using mkcert)
 
## Install Steps

### 1. Install ssl certificate
Using mkcert to create ssl certificate

#### For Ubuntu

```shell
sudo apt install libnss3-tools

sudo wget https://github.com/FiloSottile/mkcert/releases/download/v1.4.3/mkcert-v1.4.3-linux-amd64 && \
sudo mv mkcert-v1.4.3-linux-amd64 mkcert && \
sudo chmod +x mkcert && \
sudo cp mkcert /usr/local/bin/
```

Now that the mkcert utility is installed, run the command below to generate and install your local CA:

```shell
mkcert -install
```

### 2. Create ssl certificate for this project

Run:

```shell
cd sources/tcom/realtime-app/certs
mkcert realtime-app.local
```

### 3. Run to setup: 

Move back to the original installation directory.

```shell
cd ../../../
```

And run the following command:

```shell
docker-compose up -d
docker-compose run server composer install
docker-compose run server npm install
docker-compose run server cp .env.example .env
docker-compose run server php artisan key:generate
```

### 4. Modify **.env** on laravel source

Change database configuration to use or using default values:

```php
DB_DATABASE=realtime-app
DB_USERNAME=root
DB_PASSWORD=root
```

## Check the network ID and connect Database

### 1. Check CONTAINER ID
- Run `docker ps` to check the Container ID of **APP_NAME-db**
- Run the command `docker inspect -f '{{range.NetworkSettings.Networks}}{{.IPAddress}}{{end}}' <container ID>`

```shell
docker inspect -f '{{range.NetworkSettings.Networks}}{{.IPAddress}}{{end}}
```

![image](https://imgur.com/eXqHQVb.png)

### 2. Update DB_HOST on .env file
Please enter the container ID you just got in step 1 and replace the **DB_HOST** variable in the .env file

Example:
```shell
DB_CONNECTION=mysql
DB_HOST=172.21.0.3
DB_PORT=3306
DB_DATABASE=realtime-app
DB_USERNAME=root
DB_PASSWORD=root
```

### 3. Update REDIS_HOST on .env file
Please enter the container ID same step 1 and replace the **REDIS_HOST** variable in the .env file

- Run `docker ps` to check the Container ID of **redis_APP_NAME**
- Run the command `docker inspect -f '{{range.NetworkSettings.Networks}}{{.IPAddress}}{{end}}' <redis container ID>`
- Update the REDIS_HOST variable in the .env file

Example:
```shell
REDIS_HOST=
REDIS_PORT=6379
```

## Launch project
Now, Launch your system...

Run: 

```bash
cd sources/tcom/realtime-app
npm run dev
```

Also create a new terminal tab and run:

```bash
cd sources/tcom/realtime-app
node server.js
```
