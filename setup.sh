#!/bin/bash
set -e

OS_INFORMATION="$(uname -s)"
case "${OS_INFORMATION}" in
    Linux*)     OS_NAME=linux;;
    Darwin*)    OS_NAME=mac;;
    CYGWIN*)    OS_NAME=windows;;
    MINGW*)     OS_NAME=windows;;
    *)          OS_NAME="UNKNOWN:${OS_INFORMATION}"
esac

if [ $OS_NAME == 'linux' ]; then
    sudo setfacl -dR -m u:$(whoami):rwX -m u:1000:rwX ./
    sudo setfacl -R -m u:$(whoami):rwX -m u:1000:rwX ./
elif [ $OS_NAME == 'mac' ]; then
    sudo dseditgroup -o edit -a $(id -un) -t user $(id -gn 1000)
fi

docker-compose build
docker-compose up -d