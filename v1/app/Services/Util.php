<?php

namespace App\Services;

use Illuminate\Support\Facades\View;

class Util
{
    
    
    /**
     * Check to see if a template exists for a given slug, if not use the controller classname and default index which must exist
     *
     * @param string $slug
     *
     * @return string|null
     */
    public static function checkTemplate(string $slug, string $classname)
    {
        
        $rtn = null;
        if (View::exists($slug)) {
            $rtn = slug;
        } else {
            $rtn = strtolower($classname) . '.index';
        }
        
        return $rtn;
        
    }
    
    /**
     * Return a get paramter string formatted in the correct way to pull in multiple items based on the ids provided by the input array
     *
     * @param array $idArray
     *
     * @return string
     */
    public static function getIncludeParamaterString(array $idArray)
    {
        
        $rtn = '';
        if ( ! empty($idArray)) {
            foreach ($idArray as $id) {
                $rtn .= '&include[]=' . $id;
            }
        }
        
        return $rtn;
        
    }
    
    
}
