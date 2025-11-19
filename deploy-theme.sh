#!/bin/bash

# Pameloski Theme Deployment Script
# This script ensures all theme assets are properly deployed

echo "🎨 Deploying Pameloski Theme..."

# Navigate to Magento root
cd /app

# Clear existing static content
echo "🧹 Cleaning static content..."
rm -rf pub/static/frontend/Kalicr/test/
rm -rf pub/static/frontend/Kalicr/production/


# Deploy static content for the theme
echo "📦 Deploying static content..."
bin/magento setup:static-content:deploy -f --theme Kalicr/test
bin/magento setup:static-content:deploy -f --theme Kalicr/production

# Ensure custom images are deployed
echo "🖼️ Copying custom theme images..."
THEME_IMAGES_SRC_TEST="app/design/frontend/Kalicr/test//web/images"
THEME_IMAGES_DEST_TEST="pub/static/frontend/Kalicr/test/en_US/images"

THEME_IMAGES_SRC_PRODUCTION="app/design/frontend/Kalicr/production//web/images"
THEME_IMAGES_DEST_PRODUCTION="pub/static/frontend/Kalicr/production/en_US/images"

# Create destination directory if it doesn't exist
mkdir -p "$THEME_IMAGES_DEST_TEST"
mkdir -p "$THEME_IMAGES_DEST_PRODUCTION"

# Copy all custom images
if [ -d "$THEME_IMAGES_SRC_TEST" ]; then
    cp -r "$THEME_IMAGES_SRC_TEST"/* "$THEME_IMAGES_DEST_TEST"/
    echo "✅ Custom images copied successfully"
else
    echo "⚠️ Source images directory not found: $THEME_IMAGES_SRC_TEST"
fi

if [ -d "$THEME_IMAGES_SRC_PRODUCTION" ]; then
    cp -r "$THEME_IMAGES_SRC_PRODUCTION"/* "$THEME_IMAGES_DEST_PRODUCTION"/
    echo "✅ Custom images copied successfully"
else
    echo "⚠️ Source images directory not found: $THEME_IMAGES_SRC_PRODUCTION"
fi

# Clear cache
echo "🗑️ Clearing cache..."
bin/magento cache:clean
bin/magento cache:flush

echo "✨ Theme deployment completed!"