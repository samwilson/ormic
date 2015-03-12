#!/bin/bash

./vendor/bin/phpcs --report=full --extensions=php --ignore=vendor,*.blade.php --standard=PSR2 .
