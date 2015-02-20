<?php
/**
 * Description of aLogger
 *
 * @author lordmatt
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
