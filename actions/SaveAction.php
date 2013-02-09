<?php

require_once __DIR__ . '/../classes/AbstractAction.php';

class SaveAction extends AbstractAction
{    
    public function execute()
    {
        $query = $this->request->getQuery();
        
        $code       = $query['pcode'];
        $fileName   = $query['filename'];
        
        if (substr($fileName, -4) === '.php') {
            $fileName = substr($fileName, 0, -4);
        }
        
        $fileName .= '.php';
        
        file_put_contents(__DIR__ . '/../data/snippets/'.$fileName, $code);
        
        return json_encode(array(
            'status' => 'ok',
        ));
    }
}
