#!/bin/sh

PROJECT=${PWD}
STAGED_FILES_CMD=`git diff --cached --name-only --diff-filter=ACMR HEAD | grep \\\\.php | grep -v \\\\.blade.php`

# Determine if a file list is passed
if [ "$#" -eq 1 ]
then
  oIFS=$IFS
  IFS='
  '
  SFILES="$1"
  IFS=$oIFS
fi
SFILES=${SFILES:-$STAGED_FILES_CMD}

echo "Checking PHP Lint..."
for FILE in $SFILES
do
    PATHINDOCKER=$(echo $FILE | sed "s:src:app:g")
  docker run -t --rm -v ${PROJECT}/src:/app webdevops/php-nginx:8.1-alpine sh -c  "php -l -d display_errors=0 /$PATHINDOCKER"
  if [ $? != 0 ]
  then
    echo "Fix the error before commit."
    exit 1
  fi
  FILES="$FILES $PROJECT/$FILE"
done

if [ "$FILES" != "" ]
then
  echo "Running Code Sniffer..."
    FILES=$(echo $FILES | sed "s:$PWD/src:/app:g")
  docker run -t --rm -v ${PROJECT}/src:/app webdevops/php-nginx:8.1-alpine sh -c "php -d memory_limit=1G vendor/bin/phpcs --standard=phpcs-laravel  --ignore='vendor,phpstan_tmp,resources,storage,tests' --extensions=php --ignore-annotations  --encoding=utf-8 -n -p $FILES"

  if [ $? != 0 ]
  then
    echo "Fix the error before commit."
    exit 1
  fi
fi

exit $?
