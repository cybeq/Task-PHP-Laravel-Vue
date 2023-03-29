<?php

class Tezaurus
{
    private array $tezaurus;

    public function __construct(array $tezaurus)
    {
        $this->tezaurus = $tezaurus;
    }

    public function getSynonyms($word): string
    {
        $synonyms = $this->tezaurus[$word] ?? [];

        return json_encode([
            'word' => $word,
            'synonyms' => $synonyms,
        ]);
    }
}

$tezaurus = new Tezaurus([
    "sklep" => ["centrum handlowe", "targ"],
    "chudy" => ["szczuply", "koscisty"]
]);

echo $tezaurus->getSynonyms("chudy");