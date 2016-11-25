<?php

namespace Template;


/**
 * Class responsible for the template of view
 *
 */
class MobyTemplate 
{
    /**
     * Should the page for apply the template
     *
     * @var file
     */
	protected $file;
 
    
    /**
     * To instantiate the class must be passed to template view
     *
     * @param file
     * @return void
     */
	public function __construct($file) {
        $this->file = $file;
    }
     
    
    /**
     * Apply the template in pass last view
     *
     * @return template formatado 
     */
	public function output() {
        if (!file_exists($this->file))
            return "Error loading template file ($this->file).<br />";
        
        $output = file_get_contents($this->file);
     
        $output = str_replace(['{{', '}}'], ['<?= ', ' ?>'], $output);
        
        return $output;
    }
}