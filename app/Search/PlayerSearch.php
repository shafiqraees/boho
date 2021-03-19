<?php

namespace App\Search;

use  Illuminate\Support\Facades\Validator;



class PlayerSearch extends BaseSearch{

    protected $path = '/players';


    public function validation(){
        return Validator::make($this->data,[
            'game' => ['sometimes', function($attributes, $value, $fail){
                if(!in_array($value, array_keys( $this->validGames()) )){
                    $fail('Invalid game selected. Please select a valid game to proceed!');
                }
            }],
            'offset' => ['sometimes', 'integer', 'min:1'],
            'size' => ['sometimes', 'integer', 'min:1', 'max:100'],
        ]);
    }



    public function search(){
        $this->data = $this->validation()->validate();

        $this->setPageSize();

        $this->setOffset();

        return $this->makeRequest($this->data);

    }



    /**
     * Valid games
     */
    public function validGames(){
        return [
            'streetskater' => 'Street Skater',
            'levelup' => 'Level Up',
            'cashman' => 'Cash Man',
            'cashdash' => 'Cash Dash',
        ];
    }




}

