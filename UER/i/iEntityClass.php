<?php
/**
 * This interface defines how an entity class should present API for defering 
 * creation of an entity object.
 * 
 * @author lordmatt
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
     * Be sure that there is a public process_[$SCHEMANAME](); for each schema
     * that the prcoessor offers to handle a namespace for. 
     * 
     * @return array
     */
    public static function get_processors();
    
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
    
}


/*
   /**
     * Uniform Resorce Locator
     * @return bool
     
    public function handle_URL($URL,$parsed_url);
    
    /**
     * Uniform Resource Name
     * 
     * SSI is an array of the URN parts (SSI) after the NID
     * 
     * @return bool
     
    public function handle_URN($NID,$SSI=array());
    
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