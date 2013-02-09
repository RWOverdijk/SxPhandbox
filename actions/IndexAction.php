<?php

require_once __DIR__ . '/../classes/Template.php';
require_once __DIR__ . '/../classes/AbstractAction.php';

class IndexAction extends AbstractAction
{
    public function __construct($request)
    {
        parent::__construct($request);
        
        $this->setContentType('text/html');
    }
    
    public function execute()
    {
        $template = new Template(__DIR__ . '/../templates/index.phtml');
        
        $template->snippets = $this->getSnippets();
        
        return $template;
    }
    
    protected function getSnippets()
    {
        $snippets = glob(SNIPPET_DIR . "*.php");
        
        array_walk($snippets, function(&$snippet) {
            $snippet = str_replace(SNIPPET_DIR, '', $snippet);
        });
        
        return $snippets;
    }
}
