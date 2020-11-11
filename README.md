# Docker PHP + React Devine

Docker image with php, composer and yarn build scripts for a React frontend. Supports deployment on heroku or classic hosting.

## Get started

1. Initialize the project as a git project.

```
$ git init .
```

2. Copy your package.json, public folder and src folder into the www directory
3. Create an .env file in the www directory. You can rename the .env.example file to get started. The reason for the .env file to sit here is to make it compatible with old-school upload to ftp. <br />.env sits in gitignore and dockerignore - so when pushing it to docker hosting,
such as heroku, you're able to set these variables through your application settings
4. Make sure to add a "postbuild" script to your package.json, to move the build directory to the www/html directory"

```
"postbuild": "rm -rf ./html/build || true && mv ./build ./html/build"
```

5. Open a terminal in this directory and run the build command the first time - **make sure to have a .env file sitting in the www directory**

```
$ docker-compose up --build
```

You can omit the --build flag on concurrent runs.

When working locally, you'll need to install the composer.json dependencies. With the docker container running in one terminal, open another one and execute:

```
$ docker-compose exec web composer install
```

Same principle for the nodejs dependencies, run yarn to install those, in that second terminal:

```
$ docker-compose exec web yarn
```

After that, run `docker-compose exec web yarn start` for dev mode or `docker-compose exec web yarn build` for production mode. If you have a local yarn installation, you can run the `yarn` commands inside the web/www directory instead of running them through docker.

## Heroku deployment

Setup:

Make sure this folder is a git repo on it's own.

```
$ git init .
```

After initializing it as a git repo, create a heroku project for this docker container:

```
$ heroku create --region eu
$ heroku stack:set container
$ heroku labs:enable --app=YOUR_(GENERATED)_APP_NAME runtime-new-layer-extract
```

Push an update:

```
$ git push heroku  master
```

### MySQL database

Setup a mysql database on a server (such as combell). In heroku, you'll need to set some ENV variables for the database connection:

DB_HOST, DB_DATABASE, DB_USERNAME and DB_PASSWORD