# Drupal project template

Requirements:

- [Lando](https://docs.lando.dev/drupal/)


Recommandations:

- [VSCode](https://code.visualstudio.com/)

Installation:

```bash
git clone https://github.com/MatthieuScarset/drupal-template.git myproject

cd myproject

# Delete git reference.
rm -rf .git/

# Replace the project name (i.e. 'myproject').
code .env.example    # ->  DRUSH_OPTIONS_URI=https://myproject.lndo.site
code .lando.yml      # ->  name: myproject

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

# Composer commands.
lando composer code-fix # fix/format files with uncommitted changes...
lando composer code-fix -- web/themes/custom/project/ # ...or specify a folder
lando composer code-fix -- web/modules/custom/mymodule/mymodule.module # ...or a file
lando composer code-check # log coding standards issues
lando composer code-check -- themes/custom/mytheme # ...or specify a folder
lando composer code-check -- themes/custom/mytheme/README.md # ...or a file
```

Be eco-friendly, reduce your digital footprint before deployment:

```bash
# Delete unncessary files and test directories.
chmod +x scripts/drupal_thinner.sh
lando composer code-clean
```

Be human and list all the people involved in your project: 

```bash
# Edit `web/humans.txt`.
code humans.txt
```
