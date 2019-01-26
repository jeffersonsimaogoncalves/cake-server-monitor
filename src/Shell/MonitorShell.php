<?php
/**
 * Created by Li
 * Website: www.watchowl.io
 * Email: welcome@watchowl.io
 * Date: 2/10/17
 * Time: 7:32 PM
 */

namespace JeffersonSimaoGoncalves\CakeServerMonitor\Shell;

use Cake\Console\Shell;
use Cake\Core\Configure;
use Cake\Mailer\Email;
use Cake\Utility\Hash;
use Cake\Validation\Validation;
use JeffersonSimaoGoncalves\CakeServerMonitor\System\OperatingSystem;

/**
 * Class MonitorShell
 *
 * Date: 26/01/2019 10:29
 *
 * Project: cakephp-server-monitor
 *
 * @author Jefferson Simão Gonçalves <gerson.simao.92@gmail.com>
 *
 * @package JeffersonSimaoGoncalves\CakeServerMonitor\Shell
 */
class MonitorShell
    extends Shell
{
    /**
     * @var OperatingSystem
     */
    private $operatingSystem;

    /**
     * @var array $commands list of commands
     */
    private $commands = [];

    /**
     * @var Email $email
     */
    private $email;

    /**
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $commands = (array)Configure::read('CakeServerMonitor.commands');

        $commands = array_filter($commands);

        $this->commands = array_map(function($namespaceClassName) {
            return new $namespaceClassName();
        }, $commands);

        $this->operatingSystem = new OperatingSystem();

        $this->email = $this->createEmail();
    }

    /**
     * @return \Cake\Mailer\Email
     */
    private function createEmail()
    {
        $emailConfig = Configure::read('CakeServerMonitor.email');
        $recipients = $this->extractRecipients($emailConfig);
        $email = new Email();
        $email->setProfile(Hash::get($emailConfig, 'profile'));
        $email->setTo($recipients);
        $email->setSubject(('Server Warning from Cake Server Monitor'));

        return $email;
    }

    /**
     * @param $emailConfig
     *
     * @return array|mixed
     */
    private function extractRecipients($emailConfig)
    {
        $recipients = Hash::get($emailConfig, 'recipients');

        if (!is_array($recipients)) {
            $recipients = [$recipients];
        }

        if (empty($recipients)) {
            throw new \RuntimeException(
                __('Please supply email recipient at CakeServerMonitor.email')
            );
        }

        foreach ($recipients as $recipient) {
            if (!Validation::email($recipient)) {
                throw new \RuntimeException(
                    __('Invalid email address {0} at CakeServerMonitor.email', $recipient)
                );
            }
        }

        return $recipients;
    }

    /**
     * @return \Cake\Console\ConsoleOptionParser
     */
    public function getOptionParser()
    {
        $parser = parent::getOptionParser();

        $parser->addSubcommand('run', [
            'parser' => [
                'description' => [
                    __('Start the server monitor'),
                ],
            ],
        ]);

        $parser->addSubcommand('view', [
            'parser' => [
                'description' => [
                    __('View the monitor stats'),
                ],
            ],
        ]);

        return $parser;
    }

    /**
     * @return bool|int|void|null
     */
    public function main()
    {
        $this->out($this->OptionParser->help());
    }

    /**
     * Run the monitor
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->commands as $command) {
            $result = $this->operatingSystem->check($command);
            $msg = $this->operatingSystem->getMsg();
            $this->verbose($msg);
            if (!$result) {
                $this->email->send($msg);
            }
        }
    }

    /**
     * View current monitor stats
     *
     * @return void
     */
    public function view()
    {
        foreach ($this->commands as $command) {
            $this->operatingSystem->check($command);
            $this->info($this->operatingSystem->getMsg());
        }
    }

    /**
     * @return array list of commands
     */
    public function getCommands()
    {
        return $this->commands;
    }

    /**
     * @param array $commands list of commands
     */
    public function setCommands($commands)
    {
        $this->commands = $commands;
    }

    /**
     * @return OperatingSystem
     */
    public function getOperatingSystem()
    {
        return $this->operatingSystem;
    }

    /**
     * @param OperatingSystem $operatingSystem
     */
    public function setOperatingSystem($operatingSystem)
    {
        $this->operatingSystem = $operatingSystem;
    }

    /**
     * @return Email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param Email $email
     */
    public function setEmail(Email $email)
    {
        $this->email = $email;
    }
}
