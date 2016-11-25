<?php

namespace View;

use Response\Response;
use View\Exception\ViewException;

/**
 * Class View responsible for create template 
 */
class View
{
    /**
     * View name
     * @var string
     */
    private $view;
    
    /**
     * Params for to pass view
     * @var array
     */
    private $param = [];
    
    /**
     * Condition array for replace in template
     * @var array
     */
    private $replace_cond = [
        '{{', '}}', 
        '@if', '@endif', 
        '@foreach', '@endforeach', 
        '@for', '@endfor',
        ')@'
    ];
    
    /**
     * Valeus array for replace in template
     * @var array
     */
    private $replace_value = [
        '<?= ', ' ?>', 
        '<?php if', '<?php endif; ?>', 
        '<?php foreach', '<?php endforeach; ?>', 
        '<?php for', '<?php endfor; ?>',
        '): ?>'
    ];
    
    
    /**
     * Construct the class responsible for exchange
     * 
     * @paran string $view
     * @paran array $param
     * @return void
     */
    public function __construct($view, $param)
    {
        $this->param = $param;
        $this->view = $view;
    }
    
    
    /**
     * 
     * 
     * @return object Response
     */
    public function initialize()
    {
        $viewNewName = $this->randomNameView();
        
        try {
            if (!$view = $this->getView($this->view))
                throw new ViewException("View [{$this->view}] does not exists", 10);
            
            $this->writeTemplate($viewNewName, $view);
            
            $this->includeView($viewNewName);
            
            $this->deleteTemplate($viewNewName);
            
        } catch (ViewException $e) {
            $e->render('default-error', $e);
        }
        
        return new Response('view');
    }
    
    
    /**
     * Create random name for the new view
     * 
     * @return string
     */
    public function randomNameView()
    {
        return rand(0, 9999999999);
    }
    
    
    /**
     * Get the view passed for the user
     * 
     * @return bool OR file
     */
    public function getView()
    {
        if (!file_exists(__DIR__ . '/../../../App/Views/'. $this->view . '.php'))
            return false;
            
        return file_get_contents(__DIR__ . '/../../../App/Views/'. $this->view . '.php');
    }
    
    
    /**
     * Get the template created for view
     * 
     * @param string $viewName
     * @return file
     */
    public function getTemplate($viewName)
    {
        return fopen(__DIR__ . '/../../../storage/views/' . $viewName . '.php', 'w');
    }
    
    
    /**
     * Write the replace in the template
     * 
     * @param string $viewName
     * @return bool
     */
    public function writeTemplate($viewName, $view)
    {
        $template =  $this->getTemplate($viewName);
        
        $view = str_replace($this->replace_cond, $this->replace_value, $view);
        
        fwrite($template, $view);
        return fclose($template);
    }
    
    
    /**
     * Include the new view created by template
     * 
     * @param string $template
     * @return void
     */
    public function includeView($template)
    {
        if ($this->param)
            extract($this->param);
        
        include_once(__DIR__ . '/../../../storage/views/' . $template . '.php');
    }
    
    
    /**
     * Delete the template created now
     * 
     * @return bool
     */
    public function deleteTemplate($viewNewName)
    {
        if (!file_exists(__DIR__ . '/../../../storage/views/' . $viewNewName . '.php'))
            return false;
        
        return unlink(__DIR__ . '/../../../storage/views/' . $viewNewName . '.php');
    }
    
    
    /**
     * Clear params the class
     * 
     * @return void
     */
    public function clearParams()
    {
        $this->view  = '';
        $this->param = [];
    }
}