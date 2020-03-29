#!C:/Program\ Files/Git/usr/bin/sh.exe
# Check if we actually have commits to push
commits=`git log @{u}..`
if [ -z "$commits" ]; then
    echo 'Nothing to push'
    exit 0
fi

echo
echo 'Running PHP Linter...'

./vendor/bin/phpcs
RESULT=$?
if [ $RESULT -ne 0 ]; then
    echo 'Failed phpcs'
    exit 1
fi
echo 'Passed!'