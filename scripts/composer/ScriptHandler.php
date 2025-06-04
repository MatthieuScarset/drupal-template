<?php

/**
 * @file
 * Contains \DrupalProject\composer\ScriptHandler.
 */

namespace DrupalProject\composer;

use Composer\Script\Event;
use Composer\Semver\Comparator;
use Drupal\Core\Site\Settings;
use DrupalFinder\DrupalFinder;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;
use Symfony\Component\Process\Process;

class ScriptHandler {

  /**
   * Generate missing base files such as setting files, salt and dotenv.
   *
   * @param \Composer\Script\Event $event
   *   The event.
   */
  public static function createRequiredFiles(Event $event) {
    $fs = new Filesystem();
    $drupalFinder = new DrupalFinder();
    $drupalFinder->locateRoot(getcwd());
    $drupalRoot = $drupalFinder->getDrupalRoot();

    $dirs = [
      'modules',
      'profiles',
      'themes',
    ];

    // Required for unit testing
    foreach ($dirs as $dir) {
      if (!$fs->exists($drupalRoot . '/' . $dir)) {
        $fs->mkdir($drupalRoot . '/' . $dir);
        $fs->touch($drupalRoot . '/' . $dir . '/.gitkeep');
      }
    }

    // Prepare the settings file for custom installation
    if (!$fs->exists($drupalRoot . '/sites/default/settings.php') && $fs->exists($drupalRoot . '/sites/custom.settings.php')) {
      $fs->copy($drupalRoot . '/sites/custom.settings.php', $drupalRoot . '/sites/default/settings.php');
      $fs->chmod($drupalRoot . '/sites/default/settings.php', 0666);
      $event->getIO()->write("Created a sites/default/settings.php file using custom template with chmod 0666");
    }

    // Prepare the settings file for default installation.
    if (!$fs->exists($drupalRoot . '/sites/default/settings.php') && $fs->exists($drupalRoot . '/sites/default/default.settings.php')) {
      $fs->copy($drupalRoot . '/sites/default/default.settings.php', $drupalRoot . '/sites/default/settings.php');
      $fs->chmod($drupalRoot . '/sites/default/settings.php', 0666);
      $event->getIO()->write("Created a sites/default/settings.php file using default template with chmod 0666");
    }

    // Create the files directory with chmod 0777
    if (!$fs->exists($drupalRoot . '/sites/default/files')) {
      $oldmask = umask(0);
      $fs->mkdir($drupalRoot . '/sites/default/files', 0777);
      umask($oldmask);
      $event->getIO()->write("Created a sites/default/files directory with chmod 0777");
    }
  }

  /**
   * Helper method to run any executable available in vendor/bin.
   *
   * Process output is logged under logs/{$exec}.log
   *
   * @param \Composer\Script\Event $event
   *   The event.
   * @param string $exec
   *   A given executable file name.
   */
  protected static function runExec(Event $event, string $exec, array $args = []) {
    $io = $event->getIO();
    $fs = new Filesystem();
    $drupalFinder = new DrupalFinder();
    $drupalFinder->locateRoot(getcwd());
    $binPath = $drupalFinder->getVendorDir() . "/bin/$exec";

    if (!$fs->exists($binPath)) {
      $io->write("Missing executable: $binPath");
      return;
    }

    // Execute the process with all arguments.
    $args = array_merge($args, $event->getArguments());
    $process_args = array_merge([$binPath], $args);
    $process = new Process($process_args);
    $process->run();

    $logPath = $drupalFinder->getComposerRoot() . '/logs';
    $logFilename = $logPath . '/' . $exec . '.log';
    $fs->touch($logFilename);
    file_put_contents($logFilename, $process->getOutput());

    $io->write('Task completed.');
    $io->write("See log: $logFilename");
  }

  /**
   * Handler our custom composer script to run PHPCBF.
   *
   * @param \Composer\Script\Event $event
   *   The event.
   */
  public static function codeFix(Event $event) {
    self::runExec($event, 'phpcbf');
  }

  /**
   * Handler our custom composer script to run PHPCS.
   *
   * @param \Composer\Script\Event $event
   *   The event.
   */
  public static function codeCheck(Event $event) {
    self::runExec($event, 'phpcs');
  }

  /**
   * Handler our custom composer script to run PHPSTAN.
   *
   * @param \Composer\Script\Event $event
   *   The event.
   */
  public static function codeScan(Event $event) {
    self::runExec($event, 'phpstan', ['analyze']);
  }

  /**
   * Handler our custom composer script to clean PHPSTAN.
   *
   * @param \Composer\Script\Event $event
   *   The event.
   */
  public static function codeClean(Event $event) {
    $io = $event->getIO();
    $io->write('Work in progress.');
    /*
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
    */
  }
}
