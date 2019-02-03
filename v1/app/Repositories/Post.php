<?php

namespace App\Repositories;


class Post extends Base
{
    
    const TYPE = 'post';
    const MULTIPLE_COLUMNS
        = [
            'id',
            'date_gmt',
            'guid',
            'modified_gmt',
            'slug',
            'status',
            'title',
            'link',
            'excerpt',
            '_embedded',
            'wp_headless_gutenberg_data'
        ];
    const SINGLE_COLUMNS = ['content', 'links', 'acf'];
    
    
    public function __construct()
    {
    
        $this->setType(self::TYPE);
        $this->setMultipleColumns(self::MULTIPLE_COLUMNS);
        $this->setSingleColumns(self::SINGLE_COLUMNS);
    
        parent::__construct();
        
    }
    
    
    /**
     * Post specific clean data
     *
     * @param $data
     * @param $columns
     *
     * @return array
     */
    public function cleanData($data, $columns)
    {
        $rtn = parent::cleanData($data, $columns);
    
        if ( ! empty($rtn)) {
            foreach ($rtn as $k => $v) {
                if ($k === '_embedded') {
                    $rtn[$k] = $this->getEmbeddedMedia($v);
                }
            }
        }
        
        
        return $rtn;
        
    }
    
    /**
     * Return a posts embeded media (different sized images for example provided by wp)
     *
     * @param $data
     *
     * @return array
     */
    public function getEmbeddedMedia($data)
    {
        
        $images = [];
        
        if ( ! empty($data['wp:featuredmedia'][0]['media_details']['sizes'])) {
            $images = $data['wp:featuredmedia'][0]['media_details']['sizes'];
        }
        
        return ['images' => $images];
        
        
    }
    
    
}
