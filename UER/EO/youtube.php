<?php
/**
 * This EO creates a simple youtube object and renders it for embed code or link
 * a better version would also provide access to a rich selection of youtube API
 * and provide a far greater range of possible OO actions.
 * 
 * @todo Set a youtube interface so the extra options can be tested for
 * 
 * @version 1.0.0
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



class youtube extends aEntityClass implements iEntityClass {
    
    protected $ready = false;
    protected $RI;
    
    // youtube specifics
    protected $tubecode = false;
    protected $width=500;
    protected $height=281;
    protected $fullscreen=true;
    
    protected $object_data = array(
        'name'=>'UER For You Tube',
        'description'=>'Convert Youtube links and SRI into youtube embed code.',
        'version'=>'1.0.0',
        'API'=>'set_size,set_fullscreen,get_SRN',
        'support'=>'core',        
        'updates'=>'core',
        'author'=>'Lord Matt',
        'website'=>'https://github.com/lordmatt/URX'
    );    
    
    public function get_SRN(){
        if($this->tubecode!==false){
            return "SRN:youtube:{$this->tubecode}";
        }else{
            return false;
        }
    }
    
    public function set_size($width,$height){
        $this->width  = $width;
        $this->height = $height;
    }
    
    public function set_fullscreen($fullscreen=true){
        $this->fullscreen = $fullscreen;
    }
    
    public function handle_HTTP($RI,$parsed_ri){
        $this->basic_ri_actions($RI,$parsed_ri);
        //$this->debug(print_r($parsed_ri,true));
        $tryshort = false;
        if(isset($parsed_ri['query'])){
            parse_str($parsed_ri['query'], $vars );
            if(isset($vars['v'])){
                $this->tubecode = $vars['v'];
            }else{
                $tryshort = true;
            }
        }else{
            $tryshort = true;
        }
        if($tryshort){
            if( !isset($parsed_ri['path']) ){
                $this->log_error("I don't know how to read any of the RI: {$RI}");
                return false;
            }
            if(substr_count($parsed_ri['path'], '/')>1){
                $this->log_error("I don't know how to read the path of RI: {$RI}");
                return false;
            }
            // time to make a few assumptions
            $this->tubecode = str_replace('/','', $parsed_ri['path']);
        }
        $this->ready=true;
        return true;
    }
    
    public function render_as_embed(){
        $youtube = '<iframe class="video UEntity" allowtransparency="true" scrolling="no" width="'.$this->width.'" height="'.$this->height.'" src="//www.youtube.com/embed/'.$this->tubecode.'?rel=0" frameborder="0"'.($this->fullscreen?' allowfullscreen':NULL).'></iframe>';
        return $youtube;
    }
    
    public function render_class($context = null) {
        if(!$this->ready){
            $this->log_error("Render requested before ready. How did you manage that?");
            return false;   
        }
        if($context != null && strtolower($context) == 'link'){
            return $this->render_as_link();
        }
        return $this->render_as_embed();
    }
    
    public static function get_handlers() {
        $schema = 'HTTP';
        $domain_variants = array('youtube.com', 'www.youtube.com', 'youtu.be', 'www.youtu.be');
        $output = array();
        foreach($domain_variants as $DV){
            $row = array();
            $row['schema'] = $schema;
            $row['NID'] = $DV;
            $output[] = $row;
        }
        return $output;
    }

}