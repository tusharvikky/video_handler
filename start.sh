#!/usr/bin/env bash

echo "########################## Copying .env.example to .env ########################## "
cp .env.example .env

echo "########################## Triggering docker up -d ########################## "
./vessel start

echo "########################## Triggering composer install ########################## "
./vessel composer install

echo "########################## Triggering artisan migrate ########################## "
./vessel artisan migrate

echo "########################## Triggering db:seed ########################## "
./vessel artisan db:seed