#!/bin/sh

if [ "$1" = "travis" ]
then
    psql -U postgres -c "CREATE DATABASE quertyfest_test;"
    psql -U postgres -c "CREATE USER quertyfest PASSWORD 'quertyfest' SUPERUSER;"
else
    [ "$1" != "test" ] && sudo -u postgres dropdb --if-exists quertyfest
    [ "$1" != "test" ] && sudo -u postgres dropdb --if-exists quertyfest_test
    [ "$1" != "test" ] && sudo -u postgres dropuser --if-exists quertyfest
    sudo -u postgres psql -c "CREATE USER quertyfest PASSWORD 'quertyfest' SUPERUSER;"
    [ "$1" != "test" ] && sudo -u postgres createdb -O quertyfest quertyfest
    sudo -u postgres createdb -O quertyfest quertyfest_test
    LINE="localhost:5432:*:quertyfest:quertyfest"
    FILE=~/.pgpass
    if [ ! -f $FILE ]
    then
        touch $FILE
        chmod 600 $FILE
    fi
    if ! grep -qsF "$LINE" $FILE
    then
        echo "$LINE" >> $FILE
    fi
fi
