<?php

namespace App\Card;


class CardGraphic extends Card {
    private $representation = [
        'clubs' => '&clubs;',
        'diamonds' => '&diams;',
        'hearts' => '&hearts;',
        'spades' => '&spades;',
    ];

    public function __construct($value, $suit)
    {
        parent::__construct($value, $suit);
    }

    public function getString(): string
    {
        return '[' . $this->value . $this->representation[$this->suit] . ']';
    }
}

