<?php
/**
 * An abstract base class for building an Entity Class Object
 *
 * @author lordmatt 
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
abstract class aEntityClass extends aLogger{
    protected $URI = null; // The RI being managed
    protected $parsed_RI = null; // the parsed version
    protected $subUER = array(); // further RI objects
    
    protected $object_data = array(
        'name'=>'unknown',
        'description'=>'unknown',
        'version'=>'unknown',
        'API'=>'uknown',
        'support'=>'unknown',        
        'updates'=>'unknown',
        'author'=>'unknown',
        'website'=>'unknown'
    );
    public function inspect_object($detail=false){
        if($detail === false){
            return $this->object_data;
        }
        if(isset($this->object_data[$detail])){
            return $this->object_data[$detail];
        }
        return false;
    }

    /*
     *  HELPER METHODS
     */
    protected function render_as_link($class=''){
        if(trim($class)!=''){
            $class .= ' ';
        }
        $link = "<span class='{$class}link UEntity'><a href='{$this->URI}' class='UEntity'>{$this->RI}</a></span>";
        return $link;
    }

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
        $this->RI  = $RI;
        $this->parsed_RI = $parsed_ri;
    }
    
    
}
