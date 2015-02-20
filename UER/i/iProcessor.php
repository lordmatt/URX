<?php

/**
 *
 * @author lordmatt
 */
interface iProcessor {
    
    /**
     * Be sure that there is a public process_[$SCHEMANAME](); for each schema
     * that the prcoessor offers to handle a namespace for. 
     * 
     * @return array
     */
    public static function get_processors();
    
}
