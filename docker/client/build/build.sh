#!/bin/bash
if [ -d "/var/www/html/node_modules" ]
 then
    rm -rf node_modules
fi

npm install

npm run serve