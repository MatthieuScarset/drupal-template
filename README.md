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

# Edit project name in Lando file, example: "name: myniceproject"
code .lando.yml

# Start the project
lando start 

# Download dependencies
lando composer install -o

# Edit .env file to match the new name set above, example: 
# DRUSH_OPTIONS_URI=https://myniceproject.lndo.site
code .env

# Install Drupal
lando drush si --existing-config -y
```

Start to build things! 

PS: Don't forget to enjoy life.
