<?php

class Template
{
    protected $template;
    
    protected $data;
    
    public function __construct($template)
    {
        $this->template = $template;
    }
    
    public function render()
    {
        ob_start();
        include $this->template;
        
        return ob_get_clean();
    }
    
    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }
    
    public function __get($name)
    {
        return $this->data[$name];
    }
    
    public function __toString()
    {
        return $this->render();
    }
}
