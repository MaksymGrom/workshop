#!/bin/bash

cd dev/tests/integration
if [[ $1 ]]; then
  ../../../vendor/bin/phpunit --testsuite "Project"  ../../../$1
else
  ../../../vendor/bin/phpunit --testsuite "Project"
fi
