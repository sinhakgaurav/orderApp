# RESTful API Application
## Featuring Docker, PHP Laravel, MySQL, & NGINX

## About
- [Docker](https://www.docker.com/) as the container service to isolate the environment.
- [PHP](https://php.net) [Laravel](https://laravel.com) used as to develop backend API's. Laravel API structure is used for api configuration
- [MySQL] (https://www.mysql.com/) as the database layer to store executions.
- [NGINX](https://docs.nginx.com/nginx/admin-guide/content-cache/content-caching/) as a proxy / content-caching layer
- [PHPUnit](https://phpunit.de/) is used for unit testing

## How to Install & Run

1.  Clone the repo
2.  Set Google Distance API key in config/constants.php file
3.  Run ./start.sh to download Docker CE and Docker Compose.
4.  After starting container , testcases will run automatically

## Manually Starting the docker and test Cases

1. You can run `docker-compose up` from terminal
2. Server is accessible at `http://localhost:8080`
3. Run manual testcase suite by `npm test app/test`

## How to Run Tests (Explicity from cli)
**Use following command to run PHPUnit test cases:**
.\vendor\bin\phpunit tests\Feature\OrderControllerTest.php

## App Structure

**tests**

- this folder contains test case run using PHPUnit

**app**

- Contains Api Controller and Models files also has configuration settings for registering different middleware class

**config**

- config contains various configurations, also contains the constants file to set Google API Key.

**routes**

- contains the api routing file.