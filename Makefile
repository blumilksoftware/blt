export COMPOSE_DOCKER_CLI_BUILD = 1
export DOCKER_BUILDKIT = 1

SHELL := /bin/bash

DOCKER_COMPOSE_FILE = docker-compose.yml
DOCKER_COMPOSE_APP_CONTAINER = php

CURRENT_USER_ID = $(shell id -u)
CURRENT_USER_GROUP_ID = $(shell id -g)
CURRENT_DIR = $(shell pwd)

init:
	@make build \
    && make run

build:
	@docker compose --file ${DOCKER_COMPOSE_FILE} build --pull

run:
	@docker compose --file ${DOCKER_COMPOSE_FILE} up --detach

stop:
	@docker compose --file ${DOCKER_COMPOSE_FILE} stop

restart: stop run
rebuild: stop build run

shell:
	@docker compose --file ${DOCKER_COMPOSE_FILE} exec --user "${CURRENT_USER_ID}:${CURRENT_USER_GROUP_ID}" ${DOCKER_COMPOSE_APP_CONTAINER} sh

shell-root:
	@docker compose --file ${DOCKER_COMPOSE_FILE} exec ${DOCKER_COMPOSE_APP_CONTAINER} sh

test:
	@docker compose --file ${DOCKER_COMPOSE_FILE} exec --user "${CURRENT_USER_ID}:${CURRENT_USER_GROUP_ID}" ${DOCKER_COMPOSE_APP_CONTAINER} composer test

fix:
	@docker compose --file ${DOCKER_COMPOSE_FILE} exec --user "${CURRENT_USER_ID}:${CURRENT_USER_GROUP_ID}" ${DOCKER_COMPOSE_APP_CONTAINER} sh -c 'composer csf'

.PHONY: init build run stop restart shell shell-root test fix
