<?php

require_once __DIR__ . '/../classes/AbstractAction.php';

class LoadAction extends AbstractAction
{    
    public function execute()
    {
        $query = $this->request->getQuery();
        
        $fileName   = $query['filename'];
        
        if (substr($fileName, -4) === '.php') {
            $fileName = substr($fileName, 0, -4);
        }
        
        $fileName .= '.php';
        
        $code = file_get_contents(__DIR__ . '/../data/snippets/'.$fileName);
        
        return json_encode(array(
            'status' => 'ok',
            'code' => $code,
        ));
    }
}
