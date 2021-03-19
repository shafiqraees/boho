<?php 

namespace App\Search;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class BaseSearch{

    protected $data = [];
    protected $url;
    protected $path;
    protected $key;

    protected $default_size = 20;
    protected $default_offset = 1;



    public function __construct($data){
        $this->data = $data;

        $this->url = env('AWS_API_URL', '');
        $this->key = env('AWS_API_KEY', '');

        $this->url .= $this->path;
    }



    /**
     * Page Size
     */
    public function availablePageSizes(){
        return [
            '20' => 20,
            '30' => 30,
            '50' => 50,
            '100' => 100
        ];        

    }

    /**
     * Calculates previous page
     */
    public function prviousPage(){
        if(!isset($this->data['offset'] )  || $this->data['offset'] == 1){
            return null;
        }
        $path = request()->path();

        $data = $this->data;

        $data['offset'] -= 1;

        return $path .'?'. http_build_query($data );
    }   
     

    /**
     * Calculates next page
     */
    public function nextPage($totalReturnedSize){

        if($totalReturnedSize < $this->data['size'] ){
            return null;
        }
        
        $path = request()->path();

        $data = $this->data;

        $data['offset'] += 1;

        return $path .'?'. http_build_query($data );
    }  
    
    public function getOffset(){
        return $this->data['offset']  ;
    }    

    public function getPageSize(){
        return $this->data['size']  ;
    }

    public function pageDiff(){
        return ( $this->getPageSize() * $this->getOffset() ) - $this->getPageSize();
    }

    /**
     * Set page size or default
     */
    protected function setPageSize(){
        $this->data['size'] = isset($this->data['size'] ) ? (int)$this->data['size']  : $this->default_size;    
    }




    /**
     * Set page size or default
     */
    protected function setOffset(){
        $this->data['offset'] = isset($this->data['offset'] ) ? (int)$this->data['offset'] : $this->default_offset;  
    }






    /**
     * Headers
     */
    protected function headers(){
        return [
            'X-API-KEY: ' . $this->key,
            'Content-Type: application/json',
        ];
    }

    /**
     * Make Request
     */
    protected function makeRequest($queryArray){

        try{

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode( array_filter($queryArray,'strlen') ));
        

            curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers());        

            $result = curl_exec($ch);

            

            if (curl_errno($ch)) {
                throw new \Exception('Error: ' . curl_error($ch));
            }

            curl_close($ch);
            
            return $result ;

        }catch(\Exception $e){
            Log::error($e->getMessage(), ['error' => $e]);
            Session::flash('err_message', 'OOPs! We cannot provide you with what you want now. Please, try again later or contact us if error persists.'); 
            Session::flash('alert-class', 'alert-danger');             
            return [];
        }
    }


}

