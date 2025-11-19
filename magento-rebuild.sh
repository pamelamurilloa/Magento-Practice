#!/bin/bash

# Magento Complete Rebuild Script
# This script runs a complete Magento rebuild process including cache management,
# dependency injection compilation, upgrades, and static content deployment

echo "Starting Magento complete rebuild process..."
echo "============================================"

echo "Step 1/5: Cleaning cache..."
./magento-command.sh cache:clean

echo "Step 2/5: Compiling dependency injection..."
./magento-command.sh setup:di:compile

echo "Step 3/5: Running setup upgrade..."
./magento-command.sh setup:upgrade

echo "Step 4/5: Deploying static content (forced)..."
./magento-command.sh setup:static-content:deploy -f

echo "Step 5/5: Flushing cache..."
./magento-command.sh cache:flush

echo "============================================"
echo "Magento rebuild process completed successfully!"