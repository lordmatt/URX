<?php
/**
 * This interface defines how an entity class should present API for defering 
 * creation of an entity object.
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
interface iEntityClass {
    
    /**
     * For format of array should be as follows
     * array(
     *   array('schema'=>'http','domain'=>'example.com'), // for usual domain handler cases
     *   array('schema'=>'https','redirects'=>'http'), // for cases where one schema should be treated as the other
     *   ...
     * )
     * 
     * in the case of URN and SRN domain is synonomouse with NID
     * 
     * Be sure that there is a public handle_[$SCHEMANAME](); for each schema
     * that the prcoessor offers to handle a namespace for.
     * 
     * @return array 
     */
    public static function get_handlers();

    
    /**
     * Some systems may wish to pass render context information but it should 
     * not be universally expected and is entirely optional.
     * @return string or false
     */
    public function render_class($context=null);
    
    /**
     * Provides an array of error data, each entry should also be an array.
     * This method is implimented by aEntityClass.
     * @return array 
     */
    public function get_error_log();
    
    /**
     * This interface requirement is intended to provide a number of expected 
     * behaviours. When no paramaters are provided an array of available data
     * elements should be returned. When there is a paramater given if it is a
     * string then the data should be returned and if array then all matches 
     * within the array should be returned. In all other cases null should be 
     * returned.
     */
    public function inspect_object($detail=false);
    
}


/*

    /**
     * System Resource Name - format as 'URN'. In essence SRN are unofficial URN
     * but granted a different schema to avoid confusion and name space clashes. 
     * example SRN:Blog:1
     * example SRN:youtube:lWTl5-wYX9o
     * example SRN:TWIT:lordmatt
     * 99% of the time you will probably just want to redirect to handle_URN
     * $this->handle_URN($NID,$SSI);
     * 
     * @return bool
    
    public function handle_SRN($NID,$SSI=array());
 */