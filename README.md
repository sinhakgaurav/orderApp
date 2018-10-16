orderApp API Application
Featuring Docker, PHP Laravel, MySQL, & NGINX
About
Docker as the container service to isolate the environment.
PHP Laravel used as to develop backend API's.Laravel API structure is used for api configuration
MySQL as the database layer to store executions.
NGINX as a proxy / content-caching layer
PHPUnit is used for unit testing
How to Install & Run
Clone the repo
Set Google Distance API key in config/constants.php file
Run ./start.sh to download Docker CE and Docker Compose.
After starting container , testcases will run automatically
Manually Starting the docker and test Cases
You can run docker-compose up from terminal
Server is accessible at http://localhost:8080
Run manual testcase suite by npm test app/test
How to Run Tests (Explicity from cli)
Use following command to run PHPUnit test cases:
.\vendor\bin\phpunit tests\Feature\OrderControllerTest.php

App Structure
/tests

this folder contains test case run using PHPUnit
/app

Contains Api Controller and Models files also has configuration settings for registering different middleware class
/config

config contains various configurations, also contains the constants file to set Google API Key.
/routes

contains the api routing file.
