<?php

namespace App\Card;

use App\Card\CardGraphic;

class DeckOfCards
{
    private $deck = [];

    private const SUITS = [
        'clubs',
        'diamonds',
        'hearts',
        'spades',
    ];

    private const VALUES = [2, 3, 4, 5, 6, 7, 8, 9, 10, 'J', 'Q', 'K', 'A'];

    public function __construct()
    {
        // $this->deck = [];

        foreach (self::SUITS as $suit) {
            foreach (self::VALUES as $value) {
                $this->deck[] = new CardGraphic($value, $suit);
            }
        }
    }

    public function sort(): void
    {
        usort($this->deck, function($a, $b) {
            if ($a->getSuit() == $b->getSuit()) {
                return array_search($a->getValue(), self::VALUES) - array_search($b->getValue(), self::VALUES);
            } else {
                return array_search($a->getSuit(), self::SUITS) - array_search($b->getSuit(), self::SUITS);
            }
        });
    }

    public function add($value, $suit): void
    {
        $this->deck[] = new CardGraphic($value, $suit);
    }

    public function shuffle(): void
    {
        shuffle($this->deck);
    }

    public function getNumberCards(): int
    {
        return count($this->deck);
    }

    public function draw(int $num=1): array
    {
        $cards = [];
        for ($i=0; $i < $num; $i++) { 
            $cards[] = array_shift($this->deck);
        }
        return $cards;
    }

    public function getArray(): array
    {
        $strings = [];
        foreach ($this->deck as $card) {
            $strings[] = $card->getString();
        }
        return $strings;
    }

    public function getString(): string
    {
        return implode('', $this->getArray());
    }
}

