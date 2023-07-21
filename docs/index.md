# Drupal project template

Requirements:

- [Lando](https://docs.lando.dev/drupal/)


Recommandations:

- [VSCode](https://code.visualstudio.com/)

Installation:

```bash
git clone https://github.com/MatthieuScarset/drupal-template.git myproject

cd myproject

# Delete git references.
rm -rf .git/

# Replace the project name.
code .lando.yml      # ->  name: myproject
code .env.example    # ->  DRUSH_OPTIONS_URI=https://myproject.lndo.site

# Create your env file now
cp .env.example .env

# Commit your changes
git init && git add . && git commit -m "Init project"

# Start the project
lando start

# Download dependencies
lando composer install -o

# Install Drupal
lando drush site:install --existing-config -y
lando drush user:password admin admin
lando drush user:login # -> Ctrl+Click the URL to open your site :)
```

Helpful commands:

```bash
# Get local environment info (e.g. your site's URL)
lando info

# Enter the app container to run commands.
lando ssh
|__ www-data@xxx:/app$ ./vendor/bin/drush cache-rebuild
|__ www-data@xxx:/app$ exit # or CTRL+D

# Common Drush commands
lando drush core-status # check current installation
lando drush cache-rebuild # clear caches
lando drush config-export # export config changes to codebase
lando drush config-import # import config changes to database
lando drush en mymodule # enable module(s)
lando drush php # interactive PHP CLI 
```
