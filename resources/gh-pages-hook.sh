#!/usr/bin/env bash

SCRIPT_DIR=$( cd -- "$( dirname -- "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )

ASSETS_IMAGE_DIR="docs/assets/images"

php $SCRIPT_DIR/graph-uml/build.php application $ASSETS_IMAGE_DIR
php $SCRIPT_DIR/graph-uml/build.php php_extensions $ASSETS_IMAGE_DIR
php $SCRIPT_DIR/graph-uml/build.php without_elements $ASSETS_IMAGE_DIR
