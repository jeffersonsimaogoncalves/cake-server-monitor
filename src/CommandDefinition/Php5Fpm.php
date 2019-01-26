<?php
/**
 * Created by PhpStorm.
 * User: xu
 * Date: 26/10/17
 * Time: 8:24 PM
 */

namespace JeffersonSimaoGoncalves\CakeServerMonitor\CommandDefinition;

/**
 * Class Php5Fpm
 *
 * Date: 26/01/2019 10:28
 *
 * Project: cakephp-server-monitor
 *
 * @author Jefferson Simão Gonçalves <gerson.simao.92@gmail.com>
 *
 * @package JeffersonSimaoGoncalves\CakeServerMonitor\CommandDefinition
 */
class Php5Fpm
    extends CommandDefinition
{
    public function resolve($output)
    {
        return !empty($output);
    }

    public function getSuccessMsg()
    {
        return 'PHP-FPM is running fine';
    }

    public function getFailMsg()
    {
        return 'PHP-FPM has stopped running';
    }

    public function rawCommand()
    {
        return 'ps -e | grep fpm$';
    }

}
