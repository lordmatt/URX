<?php
/**
 * Description of defaultProcessor
 *
 * @author lordmatt
 */
class defaultProcessor extends aEntityClass implements iProcessor {
    
    
    public static function get_processors(){
        return array('URN','URS','HTTP');
    }
    
    /**
     * Parses URN formatted strings into an array for deligation by the EP
     * Note: the EP expects an array element called NID which identifies the
     *       name space for selection of a processor object
     * @param string $RI
     * @return array 
     */
    public function process_URN($RI){
        $parts = explode(':',$RI);
        $parsed_URL= array();
        $parsed_URL['schema']=$parts[0];
        $parsed_URL['NID']=$parts[1];
        $parsed_URL['NSS']=array_slice($parts,2);
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
    
    protected function failure_to_parse_URI(){
        $this->log_error('This should not be called');
    }

}
