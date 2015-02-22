<?php
/**
 * The class defaultURL is a special case, in that it does not register handlers
 * instead it is used with URLs when the system has no idea what else to do with
 * the URL in question.
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

class defaultURL extends aEntityClass implements iEntityClass {
    
    protected $ready = false;
    protected $RI;
    public $infoURL = "http://example.com/?rx=";
    
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
    
    /**
     *  Uniform Resorce Locator
     */
    public function handle_HTTP($RI,$parsed_ri){
        $this->basic_ri_actions($RI,$parsed_ri);
        $this->RI=$this->URI;
        $this->ready=true;
        return true;
    }
    
    /**
     *  Uniform Resource Name
     */
    public function handle_URN($RI,$parsed_ri){
        $this->basic_ri_actions($RI, $parsed_ri);
        $this->URI = $this->infoURL.$RI;
        $this->RI=$RI;
        $this->ready=true;
        return true;
    }
    
    /**
     *  System Resource Name - format as URN
     */
    public function handle_SRN($RI,$parsed_ri){
        $this->handle_URN($RI, $parsed_ri);
        return true;
    }
    
    /**
     *  Some systems may wish to pass render context information but it should 
     * not be universally expected and is entirely optional.
     */
    public function render_class($context=null){
        if(!$this->ready){
            return false;   
        }
        // you can do better I have no doubt
        $link = "<span class='link UEntity'><a href='{$this->URI}' class='UEntity'>{$this->RI}</a></span>";
        return $link;
    }

    public static function get_handlers() {
        return false;
    }
    
}
