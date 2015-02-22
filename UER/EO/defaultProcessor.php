<?php
/**
 * A standard class for processing RI into object ready arrays.
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
class defaultProcessor extends aEntityClass implements iProcessor {
    
    
    public static function get_processors(){
        return array('URN','URS','HTTP','HTTPS');
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
    
    public function process_HTTPS($RI){
        $result = $this->process_HTTP($RI);
        return $result;
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
