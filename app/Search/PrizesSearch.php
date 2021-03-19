<?php 

namespace App\Search;

use  Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PrizesSearch extends BaseSearch{

    protected $path = '/prizes';


    public function validation(){
        return Validator::make($this->data,[
            'game' => ['sometimes', function($attributes, $value, $fail){
                if(!in_array($value, array_keys( $this->validGames()) )){
                    $fail('Invalid game selected. Please select a valid game to proceed!');
                }
            }],

            'promotype' => [function($attributes, $value, $fail){
                
                $game = isset( $this->data['game']) ? $this->data['game'] : null;
                $isSkaterORLevelUp = !$game || $game == 'streetskater' || $game == 'levelup' ;
                $isCashmanOrCashdash = $game == 'cashman' || $game == 'cashdash';

                if ($isSkaterORLevelUp && !in_array($value, ['discount40', 'freeshipping'])){
                    $fail('Invalid promo type selected for Street skater or Level-up game');
                }

                if ($isCashmanOrCashdash && !in_array($value, ['Prize10Off', 'Prize50'])){
                    $fail('Invalid promo type selected for  Cash Man or Cash Dash game');
                }                

            }],                
            'offset' => ['sometimes', 'integer', 'min:1'],
            'size' => [Rule::in( array_values( $this->availablePageSizes() ) )],
        ]);
    }



    public function search(){
        $this->data = $this->validation()->validate();

        $this->setPageSize();

        $this->setOffset();

        $this->setDefault();

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
    

    /**
     * Promotype
     */
    public function validPromoTypes(){
        return [
            'discount40' => 'Discount 40',
            'freeshipping'  => 'Discount Freeshipping',
            'Prize10Off' => 'Prize 10-Off',
            'Prize50' => 'Prize 50',
        ];
    }    
        
    protected function setDefault(){
        $this->data['promotype'] = isset($this->data['promotype'] ) ? $this->data['promotype']  : 'discount40';
    }



    public function processPrizesForChart($data){
        $result = [
            'label' => '',
            'dataset' => '',
            'colour' => ''
        ];

        $total = count($data) ;

        foreach($data as $k => $v){
            $name = isset($v['displayName']) ?  $v['displayName'] : '-';
            $score = isset($v['score']) ?  $v['score'] : 0 ;

            $result['label']  .= ($k+1 < $total  ) ? ("'$name . ($score)'," ): ( "'$name.($score)'");

            $result['dataset']  .= ($k+1 < $total  ) ? ($score . ',' ): $score;

            $result['colour']  .= ($k+1 < $total  ) ? ( $this->generateRandomColour() .', ' ): $this->generateRandomColour();
        }
        return $result;
    }


    protected function generateRandomColour(){
        $r = dechex( mt_rand(0, 255) );
        $b = dechex( mt_rand(0, 255) );
        $g = dechex( mt_rand(0, 255) );
        return "'#$r$b$g'";
    }

}

