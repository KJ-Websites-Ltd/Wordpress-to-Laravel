<?php

namespace App\Http\Controllers;

use App\Repositories\Menu as menuRepository;
use App\Repositories\Posts as postRepository;
use App\Services\Util;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class Posts extends Base
{
    public $request;
    public $objRepository;
    public $menuRepository;
    
    public function __construct(Request $request, postRepository $postRepository, menuRepository $menuRepository)
    {
        $this->request        = $request;
        $this->objRepository  = $postRepository;
        $this->menuRepository = $menuRepository;
    }
    
    
    /**
     * Return a wp post via slug
     *
     * @param string $slug
     *
     * @return string
     */
    public function single(string $slug)
    {
        
        $className    = class_basename($this);
        $cacheKeyName = $className . '-' . $slug;
        $view         = Util::checkTemplate($slug, $className);
        
        //check the cache to return the post layout array, if not exists then recreate
       $rtn = Cache::get($cacheKeyName, function () use ($slug, $cacheKeyName) {
            
            //get the object single array
            $this->objRepository->single($slug);
            
            //page layout and content
            $data = $this->objRepository->getResult();
            
            //default menus
            $this->menuRepository->multiple([config('app.wpapi_header_menu_id'), config('app.wpapi_footer_menu_id')]);
            $nav = $this->menuRepository->getResult();
            
            //array to store
            $rtn = ['data' => $data, 'nav' => $nav];
            
            //store $rtn in cache
            //Cache::put($cacheKeyName, $rtn, config('app.cache_expire'));
            
            return $rtn;
            
        });
       
        
        
        return view($view, [
            'data' => $rtn['data'],
            'nav'  => $rtn['nav'],
        ]);
        
        
    }
    
    
}
