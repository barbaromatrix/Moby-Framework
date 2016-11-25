<?php

namespace App\Models;

use Model\Model;

class [#class#] extends Model
{
    protected $timestemp = true;
    protected $table = '[#table#]';
    protected $primary_key = '[#primary_key#]';
    protected $fields = [
        [#fields#]
    ];
    
    
    public function insert[#class#]($dados)
    {
        return [#class#]::create([
            [#fields_value#] 
        ]);
    }
    
    
    public function getAll[#class#]()
    {
        return [#class#]::all();
    }
    
    
    public function delete[#class#]($[#primary_key#])
    {
        if (!is_numeric((int)$[#primary_key#]))
            return false;
            
        $result = [#class#]::where('[#primary_key#]', $[#primary_key#])->get()->first();
        
        if (!$result)
            return false;
            
        return $result->delete();
    }
    
    
    public function get[#class#]Specific($[#primary_key#])
    {
        if (!is_numeric((int)$[#primary_key#]))
            return false;
            
        $result = [#class#]::find($[#primary_key#]);
        
        if (!$result)
            return false;
            
        return $result[0];
    }
    
    
    public function all[#class#]Selected($[#primary_key#]s)
    {
        $result = [#class#]::all();
        
        if ($result)
            foreach ($result as $key => $value) {
                if ($value[$key]->[#primary_key#] == $[#primary_key#]->[#primary_key#])
                    $value[$key]->selected = 'selected';
                else
                    $value[$key]->selected = '';
            }
            
        return $result;
    }
    
    
    public function update[#class#]($dados)
    {
        $result = [#class#]::find($dados['[#primary_key#]']);
        
        if (!$result)
            return false;
            
        foreach ($this->fields as $field) {
            foreach ($dados as $key => $value) {
                if ($key == $field)
                    $result->$field = $dados[$key];
            }
        }
        
        return $result->save();
    }
}