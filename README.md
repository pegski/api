## Pegski

Aka the PEG Project, in which we will try to maximise the value of the PSA.

## Pegski

This project started at WeCamp2016 as the project of "team attachable". We had so much fun with this project that we decided to continue development and moved it to a new github organisation.

## Requirements

* Docker
* Docker Compose

For being able to deploy you'll need Ansible as well.

## Install and run locally

1. Clone this repository on your machine
2. Build the docker containers and run the initial setup: `make setup`
3. Start the docker containers: `make run`
4. Add the `app.dev` hostname to your `/etc/hosts` file
5. Enjoy: http://app.dev:8080/app_dev.php
6. Stop the docker containers: `make stop`
7. Maybe clean everything up: `make clean`
