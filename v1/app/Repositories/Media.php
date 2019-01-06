<?php

namespace App\Repositories;


class Media extends Base
{
    
    const TYPE = 'media';
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
        ];
    const SINGLE_COLUMNS = ['content', 'links', 'acf'];
    
    public function __construct()
    {
        parent::__construct();
        $this->setType(self::TYPE);
        $this->setMultipleColumns(self::MULTIPLE_COLUMNS);
        $this->setSingleColumns(self::SINGLE_COLUMNS);
        
    }
    
}
