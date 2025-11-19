#!/bin/bash
set -x


mutagen sync terminate --label-selector=magento-docker
mutagen sync terminate --label-selector=magento-docker-vendor
docker compose down 