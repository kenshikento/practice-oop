#!/bin/bash
echo
echo 'Running PHP Linter...'
echo "Hello, World!"

./vendor/bin/phpcs
RESULT=$?
if [ $RESULT -ne 0 ]; then
    echo 'Failed phpcs'
    exit 1
fi
echo 'Passed!'