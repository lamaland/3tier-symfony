#!/bin/bash

docker run --rm \
    --user $(id -u):$(id -g) \
    --volume $PWD:/app \
    --workdir /app \
    anasdox/phpwebbuilder \
    composer "$@" --prefer-dist --no-interaction --ignore-platform-reqs