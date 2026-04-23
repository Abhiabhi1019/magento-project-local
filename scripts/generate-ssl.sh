#!/bin/bash
set -e

CERT_DIR="docker/nginx/certs"
mkdir -p "$CERT_DIR"

if [ ! -f "$CERT_DIR/magento.crt" ]; then
    echo "Generating self-signed SSL certificate..."
    openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
        -keyout "$CERT_DIR/magento.key" \
        -out "$CERT_DIR/magento.crt" \
        -subj "/C=US/ST=State/L=City/O=Organization/OU=Unit/CN=localhost"
    echo "Certificate generated in $CERT_DIR"
else
    echo "Certificate already exists."
fi
