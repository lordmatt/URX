<?php
/**
 * Description of aLogger
 *
 * @author lordmatt
 */
abstract class aLogger {
    
    protected $logs = array();
    
    public function get_error_log(){
        return $this->logs;
    }
    
    protected function log_error($error){
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
        $report['URI']=$this->URI;
        $this->logs[]=$report;
    }
    
}
