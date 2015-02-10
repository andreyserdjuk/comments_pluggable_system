<?php

namespace CommentsPluggableSystem;

/**
 * Class BaseTemplate
 *
 * Render or display templates
 *
 * @package CommentsPluggableSystem
 */
abstract class BaseTemplate
{
    /**
     * Path to the template file to be included
     *
     * @var string
     */
    private $templatePath;


    public function __construct($templatePath = null)
    {
        $this->templatePath = $templatePath? $templatePath : __DIR__ . '/Templates/';
    }

    public function render()
    {
        ob_start();
        $this->display();
        return ob_get_clean();
    }

    public function display()
    {
        $pathToFile = $this->templatePath . $this->getTemplateName();
        if (file_exists($pathToFile)) {
            include $pathToFile;
        } else {
            throw new \RuntimeException('no template file ' . $this->templatePath . ' found in directory ' . $this->templatePath);
        }
    }

    abstract protected function getTemplateName();
}