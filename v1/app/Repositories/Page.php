<?php

namespace App\Repositories;


class Page extends Posts
{
    
    const TYPE = 'pages';
    
    
    public function __construct()
    {
        parent::__construct();
        $this->setType(self::TYPE);
    
    
    }
    
    
}
