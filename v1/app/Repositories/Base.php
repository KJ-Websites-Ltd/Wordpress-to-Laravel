<?php /** @noinspection ProblematicWhitespace */

namespace App\Repositories;

use App\Services\Util;
use GuzzleHttp\Client;


class Base
{
    
    const TYPE = '';
    
    private $type;
    private $endPoint;
    private $client;
    private $result;
    private $multipleColumns;
    private $singleColumns;
    
    
    /**
     * Base constructor.
     */
    public function __construct()
    {
        $this->setClient();
    }
    
    
    public function getClient()
    {
        return $this->client;
    }
    
    /**
     * set the guzzle client with the required base_uri
     */
    public function setClient(): void
    {
        $this->client = new Client([
            'base_uri' => config('app.wpapi') . $this->getEndPoint(),
        ]);
    }
    
    /**
     * Return a single wordpress object
     *
     * @param string $slug
     */
    public function single(string $slug, string $column = 'slug'): void
    {
        
        $query    = $this->getType() . '?' . $column . '=' . $slug . '&_embed';
        $response = $this->client->request('GET', $query);
        $response = $this->cleanSingle($response->getBody());
        
        
        
        $this->setResult($response);
        
        
    }
    
    /**
     * Return multiple wordpress objects
     *
     * @param array $idArray
     */
    public function multiple(array $idArray = []): void
    {
        
        $query = $this->getType();
        $param = '?_embed';
        if ( ! empty($idArray)) {
            $param = $param . Util::getIncludeParamaterString($idArray);
        }
        $response = $this->client->request('GET', $query . $param);
        $response = $this->cleanMultiple($response->getBody());
        
        $this->setResult($response);
        
    }
    
    
    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }
    
    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }
    
    /**
     * Only return the columns from the api response that are required for this object
     *
     * @param object $data
     *
     * @return array $data
     */
    public function cleanMultiple($data)
    {
        
        $rtn     = [];
        $data    = json_decode($data, true);
        $columns = $this->getMultipleColumns();
        foreach ($data as $i => $d) {
            $data[$i] = $this->cleanData($d, $columns);
        }
        
        return $data;
    }
    
    /*
     * Only return the columns from the api response that are required for this object
     */
    public function cleanSingle($data)
    {
        
        $data    = json_decode($data, true);
        $columns = array_merge($this->getMultipleColumns(), $this->getSingleColumns());
        $rtn     = $this->cleanData(current($data), $columns);
        
        return $rtn;
        
    }
    
    /**
     * abstract to clean data for each wp items
     *
     * @param $data
     * @param $columns
     *
     * @return array
     */
    public function cleanData($data, $columns)
    {
        $rtn = null;
        
        if (is_array($data)) {
            $rtn = array_only($data, $columns);
            foreach ($rtn as $k => $v) {
                if (is_array($v) && isset($v['rendered'])) {
                    $rtn[$k] = $v['rendered'];
                }
            }
        }
        
        
        return $rtn;
    }
    
    /**
     * @return mixed
     */
    public function getMultipleColumns()
    {
        return $this->multipleColumns;
    }
    
    /**
     * @param mixed $multipleColumns
     */
    public function setMultipleColumns($multipleColumns): void
    {
        $this->multipleColumns = $multipleColumns;
    }
    
    
    /**
     * @return mixed
     */
    public function getSingleColumns()
    {
        return $this->singleColumns;
    }
    
    /**
     * @param mixed $singleColumns
     */
    public function setSingleColumns($singleColumns): void
    {
        $this->singleColumns = $singleColumns;
    }
    
    
    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }
    
    /**
     * @param mixed $result
     */
    public function setResult($result): void
    {
        $this->result = $result;
    }
    
    /**
     * @return string
     */
    public function getEndPoint(): string
    {
        if (empty($this->endPoint)) {
            $this->setEndPoint('wp/v2/');
        }
        
        return $this->endPoint;
    }
    
    /**
     * @param string $endPoint
     */
    public function setEndPoint(string $endPoint): void
    {
        $this->endPoint = $endPoint;
    }
    
    
}
