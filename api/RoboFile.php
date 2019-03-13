<?php
/**
 * This is project's console commands configuration for Robo task runner.
 *
 * @see http://robo.li/
 */
class RoboFile extends \Robo\Tasks
{
    // define public methods as commands
    public function start()
    {
        $this->_exec('php -S localhost:8000 route.php');
    }

    public function start2()
    {
        $this->_exec('php -S 192.168.31.131:8000 route.php');
    }
}