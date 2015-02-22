<?php
/**
 * An abstract logger class to provide basic error and debug logging
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
abstract class aLogger {
    
    protected $logs = array();
    public $debugmode=true;
    
    public function get_error_log(){
        return $this->logs;
    }
    
    protected function log_error($error){
        $this->debug($error);
        $trace=debug_backtrace();
        $caller=$trace[1];
        $trigger = '';
        if (isset($caller['class'])){
            $trigger .= "{$caller['class']}::";   
        }
        $trigger .= "{$caller['function']}";
        $report = array();
        $report['location']=$trigger;
        $report['message']=$error;
        if(isset($this->URI)){
            $report['URI']=$this->URI;
        }
        $this->logs[]=$report;
    }
    
    /**
     * Get and empty the error log
     * @return array
     */
    public function flush_error_log(){
        $error_log = $this->get_error_log();
        $this->logs=array();
        return $error_log;
    }
    
    protected function debug($message){
        $trace=debug_backtrace();
        $caller=$trace[1];
        $trigger = '';
        if (isset($caller['class'])){
            $trigger .= "{$caller['class']}::";   
        }
        $trigger .= "{$caller['function']}";
        if($this->debugmode){
            echo "<p>{$trigger} says <q>{$message}</q></p>";
        }
    }
}
