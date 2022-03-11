# Drupal project template

Based on the great [Drupal Composer project](https://github.com/drupal-composer/drupal-project).

This is my fine-tuned template to quickly spin up a new Drupal project.

Requirements:
- [VSCode](https://code.visualstudio.com/)
- [Lando](https://docs.lando.dev/drupal/)

Getting started:

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
# Install Drupal with minimal configuration.
lando drush si --existing-config -y
```

Start to build things! 

PS: Don't forget to enjoy life.
