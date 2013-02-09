<?php

require_once __DIR__ . '/../classes/Template.php';
require_once __DIR__ . '/../classes/AbstractAction.php';

class ExecuteAction extends AbstractAction
{
    public function execute()
    {
        $query = $this->request->getQuery();
        
        return $this->lintCode($query['pcode']);
    }
    
    protected function lintCode($code)
    {
        $tmpFile = tempnam(sys_get_temp_dir(), 'lint');
        
        $debug = "<?php error_reporting(E_ALL);ini_set('display_errors', '1');?>";
        file_put_contents($tmpFile, $debug.$code);

        $op             = `php -l $tmpFile`;
        $execOutput     = `php $tmpFile`;
        $matchesOp      = null;
        $matchesExec    = null;
        
        preg_match_all('/(Parse error:\s*syntax error,|Warning:\s|Notice\s)(?<message>.+?)\s+in\s+.+?\s*line\s+(?<line>\d+)/i', $op, $matchesOp);
        preg_match_all('/(?<type>Parse error:\s*syntax error,|Warning:\s|Notice:\s)(?<message>.+?)\s+in\s+.+?\s*line\s+(?<line>\d+)/i', $execOutput, $matchesExec);
        
        if (empty($matchesExec['message']) && empty($matchesOp['message'])) {

            $res = json_encode(array(
                'status'    => 'ok',
                'content'   => $execOutput,
            ));
        } else {

            if (empty($matchesOp['messages'])) {
                $matches = $matchesExec;
            } else {
                $matches = $matchesOp;
            }
            
            $annotations = array();
            
            for ($i=0;$i<count($matches['message']);$i++) {
                
                $rawType = strtolower(trim($matches['type'][$i], ': '));

                switch ($rawType) {
                    case 'parse error: syntax error,':
                        $type = 'error';
                        break;
                    case 'warning':
                        $type = 'warning';
                        break;
                    case 'notice':
                        $type = 'info';
                        break;
                }
                
                $annotations[] = array(
                    'row'     => intval((int) $matches['line'][$i])-1,
                    'column'  => 0,
                    'text'    => trim($matches['message'][$i]),
                    'type'    => $type
                );
            }

            $res = json_encode(array(
                'status'        => 'error',
                'content'       => $op,
                'annotations'   => $annotations,
            ));
        }
            
        unlink($tmpFile);

        return $res;
    }
}
