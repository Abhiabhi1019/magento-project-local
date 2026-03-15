#!/bin/bash

echo "Pulling latest code..."
git pull origin main

echo "Installing dependencies..."
composer install

echo "Running Magento upgrade..."
php bin/magento setup:upgrade

echo "Compiling Magento..."
php bin/magento setup:di:compile

echo "Deploying static content..."
php bin/magento setup:static-content:deploy -f

echo "Flushing cache..."
php bin/magento cache:flush

echo "Deployment completed successfully!"
