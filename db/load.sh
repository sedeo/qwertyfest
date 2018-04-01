#!/bin/sh

BASE_DIR=$(dirname $(readlink -f "$0"))
if [ "$1" != "test" ]
then
    psql -h localhost -U quertyfest -d quertyfest < $BASE_DIR/quertyfest.sql
fi
psql -h localhost -U quertyfest -d quertyfest_test < $BASE_DIR/quertyfest.sql
