<?php

// phpcs:ignoreFile

// Default Drupal settings.
$databases = [];

$databases['default']['default'] = [
  'database' => getenv('DB_NAME'),
  'username' => getenv('DB_USER'),
  'password' => getenv('DB_PASS'),
  'host' => getenv('DB_HOST'),
  'port' => getenv('DB_PORT'),
  'driver' => getenv('DB_DRIVER') ?? 'mysql',
  'prefix' => '',
  'collation' => 'utf8mb4_general_ci',
];

// SQLite. Because speed matters.
// If selected, you need to install your site throught the UI.
// e.g. https://drupal-openai.lndo.site/install.php
if (getenv('DB_DRIVER') == 'sqlite') {
  $databases['default']['default'] = [
    'database' => 'sites/default/files/.ht.sqlite',
    'prefix' => '',
    'namespace' => 'Drupal\\sqlite\\Driver\\Database\\sqlite',
    'driver' => 'sqlite',
    'autoload' => 'core/modules/sqlite/src/Driver/Database/sqlite/',
  ];
}

$settings['config_sync_directory'] = '../config/sync';
$settings['hash_salt'] = file_get_contents($app_root . '/' . $site_path . '/salt.txt');
$settings['deployment_identifier'] = \Drupal::VERSION;
$settings['update_free_access'] = FALSE;

$settings['file_chmod_directory'] = 0775;
$settings['file_chmod_file'] = 0664;

# $settings['file_public_base_url'] = 'http://downloads.example.com/files';
$settings['file_public_path'] = $site_path . '/files';
$settings['file_private_path'] = $site_path . '/private';
$settings['file_temp_path'] = $site_path . '/tmp';

$config['system.performance']['fast_404']['exclude_paths'] = '/\/(?:styles)|(?:system\/files)\//';
$config['system.performance']['fast_404']['paths'] = '/\.(?:txt|png|gif|jpe?g|css|js|ico|swf|flv|cgi|bat|pl|dll|exe|asp)$/i';
$config['system.performance']['fast_404']['html'] = '<!DOCTYPE html><html><head><title>404 Not Found</title></head><body><h1>Not Found</h1><p>The requested URL "@path" was not found on this server.</p></body></html>';

$settings['container_yamls'][] = $app_root . '/' . $site_path . '/services.yml';

$settings['trusted_host_patterns'] = [
  '^localhost$',
  '^lndo\.site$',
  '^.+\.lndo\.site$',
];

$settings['file_scan_ignore_directories'] = [
  'node_modules',
  'bower_components',
];

$settings['entity_update_batch_size'] = 50;

$settings['entity_update_backup'] = TRUE;

$settings['migrate_node_migrate_type_classic'] = FALSE;

// Development settings.
assert_options(ASSERT_ACTIVE, TRUE);
\Drupal\Component\Assertion\Handle::register();

$settings['container_yamls'][] = DRUPAL_ROOT . '/sites/custom.services.yml';

$config['system.logging']['error_level'] = 'verbose';

$config['system.performance']['css']['preprocess'] = FALSE;
$config['system.performance']['js']['preprocess'] = FALSE;

$settings['cache']['bins']['render'] = 'cache.backend.null';
$settings['cache']['bins']['discovery_migration'] = 'cache.backend.memory';
$settings['cache']['bins']['page'] = 'cache.backend.null';
$settings['cache']['bins']['dynamic_page_cache'] = 'cache.backend.null';

# $settings['extension_discovery_scan_tests'] = TRUE;

$settings['rebuild_access'] = TRUE;

$settings['skip_permissions_hardening'] = TRUE;

$settings['config_exclude_modules'] = [
  'dblog',
  'devel',
  'devel_generate',
  'stage_file_proxy',
  'views_ui',
];

// Configuration split folders.
$config_splits = [];
$config_splits['local'] = TRUE;
$config_splits['stage'] = FALSE;
$config_splits['prod'] = FALSE;
foreach ($config_splits as $config_split_id => $config_split_status) {
  $config["config_split.config_split.$config_split_id"]['status'] = $config_split_status;
}

// Local settings.
if (file_exists($app_root . '/' . $site_path . '/settings.local.php')) {
  include $app_root . '/' . $site_path . '/settings.local.php';
}
