<?php

namespace App\Repositories;


class Menu extends Base
{
    
    const TYPE = 'menus';
    const MULTIPLE_COLUMNS
        = [
            'ID',
            'name',
            'slug',
            'description',
            'count',
        ];
    const SINGLE_COLUMNS = ['items'];
    
    /**
     * Menu constructor.
     * Menus are not enabled by default in the wordpress json api, so a plugin is used https://wordpress.org/plugins/wp-api-menus/
     * The methods here are adapted to fit
     */
    public function __construct()
    {
        
        $this->setType(self::TYPE);
        $this->setEndPoint('wp-api-menus/v2/');
        $this->setMultipleColumns(self::MULTIPLE_COLUMNS);
        $this->setSingleColumns(self::SINGLE_COLUMNS);
        
        parent::__construct();
        
    }
    
    /**
     * Return multiple menu objects either all by default or limited to an id array
     *
     * @param array $idArray
     */
    public function multiple(array $idArray = []): void
    {
     
        if (empty($idArray)) {
            parent::multiple($idArray);
        } else {
            
            $res = [];
            foreach ($idArray as $id) {
                
                $this->single($id);
                $menu               = $this->getResult();
                if (isset($menu['slug'])) {
                    $res[$menu['slug']] = $menu;
                }
                
            }
            
            $this->setResult($res);
            
        }
        
        
    }
    
    /**
     * The menues returned are a taxonomy, so they need to be adapted to pass through the base cleanSingle method reliably
     *
     * @param string $slug
     * @param string $column
     */
    public function single(string $slug, string $column = null): void
    {
        
        $query    = $this->getType() . '/' . $slug;
        $response = $this->getClient()->request('GET', $query);
        //as the cleanSingle expects a parent array, decode the response, then encode it back up with a wrapping array
        $response = json_decode($response->getBody(), true);
        //wrapping array
        $response = json_encode([$response]);
        $response = $this->cleanSingle($response);
        
        $this->setResult($response);
        
    }
    
    
}


