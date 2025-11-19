#!/bin/bash

echo "🔥 FORCE REGENERATING ALL STATIC CONTENT 🔥"
echo "This will completely rebuild everything..."

# Remove ALL static content and generated files
echo "🧹 Removing all static content..."
rm -rf magento/pub/static/*
rm -rf magento/var/view_preprocessed/*
rm -rf magento/generated/code/*
rm -rf magento/var/cache/*
rm -rf magento/var/page_cache/*

# Recompile everything
echo "🔧 Recompiling dependency injection..."
./magento-command.sh setup:di:compile

# Deploy static content
echo "📦 Deploying static content..."
./magento-command.sh setup:static-content:deploy -f

# Manually copy theme images (ensure they exist)
echo "🖼️ Manually copying theme images..."
THEME_IMAGES_SRC="magento/app/design/frontend/Pameloski/theme101/Magento_Theme/web/images"
THEME_IMAGES_DEST="magento/pub/static/frontend/Pameloski/theme101/en_US/Magento_Theme/images"

# Create destination directory
mkdir -p "$THEME_IMAGES_DEST"

# Copy all images from source if they exist
if [ -d "$THEME_IMAGES_SRC" ]; then
    cp "$THEME_IMAGES_SRC"/* "$THEME_IMAGES_DEST"/ 2>/dev/null || echo "No images found to copy"
    echo "✅ Theme images copied"
else
    echo "⚠️ Source images directory not found"
fi

# Flush all caches
echo "💨 Flushing caches..."
./magento-command.sh cache:flush

echo "✨ COMPLETE REGENERATION FINISHED! ✨"
echo "Your site should now reflect all changes."