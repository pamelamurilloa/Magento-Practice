#!/bin/bash
set -e
set -x


docker compose run -it --rm cli composer install

MAGENTOCOMMAND="docker compose run -it --rm cli -f bin/magento"

$MAGENTOCOMMAND setup:install \
      --db-host=db \
      --db-name=magento2 \
      --db-user=magento2 \
      --db-password=magento2 \
      --admin-firstname="admin" \
      --admin-lastname="example" \
      --admin-user="admin" \
      --admin-password="admin123q." \
      --admin-email="admin@example.com" \
      --use-rewrites=1 \
      --base-url="http://127.0.0.1" \
      --backend-frontname="admin" \
      --db-prefix="mage_" \
      --search-engine=opensearch \
      --opensearch-host=http://opensearch \
      --opensearch-port=9200 \
      --opensearch-index-prefix=magento2 \
      --opensearch-timeout=15 \
      --session-save=redis \
      --session-save-redis-host=redis \
      --session-save-redis-port=6379 \
      --session-save-redis-db=0 \
      --session-save-redis-max-concurrency=20 \
      --cache-backend=redis \
      --cache-backend-redis-server=redis \
      --cache-backend-redis-db=1 \
      --cache-backend-redis-port=6379 \
      --http-cache-hosts varnish \
      --use-rewrites 1 \
      --amqp-host rabbitmq \
      --amqp-port 5672 \
      --amqp-user guest \
      --amqp-password guest \
      --amqp-virtualhost / \
  && $MAGENTOCOMMAND config:set system/full_page_cache/caching_application 2 --lock-env \
  && $MAGENTOCOMMAND config:set web/secure/use_in_frontend 0 \
  && $MAGENTOCOMMAND config:set  web/secure/use_in_adminhtml 0 \
  && $MAGENTOCOMMAND  index:set-mode realtime customer_grid \
  && $MAGENTOCOMMAND deploy:mode:set developer \
  && $MAGENTOCOMMAND setup:upgrade \
  && $MAGENTOCOMMAND c:f \
  && $MAGENTOCOMMAND c:c


#   && $MAGENTOCOMMAND module:disable Magento_TwoFactorAuth Magento_AdminAdobeImsTwoFactorAuth \