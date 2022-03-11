# Drupal project template

Requirements:

- [VSCode](https://code.visualstudio.com/)
- [Lando](https://docs.lando.dev/drupal/)

Installation:

```bash
git clone <repo> myniceproject
cd myniceproject
lando start 
lando composer install -o
# Edit your project's name.
# Ex: "name: myniceproject"
code .lando.yml
# Edit DRUSH_OPTIONS_URI to match the custom project's name set above.
# Ex: "DRUSH_OPTIONS_URI=https://myniceproject.lndo.site"
code .env
# Install Drupal with minimal configuration
lando drush site-install --existing-config -y
```

Helpful commands:

```bash
# Get local environment info (e.g. your site's URL)
lando info

# Enter the app container to run commands.
lando ssh
|__ www-data@5520c27c4bb0:/app$ ./vendor/bin/drush cache-rebuild
|__ www-data@5520c27c4bb0:/app$ exit # or CTRL+D

# Run Drush commands.
lando drush php
lando drush cache-rebuild
lando drush core-status
lando drush config-export
lando drush config-import
lando drush en devel stage_file_proxy -y
```
