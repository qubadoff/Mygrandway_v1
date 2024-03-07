#!/bin/bash

while getopts b:m:p: flag; do
    # shellcheck disable=SC2213
    case "${flag}" in
    b) GITHUB_BRANCH=${OPTARG} ;;
    m) COMMIT_MESSAGE=${OPTARG} ;;
    p) SSH_PASSWORD=${OPTARG} ;;
    esac
done

echo "Branch: $GITHUB_BRANCH"

if ! [ -x "$(command -v ssh)" ]; then
  apt-get update
  apt-get install openssh-client -y
fi

if ! [ -x "$(command -v sshpass)" ]; then
  apt-get install sshpass -y
fi

GIT_PULL="git pull origin $GITHUB_BRANCH"

PROD_BRANCH="master"

BRANCH_PATH="/var/www/mygrandway"

COMMAND_FROM_COMMIT_MESSAGE=$(echo $COMMIT_MESSAGE | grep -oP '(?<=#\[).*(?=\])')

COMMAND="cd $BRANCH_PATH && $GIT_PULL"

if [ ! -z "$COMMAND_FROM_COMMIT_MESSAGE" ]; then
    COMMAND="$COMMAND && $COMMAND_FROM_COMMIT_MESSAGE"
fi

echo "Command: $COMMAND"
if [[ ! $COMMIT_MESSAGE == *"@pass[deploy]"* ]]; then
    echo "Deploying"

    sshpass -p "$SSH_PASSWORD" ssh -o StrictHostKeyChecking=no grandway@164.92.251.2 -p 22 "$COMMAND"

    echo "Deployed"
else
    echo "Passing deploy"
fi
