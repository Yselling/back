
# Yselling ⚡

An app to manage backlinks, check indexaction, etc

## Environment Variables

To run this project, you will need to add the following environment variables to your .env file

`STRIPE_PK`

`STRIPE_SK`

`STRIPE_WEBHOOK`


## Run Locally

To run the project locally, you will need docker installed and running on your PC. Then you can : 

Clone the project

```bash
  git clone git@github.com:Yselling/back.git
```

Go to the project directory

```bash
  cd back
```

Install composer dependencies

```bash
  docker run --rm --interactive --tty \
  --volume $PWD:/app \
  composer install --ignore-platform-req
```

Start Sail

```bash
  ./vendor/bin/sail up  
```

Install npm dependencies

```bash
  sail npm i
```

Run npm

```bash
  sail npm run dev
```

Run the stripe webhook

```bash
  stripe listen --forward-to http://localhost/stripe/webhook
```

Seed the database

```bash
  sail artisan migrate:fresh --seed
```

## Deployment

To deploy this project, you will need a debian server. 

First of all, install all the needed packages (nginx, php, composer, npm, etc)

```bash
  sudo apt-get update && sudo apt-get upgrade
  sudo apt install lsb-release apt-transport-https ca-certificates software-properties-common -y
  wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
  sh -c 'echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list'
  sudo apt update
  sudo apt install php8.2 php8.2-{cli,zip,mysql,bz2,curl,mbstring,intl,common,xml} php8.2-fpm nginx composer mariadb-server curl -y
  curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.38.0/install.sh | bash
  source ~/.bashrc
  nvm install node
```

Then you can finish the setup of mysql with 

```bash
  sudo mysql_secure_installation
```

You can now enter mysql to finish the setup

```bash
  mysql
```

```sql
  CREATE DATABASE yselling;
  CREATE USER 'laravel'@'%' IDENTIFIED BY 'password';
  GRANT ALL ON yselling.* TO 'laravel'@'%';
  quit
```

Check if you can access mysql with the created user 

```bash
  mysql -u laravel -p
```

Now, stop apache2 if it is running and present on the server 

```bash
  systemctl stop apache2
```

Create a ssh key for the server and retrieve it

```bash
  ssh-keygen
  cat ~/.ssh/id_rsa.pub
```

Copy the ssh key and add it as a deploy key in your github project settings

Clone the project

```bash
  git clone git@github.com:Yselling/back.git /var/www/yselling.fr
```

Transfer the ownership of the folder 

```bash
  sudo chown $USER:$USER /var/www/yselling.fr/
```

Add a config file `/etc/nginx/sites-available/yselling.fr` for the nginix server 

```bash
server {
    server_name app.backlink-shield.com;
    root /var/www/yselling.fr/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

Create a link between your config file and the nginx sites

```bash
  sudo ln -s /etc/nginx/sites-available/yselling.fr /etc/nginx/sites-enabled/
```

Restart nginx 

```bash
  sudo systemctl reload nginx
```

Go to the project folder and install the dependencies 

```bash
  cd /var/www/yselling.fr
  composer install
  npm install
```

Build the assets

```bash 
  npm run build
```

Migrate the database 

```bash 
  php artisan migrate:fresh
```

Seed the database

```bash 
  php artisan db:seed --class=GenderSeeder
  php artisan db:seed --class=RoleSeeder
  php artisan db:seed --class=CategorySeeder
  php artisan db:seed --class=OrderStatesSeeder

```

Cache the config, the route, and the view for better performances

```bash
  php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan optimize
```

# Api Documention

Go on http://localhost/docs/api

## Tech Stack

**Server:** Laravel


## Authors

- [@romainsilvy](https://www.github.com/romainsilvy) - [@Ayatooo](https://github.com/Ayatooo)

