<?php
/**
 * Description of defaultProcessor
 *
 * @author lordmatt
 */
class defaultProcessor extends aEntityClass implements iEntityClass {
    
    public static function get_handlers(){
        return array(); // impliments none
    }
    
    public static function get_processors(){
        return array('URN','URS','HTTP');
    }

    public function process_URN($RI){
        $parts = explode(':',$RI);
        $parsed_URL= array();
        $parsed_URL['schema']=$parts[0];
        $parsed_URL['NID']=$parts[1];
        $parsed_URL['NSS']=array_shift(array_shift($parts));
        return $parsed_URL;
    }
    
    public function process_HTTP($RI){
        $parsed_URL = parse_url($RI);
        $parsed_URL['NID']=$parsed_URL['host'];
        return $parsed_URL;
    }
    
    /**
     * See process_URN($RI)
     * @param type $RI
     * @return type 
     */
    public function process_SRN($RI){
        // since the format is exactly the same...
        return $this->process_URN($RI); 
    }
    
    
    /**
     *  this class does not render anything 
     */
    public function render_class($context=null){
        return false;
    }
    
    protected function failure_to_parse_URI(){
        $this->log_error('This should not be called');
    }

}
