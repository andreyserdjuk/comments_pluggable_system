<?php

namespace CommentsPluggableSystem;

class InputFormTemplatePresenter extends BaseTemplate
{
    public function __construct($templatePath=null, $templateName=null)
    {
        parent::__construct($templatePath);
        $this->templateName = $templateName? $templateName : 'display_input_form.php';
    }

    protected function getTemplateName()
    {
        return $this->templateName;
    }
}