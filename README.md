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

# Edit project name in base config files.
code .lando.yml     # ->  name: myproject
code .env.example   # ->  DRUSH_OPTIONS_URI=https://myproject.lndo.site

# Start the project
lando start 

# Download dependencies
lando composer install -o

# Install Drupal
lando drush si --existing-config -y
```

Start to build things! 

PS: Don't forget to enjoy life.
