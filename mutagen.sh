#!/bin/bash
mutagen sync terminate --label-selector=magento-docker
mutagen sync terminate --label-selector=magento-docker-vendor

mutagen sync create \
       --label=magento-docker \
       --sync-mode=two-way-resolved \
       --default-file-mode=0644 \
       --default-directory-mode=0755 \
       --ignore=/.idea \
       --ignore=/.magento \
       --ignore=/.docker \
       --ignore=/.github \
       --ignore=/vendor \
       --ignore=/.env \
       --ignore=/.gitignore \
       --ignore=/docker-compose.yml \
       --ignore=/mutagen.sh \
       --ignore=*.sql \
       --ignore=*.gz \
       --ignore=*.zip \
       --ignore=*.bz2 \
       --ignore-vcs \
       --ignore=.build \
       --symlink-mode=posix-raw \
       ./magento docker://$(docker compose ps -q php-fpm|awk '{print $1}')/app

mutagen sync create \
       --label=magento-docker-vendor \
       --sync-mode=two-way-resolved \
       --default-file-mode=0644 \
       --default-directory-mode=0755 \
       --symlink-mode=posix-raw \
       ./magento/vendor docker://$(docker compose ps -q php-fpm|awk '{print $1}')/app/vendor
