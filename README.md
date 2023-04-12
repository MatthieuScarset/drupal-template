# Drupal project template

Get a working Drupal website locally in minutes with this fine-tuned template.

Based on the great [Drupal Composer project](https://github.com/drupal-composer/drupal-project).

## Requirement

Install [Lando](https://docs.lando.dev/drupal/) on your machine.

## Usage

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

Let's take over the world now!
