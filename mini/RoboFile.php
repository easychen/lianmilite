<?php
/**
 * This is project's console commands configuration for Robo task runner.
 *
 * @see http://robo.li/
 */
class RoboFile extends \Robo\Tasks
{
    public function beautify()
    {
        $this->_exec('find . -type f -name "*.js"  -not -path "./node_modules/*" -not -path "./miniprogram_npm/*" -exec js-beautify -r {} \;'); 
    }
}