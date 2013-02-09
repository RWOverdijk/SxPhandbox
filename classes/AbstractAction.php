<?php

abstract class AbstractAction
{
    protected $request;
    
    protected $contentType = 'application/json';
    
    public function __construct($request) 
    {
        $this->request = $request;
    }
    
    protected function setContentType($contentType)
    {
        $this->contentType = $contentType;
    }
    
    public function getContentType()
    {
        return $this->contentType;
    }
    
    abstract public function execute();
    
}
