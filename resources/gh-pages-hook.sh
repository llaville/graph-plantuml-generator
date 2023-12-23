#!/usr/bin/env bash

SCRIPT_DIR=$( cd -- "$( dirname -- "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )

ASSETS_IMAGE_DIR="docs/assets/images"

php $SCRIPT_DIR/../examples/plantuml.php application $ASSETS_IMAGE_DIR svg 1
php $SCRIPT_DIR/../examples/php-extensions/plantuml.php php-extensions $ASSETS_IMAGE_DIR svg 1
php $SCRIPT_DIR/../examples/plantuml.php without-elements $ASSETS_IMAGE_DIR svg 1
