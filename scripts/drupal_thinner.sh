# ######################################################################
# Save the planet, delete your test files!
#
# This script is meant to delete unnecessary files and directories, 
# usually Tests and informational content not used on production env.
#
# "Why should I do this? ¯\_(ツ)_/¯" you may ask...
# To reduce your digital footprint by not deploying non-required things
# to the world wide web.
#
# A standard Drupal project uses +/-230Mb of disk.
# Remove tests directories and README* files... 
# The project uses ~30% less space (+/- 160Mb):leaves:!
# Morality: Save the planet, no more test files on prod! 
# ######################################################################
#
# Delete Drupal test directories.
# https://unix.stackexchange.com/a/89937
find . -type d -name tests -exec rm -rf {} +
# Delete README files.
find . -type f -name 'README*' -delete
find . -type f -name 'CHANGELOG*' -delete
# Delete patch records.
find . -type f -name 'PATCHES.txt' -delete
# Delete markdown files except licenses.
find web -type f -name "*.md" -not -name "LICENSE*" -delete
# Delete txt files except humans and licenses.
find web -type f -name "*.txt" -not -name "salt*" -not -name "humans*" -not -name "LICENSE*" -not -name "COPYRIGHT*" -delete
# Delete testing and demo profiles.
find web/core/profiles -type d -name 'testing*' -exec rm -rf {} +
find web/core/profiles -type d -name 'nightwatch_testing' -exec rm -rf {} +
find web/core/profiles -type d -name 'demo_umami' -exec rm -rf {} +
