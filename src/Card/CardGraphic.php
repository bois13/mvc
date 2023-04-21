<?php

namespace App\Card;

class CardGraphic extends Card
{
    private const REPRESENTATION = [
        'clubs' => "\xE2\x99\xA3",
        'diamonds' => "\xE2\x99\xA6",
        'hearts' => "\xE2\x99\xA5",
        'spades' => "\xE2\x99\xA0",
    ];

    public function __construct($value, $suit)
    {
        parent::__construct($value, $suit);
    }

    public function getString(): string
    {
        return '[' . $this->value . self::REPRESENTATION[$this->suit] . ']';
    }
}
