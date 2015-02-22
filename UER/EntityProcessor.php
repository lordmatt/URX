<?php
/**
 * EntityProcessor is the factory class that will pass you an object from a RI
 *
 * To use a custom system entity object path define _SYS_EO_PATH_ before 
 * including this class.
 * 
 * @author Lord Matt 
 * @link https://github.com/lordmatt/URX
 * 
 * @license
 *  Copyright (C) 2015 Matthew Brown
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 *  GNU General Public License for more details.
 *  You should have received a copy of the GNU General Public License along
 *  with this program; if not, write to the Free Software Foundation, Inc.,
 *  51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 */

if(!defined('_SYS_EO_PATH_')){
    define('_SYS_EO_PATH_', dirname(__FILE__).'/sysEO');
}

class EntityProcessor extends aLogger {
    
    // TODO Register Schema processor
    // To add: XRI: https://en.wikipedia.org/wiki/Extensible_resource_identifier
    // To add: Handle System: https://en.wikipedia.org/wiki/Handle_System
    protected $map = array(
        'URN'=>array(),
        'SRN'=>array(),
        'HTTP'=>array(),
        'HTTPS'=>'HTTP'
        );
    protected $handlers = array();
    protected $schema_processors = array(
        'URN'=>array(),
        'SRN'=>array(),
        'HTTP'=>array(),
        'HTTPS'=>array()
    );
    protected $last_mapped_schema = '';
    public function __construct($input=false) {
        $this->map_handler('HTTP','*','defaultURL');
        $this->map_handler('URN','*','defaultURL');
        $this->map_handler('SRN','*','defaultURL');
        spl_autoload_register(array($this, 'UER_loader'));
        if($input){
            $this->register_handlers($input);
        }
        $this->register_handlers('defaultProcessor');
    }
    
    protected function get_schema_processors($schema){
        $schema = strtoupper($schema);
        if(!isset($this->schema_processors[$schema])){
            $this->debug("get_schema_processor({$schema}) - what am I supposed to do with that?");
            // cannot cope with this
            return false;
        }
        if(is_array($this->schema_processors[$schema])!=true){
            $this->debug("That is not even an array");
            return false;
        }

        return $this->schema_processors[$schema];
    }
    
    /**
     * Takes the RI and creates the relivant object from it.
     * @param string $RI (resource identifyer)
     * @return object or false on error 
     */
    public function getObject($RI){
        $parts = explode(':',$RI);
        $schema=$parts[0];
        $schema = strtoupper($schema);
        unset($parts);
        $SPs = $this->get_schema_processors($schema);
        if($SPs===false){
            $this->log_error("Failed to get processor list");
            return false;
        }
        $parsed_ri = '';
        $action = "process_{$schema}";
        foreach($SPs as $sp){
            $handle = $this->get_handler_obj($sp);
            $parsed_ri = $handle->{$action}($RI);
            if(is_array($parsed_ri)){
                break;
            }
        }
        if(!is_array($parsed_ri) || !isset($parsed_ri['NID'])){
            $this->log_error('Failed to parse RI.');
            return false;
        }
        $mappoint=$this->get_map_point_for_schema($schema);
        if( ($this->last_mapped_schema != '') && ($schema!=$this->last_mapped_schema) ){
            $this->debug('Assuming that schema redirected');
            $schema = $this->last_mapped_schema;
        }
        $action = "handle_{$schema}";
        $handler = $this->get_handler_for_schema($schema, $parsed_ri['NID']);
        
        if(!is_object($handler)){
            $this->log_error("Failed to make object for $RI");
            return false;
        }
        
        // do the deed.
        $handler->{$action}($RI,$parsed_ri);
        
        return $handler;// return object in question
    }
    
    protected function get_handler_for_schema($schema,$NID){
        $this->debug("get_handler_for_schema($schema,$NID)");
        $map_point = $this->get_map_point_for_schema($schema);
        if($map_point===false){
            $this->log_error("Map Point Failed for $schema,$NID)");
            return false;
        }
        //$this->debug("Map Point: ".print_r($map_point, true));
        if(!isset($map_point[$NID])){
            if(isset($map_point['*'])){
                $NID = '*';
            }else{
                $this->log_error("No default found for $schema)");
                return false;
            }
        }
        //$this->debug("Map Point: ".print_r($map_point, true));
        $handler = $this->get_handler_obj($map_point[$NID]);
        return $handler;
    }
    
    protected function get_map_point_for_schema($schema,$loop=0){
        // sanity check
        if($loop==10){
            $this->log_error('Possible redirect recursion detected.');
            return false;
        }
        if(is_array($schema)){
            $this->debug("How the hell did you manage to get an array in here?");
            return false;
        }
        if( (trim($schema)=='') || (!isset($this->map[$schema])) ){
            $this->debug("map-point error: '{$schema}' not set on parse {$loop}");
            $this->log_error("'{$schema}' is unknown.");
            return false;
        }
        $map_point = $this->map[$schema];
        if(!is_array($map_point)){
            ++$loop;
            $this->last_mapped_schema = $map_point;
            $map_point = $this->get_map_point_for_schema($map_point, $loop);
        }
        
        return $map_point;        
    }
    
    protected function get_handler_obj($h){
            if(trim($h)==''){
                $this->log_error("get_handler_obj($h) is empty");
                return false;
            }
            if(!isset($this->handlers[$h])){
                $this->handlers[$h] = new $h();
            }
            return $this->handlers[$h];
    }
    
    public function addHandlers($handlers){
        return $this->register_handlers($handlers);
    }
    
    protected function register_handlers($input){
        if(!is_array($input)){
            $this->_register_handler(   (string)$input );
            $this->_register_processer( (string)$input );
        }else{
            foreach($input as $handler){
                $this->_register_handler(   (string)$handler );
                $this->_register_processer( (string)$handler );
            }
        }
        return true;
    }
   
    protected function _register_handler($handler){
        //$this->handlers[$handler]= new $handler();
        //$handles = $this->handlers[$handler]->get_handlers();
        $ints = class_implements($handler,true);
        if(isset($ints['iEntityClass'])) {
            $handles = $handler::get_handlers();
            if(empty($handles)){ return false; }
            foreach($handles as $handle){
                if(isset($handle['redirects'])){
                    $this->map_handler_schema_redirect($handle['schema'],$handle['redirects']);
                }else{
                    $this->map_handler($handle['schema'],$handle['NID'],$handler);
                }
            }
            return true;
        }
        $this->debug("{$handler} is not a handler");
        return false;
    }
    
    protected function _register_processer($handler){
        $ints = class_implements($handler,true);
        if(isset($ints['iProcessor'])) {
            $pro=$handler::get_processors();
            if(empty($pro)){ return false; }
            foreach($pro as $p){
                $this->schema_processors[$p][] = $handler;
            }
            return true;
        }
        $this->debug("{$handler} is not a processor");
        $this->debug(print_r(class_implements($handler,true),true));
        return false;
    }
    
    /**
     * Autoload function for Entity Objects
     * 
     * According to  (delphists) at (apollo) dot (lv) this privte class should
     * still work: http://php.net/manual/en/function.spl-autoload-register.php
     * 
     * @param type $className
     * @return boolean 
     */
    private function UER_loader($className) {
        $this->debug("Loading: $className");
        $path = dirname(__FILE__);
        $EO = "{$path}/EO/{$className}.php";
        $iEO = "{$path}/i/{$className}.php";
        $aEO = "{$path}/a/{$className}.php";
        $sysEO = _SYS_EO_PATH_."/{$className}.php";
        if(file_exists($EO)){
            include_once($EO);
            return true;
        }elseif(file_exists($sysEO)){
            include_once($sysEO);
            return true;
        }elseif(file_exists($iEO)){
            include_once($iEO);
            return true;
        }elseif(file_exists($aEO)){
            include_once($aEO);
            return true;
        }else{
            $this->debug("No luck with {$className}");
            $this->log_error('Failed to autoload '.$className);
            return false;
        }
        //include ;
    }
    
    protected function map_handler_schema_redirect($schema,$redirects){
        $this->map[$schema]=$redirects;
    }
    
    protected function map_handler($schema,$NID,$handler){
        $this->map[$schema][$NID]=$handler;
    }
        
}
