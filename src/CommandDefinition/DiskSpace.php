<?php
/**
 * Created by Li
 * Website: www.watchowl.io
 * Email: welcome@watchowl.io
 * Date: 2/10/17
 * Time: 7:32 PM
 */

namespace JeffersonSimaoGoncalves\CakeServerMonitor\CommandDefinition;

/**
 * Class DiskSpace
 *
 * Date: 26/01/2019 10:28
 *
 * Project: cakephp-server-monitor
 *
 * @author Jefferson Simão Gonçalves <gerson.simao.92@gmail.com>
 *
 * @package JeffersonSimaoGoncalves\CakeServerMonitor\CommandDefinition
 */
class DiskSpace
    extends CommandDefinition
{
    /**
     * @var int percentage of failed threshold
     */
    private $failThreshold = 80;

    /**
     * @var int current percentage of usage
     */
    private $currentUsagePercentage = 0;

    /**
     * @param string $output output after running the command
     *
     * @return boolean fail/success
     */
    public function resolve($output)
    {
        $this->currentUsagePercentage = $this->calCurrentUsage($output);

        if ($this->currentUsagePercentage > $this->failThreshold) {
            return false;
        }

        return true;
    }

    /**
     * Extract percentage of usage from command output
     *
     * @param $output
     *
     * @return int
     */
    private function calCurrentUsage($output)
    {
        $matches = [];

        if (preg_match('/(\d?\d)%/', $output, $matches)) {
            return (int)($matches[1]);
        }

        throw new \RuntimeException('Unable to get current disk space usage');
    }

    /**
     * @return string success message
     */
    public function getSuccessMsg()
    {
        return sprintf('Current disk space usage is safe at %s%%', $this->currentUsagePercentage);
    }

    /**
     * @return string fail message
     */
    public function getFailMsg()
    {
        return sprintf('Disk space usage is running low at %s%%', $this->currentUsagePercentage);
    }

    /**
     * @return string command to run on OS
     */
    public function rawCommand()
    {
        return 'df -P .';
    }

}
