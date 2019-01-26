<?php
/**
 * Created by PhpStorm.
 * User: xu
 * Date: 26/10/17
 * Time: 8:09 PM
 */

namespace JeffersonSimaoGoncalves\CakeServerMonitor\CommandDefinition;

/**
 * Class MySql
 *
 * Date: 26/01/2019 10:28
 *
 * Project: cakephp-server-monitor
 *
 * @author Jefferson Simão Gonçalves <gerson.simao.92@gmail.com>
 *
 * @package JeffersonSimaoGoncalves\CakeServerMonitor\CommandDefinition
 */
class MySql
    extends CommandDefinition
{
    public function resolve($output)
    {
        return !empty($output);
    }

    public function getSuccessMsg()
    {
        return 'MySql is running fine';
    }

    public function getFailMsg()
    {
        return 'MySql has stopped running';
    }

    public function rawCommand()
    {
        return 'ps -e | grep mysqld$';
    }
}
