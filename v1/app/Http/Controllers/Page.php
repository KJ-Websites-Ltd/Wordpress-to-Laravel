<?php

namespace App\Http\Controllers;

use App\Repositories\Menu as menuRepository;
use App\Repositories\Page as pageRepository;
use Illuminate\Http\Request;

class Page extends Posts
{
    
    
    public function __construct(Request $request, pageRepository $pageRepository, menuRepository $menuRepository)
    {
        $this->request        = $request;
        $this->objRepository  = $pageRepository;
        $this->menuRepository = $menuRepository;
        
    }
    
    
}
