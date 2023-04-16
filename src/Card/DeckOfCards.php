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

    private const VALUES = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 'J', 'Q', 'K', 'A'];

    public function __construct()
    {
        $this->deck = [];

        foreach (self::SUITS as $suit) {
            foreach (self::VALUES as $value) {
                $this->deck[] = new CardGraphic($value, $suit);
            }
        }
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

    public function draw(): CardGraphic
    {
        return array_shift($this->deck);
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

