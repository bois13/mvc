<?php

namespace App\Card;

class Card
{
    protected $value;
    protected $suit;
    protected const RANK = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 'J', 'Q', 'K', 'A'];

    public function __construct($value = null, $suit = null)
    {
        $this->value = $value;
        $this->suit = $suit;
    }

    public function getValue() {
        return $this->value;
    }

    public function getRank() {
        return array_search($this->value, self::RANK) + 1;
    }

    public function getSuit() {
        return $this->suit;
    }

    public function getString(): string
    {
        return '[' . $this->value . ' of ' . $this->suit . ']';
    }
}
