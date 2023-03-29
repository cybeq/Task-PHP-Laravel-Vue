<?php

class RankingTable
{
    private array $rank;
    public function __construct(array $names){
        $this->rank = [];
        foreach($names as $name){
            $this->rank["players"][$name] = array("score"=>0, "turn"=>0);
        }
    }
    public function recordResult(string $name, int $score):void{
        if(empty($this->rank["players"][$name])) {
            echo "<br/>" . json_encode(["error" => $name . " chyba nie gra w tym zespole"]) . "<br/>";
            return;
        }
        $this->rank["players"][$name]["score"]+=$score;
        $this->rank["players"][$name]["turn"]+=1;
    }
    public function getEachPlayers():string{
        return json_encode($this->rank["players"]);
    }

    public function playerRank(int $rankPosition):string{
        uasort($this->rank["players"], function ($a, $b) {
            if ($a['score'] != $b['score']) {
                return $b['score'] - $a['score'];
            } else {
                return $b['turn'] - $a['turn'];
            }
        });
        $player = array_values($this->rank["players"])[$rankPosition-1];
        if($player === null ) {
            return json_encode(["error" => "Nikt nie ma tej pozycji w rankingu"]);
        }
        return json_encode(["Gracz na pozycji ".$rankPosition=>array_keys($this->rank["players"], $player)[0]]);
    }

}
$t =  new RankingTable(["marian", "kasia","janek", "bartek"]);
$t->recordResult("marian", 4);
$t->recordResult("kasia", 0);
$t->recordResult("kasia", 4);
echo $t->playerRank(1);

