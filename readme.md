# CMS MVC
Basic CMS with PHP and MVC.

## Requirements:
+ Docker

## Development:
+ Clone the repository.
+ Rename .env.docker.example to .env , set values to DB_USER, DB_PASSWORD, DB_NAME variables.
+ Up container from root directory of project with the command: `docker-compose up`.
+ Rename .env.example to .env inside src directory. Set values to all variables. DB_USER, DB_PASSWORD, DB_NAME values must be equals to values in .env file in root directory of project. The variable DB_HOSTNAME must be the IP address of db container.  

  ### __Installing PHP and Node package:__  
  + Inside app container run the commands: `composer install` and `npm install`.
  + If you watch all changes in JS files execute the command: `npm run dev` inside app container.

## Production:



## Technologies
PHP, TAILWIND CSS, WEBPACK, DOCKER, AWS. 