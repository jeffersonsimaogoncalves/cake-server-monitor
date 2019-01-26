<?php
/**
 * Created by PhpStorm.
 * User: xu
 * Date: 26/10/17
 * Time: 8:15 PM
 */

namespace JeffersonSimaoGoncalves\CakeServerMonitor\CommandDefinition;

/**
 * Class Nginx
 *
 * Date: 26/01/2019 10:28
 *
 * Project: cakephp-server-monitor
 *
 * @author Jefferson Simão Gonçalves <gerson.simao.92@gmail.com>
 *
 * @package JeffersonSimaoGoncalves\CakeServerMonitor\CommandDefinition
 */
class Nginx
    extends CommandDefinition
{
    public function resolve($output)
    {
        return !empty($output);
    }

    public function getSuccessMsg()
    {
        return 'Nginx is running fine';
    }

    public function getFailMsg()
    {
        return 'Nginx has stopped running';
    }

    public function rawCommand()
    {
        return 'ps -e | grep nginx$';
    }

}
