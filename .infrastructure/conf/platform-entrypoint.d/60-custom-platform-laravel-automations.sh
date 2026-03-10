#!/bin/sh

if [ -f "$APP_BASE_DIR/artisan" ]; then
  echo "Executing Laravel automations..."
    echo "🚀 Generating sitemap..."
    php "$APP_BASE_DIR/artisan" sitemap:generate
fi
