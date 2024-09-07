# StartItUp - Take home assignment

---

## Introduction

This is a take home assignment for the [StartItUp](https://startitup.sk/).

## Assignment / Task overview

#### Implemented

- [X] Fork the REMP-Crm_skeleton repo 
- [X] Add a new Benefits module
- [X] Add a new Admin navbar item
- [X] Add a way to add and manipulate benefits
- [X] Make benefits obey time limit rules
- [X] Create a new Frontend item for logged in users
- [X] Make users able to choose their benefit
- [X] Show the chosen benefit code to the user
- [X] Add a widget to user-detail showing the chosen benefit

#### What I didn't manage to do

- [ ] Translate templates - I don't think this is yet possible in the skeleton
- [ ] Make it possible to have the benefit limit dynamically set by the admins 
- [ ] Add a way to translate benefit content
- [ ] Custom styling for templates relating to this module - I kinda suck at Bootstrap and didn't get to wrtie custom CSS
- [ ] Write tests
- [ ] Handle secure file uploads
- [ ] Implement API and User Data Provider
- [ ] Add a way to see deleted benefits
- [ ] Add a way to keep history of benefit - user relations without blocking user from choosing a new one

---

## Limitations

- Currently, no translations are implemented for the templates
- Photos are not local (Did not implement file upload functionality)
- Not tested
- Functionality to add translations to the Benefit content is missing

---

## How to get it running 

1. Clone this repo

```bash
git clone https://github.com/Dalovec/startitup-task.git /path/to/your/project
```

2. Cd into the project directory

```bash
cd /path/to/your/project
```

3. Prepare the enviroment and config files

```bash
cp .env.example .env
cp app/config/config.local.example.neon app/config/config.local.neon
cp docker compose.override.example.yml docker compose.override.yml
```

4. Default host is `http://crm.press`, but if it doesn't work add a pointer in yourt `/etc/hosts` file

```bash
127.0.0.1       crm.press
```

5. Run docker compose - Make sure you have port 80 open

```bash
docker compose up
```

6. Enter the application

```bash
docker compose exec crm /bin/bash
```

7. Run all of these commands
```bash
chmod -R a+rw temp log content
composer install
php bin/command.php phinx:migrate
php bin/command.php application:generate_key
php bin/command.php user:generate_access
php bin/command.php api:generate_access
php bin/command.php application:seed
php bin/command.php application:install_assets
```

8. Open the application in your browser

> The credentials stay the same:

URL: `http://crm.press`

- Users:
  - Admin
    - Username: `admin@crm.press`
    - Password: `password`
  - User
    - Username: `user@crm.press`
    - Password: `password`
  
---

Made by [Dávid Kolembus](https://github.com/Dalovec) 2024