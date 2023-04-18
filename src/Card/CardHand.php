<?php

namespace App\Card;

use App\Card\CardGraphic;
use App\Card\DeckOfCards;

class CardHand
{
    private $hand = [];

    public function __construct()
    {
        $this->hand = [];
    }

    public function add(CardGraphic $card): void
    {
        $this->hand[] = $card;
    }

    public function draw(int $number, DeckOfCards $deck): void
    { 
        $this->hand = $deck->draw($number);
    }

    public function getNumberCards(): int
    {
        return count($this->hand);
    }

    public function getArray(): array
    {
        $strings = [];
        foreach ($this->hand as $card) {
            $strings[] = $card->getString();
        }
        return $strings;
    }

    public function getString(): string
    {
        return implode('', $this->getArray());
    }
}
