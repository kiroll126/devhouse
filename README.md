# Test for dev.house
OpenMage (Magento LTS) with [AdminExtendUser](https://github.com/kiroll126/devhouse/tree/master/magento/app/code/local/Kiroll/AdminUserExtend) module

## How it run?
1. Run ```composer install``` in ```magento``` directory
2. Run ```docker compose -p=devhouse --env-file=env/.env.wsl2 up``` in ```docker``` directory
3. Go to ```127.0.0.1:8080``` in browser 

## What is this module for?

1. Add new fields to edit admin user form  
![edit from](https://github.com/kiroll126/devhouse/blob/master/screenshots/screen1?raw=true)
2. Show user profile photo in the right top corner  
![edit from](https://github.com/kiroll126/devhouse/blob/master/screenshots/screen2?raw=true)
