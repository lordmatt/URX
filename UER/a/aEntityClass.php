<?php
/**
 * An abstract base class for building an Entity Class Object
 *
 * @author lordmatt
 */
abstract class aEntityClass extends aLogger{
    protected $URI = null; // The RI being managed
    protected $parsed_RI = null; // the parsed version
    protected $subUER = array(); // further RI objects

    protected function failure_to_parse_URI(){
        echo "Provide a replacement function in your sub class that is more usefull";
        $this->log_error('No failure function defined');
    }
    
    /** 
     * Things that get done almost every time any RI is converted to an object
     * @param type $RI
     * @param type $parsed_ri 
     */
    protected function basic_ri_actions($RI,$parsed_ri){
        $this->URI = $RI;
        $this->parsed_RI = $parsed_ri;
    }
    
}
