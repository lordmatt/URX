<?php
/**
 * The class defaultURL is a special case, in that it does not register handlers
 * instead it is used with URLs when the system has no idea what else to do with
 * the URL in question.
 *
 * @author lordmatt
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
    
    public static function get_processors(){
        return array('HTTP','URN','SRN');
    }
    
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


    
}
