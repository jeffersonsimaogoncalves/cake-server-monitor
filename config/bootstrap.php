<?php

use Cake\Core\Configure;

Configure::write('CakeServerMonitor.commands', [
    'disk_space' => 'JeffersonSimaoGoncalves\CakeServerMonitor\CommandDefinition\DiskSpace',
    'mysql'      => 'JeffersonSimaoGoncalves\CakeServerMonitor\CommandDefinition\MySql',
    'nginx'      => 'JeffersonSimaoGoncalves\CakeServerMonitor\CommandDefinition\Nginx',
    'php7fpm'    => 'JeffersonSimaoGoncalves\CakeServerMonitor\CommandDefinition\Php7Fpm',
]);

Configure::write('CakeServerMonitor.email', [
    'profile'    => 'default',
    'recipients' => [],
]);

// Optionally load additional queue config defaults from local app config
if (file_exists(ROOT . DS . 'config' . DS . 'cake_server_monitor.php')) {
    Configure::load('cake_server_monitor');
}
