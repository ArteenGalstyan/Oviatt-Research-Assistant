#!/bin/bash
OA_BRANCH=$1
if [[ $OA_BRANCH = "develop" ]]; then
    CD_LOCATION="/home/dev/oa"
elif [[ $OA_BRANCH = "master" ]]; then
    CD_LOCATION="/var/www/oa"
else
    echo "ERROR: Invalid branch specified"
    exit
fi

cd $CD_LOCATION
git reset --hard && git clean -fd && git checkout $OA_BRANCH && git pull
