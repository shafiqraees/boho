<?php 

namespace App\Search;

use  Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class StatSearch extends BaseSearch{

    protected $path = '/stats';
    protected $default_event = 'userinfo';
    


    public function validation(){
        return Validator::make($this->data,[
            'game' => [function($attributes, $value, $fail){
                if(!in_array($value, array_keys( $this->validGames()) )){
                    $fail('Invalid game selected. Please select a valid game to proceed!');
                }
            }],

            'event' => [function($attributes, $value, $fail){
                if(!in_array($value, array_keys( $this->eventTypes()) )){
                    $fail('Invalid event type selected! Please select valid event type to proceed');
                }
            }],

            'filtertype' => ['nullable', function($attributes, $value, $fail){
                if(!in_array($value, array_keys( $this->eventFilterTypes()) )){
                    $fail('Invalid event filter type selected. Please select a valid filter type to proceed!');
                }
            }],
            'filtervalue' => ['nullable', 'required_with:filtertype', 'integer', 'min:1'],
            'starttime' => ['nullable', 'date_format:Y-m-d H:i'],
            'endtime' => ['nullable','date_format:Y-m-d H:i'],     
        ]);
    }



    public function search(){

        $this->data = $this->validation()->validate();
        $this->setDefault();
        //Get time and convert to miliseconds
        $start_date_time = strtotime( $this->data['starttime']) * 1000; 
        $end_date_time = strtotime($this->data['endtime']) * 1000;

        $data = array_merge($this->data, [
            'starttime' => $start_date_time ,
            'endtime' => $end_date_time
        ]);

        return $this->makeRequest($data );
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
    

    /**
     * Filetr Type
     */
    public function eventTypes(){
        return [
            'gamelaunch'  => 'Game Launch',
            'startgame' => 'Start Game',
            'endGame' => 'End Game',
            'outfitchange' => 'Outfit Change',            
            'userinfo' => 'User Info',            
        ];
    }  
    
    /**
     * Filetr Type
     */
    public function eventFilterTypes(){
        return [
            'level' => 'Level',
            'avatar'  => 'Avatar',
            'outfit' => 'Outfit',
            'skate' => 'Skate',
        ];
    }     
        
    /**
     * Set Default values when no value is selected from form
     */
    protected function setDefault(){
        $this->data['event'] = isset($this->data['event'] ) ? $this->data['event']  : $this->default_event;  
        
        $this->data['starttime'] = !empty($this->data['starttime'] ) ? $this->data['starttime'] : $this->getDefaultStartTime(); 
        $this->data['endtime'] = !empty($this->data['endtime']) ? $this->data['endtime'] : $this->getDefaultEndTime(); 
    }

    /**
     * Get default time if no time is selected
     */
    protected function getDefaultStartTime(){
        return date('Y-m-d H:i' , strtotime('- 30days')) ;
    }

    public function getStartTime(){
        return  $this->data['starttime'];
    }


    /**
     * Get default end time if no time is selected
     */
    protected function getDefaultEndTime(){
        return date('Y-m-d H:i') ;
    }

    public function getEndTime(){
        return  $this->data['endtime'];
    }    

}

