<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\CardGraphic;
use App\Card\CardHand;
use App\Card\DeckOfCards;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CardController extends AbstractController
{
    #[Route("/card", name: "card_start")]
    public function card(): Response
    {
        $data = [];

        return $this->render('card/card_home.html.twig', $data);
    }

    #[Route("/card/deck", name: "card_deck")]
    public function deck(): Response
    {
        $data = [];

        return $this->render('card/deck.html.twig', $data);
    }

    #[Route("/card/deck/shuffle", name: "card_shuffle")]
    public function shuffle(): Response
    {
        $data = [];

        return $this->render('card/deck.html.twig', $data);
    }

    #[Route("/card/deck/draw", name: "card_draw")]
    public function draw(): Response
    {
        $data = [];

        return $this->render('card/deck.html.twig', $data);
    }

    #[Route("/card/deck/draw/{num<\d+>}", name: "draw_number")]
    public function drawNumber(int $num): Response
    {
        $data = [];

        return $this->render('card/dicehand.html.twig', $data);
    }

    #[Route("/card/deck/deal/{players<\d+>}/{cards<\d+>}", name: "card_deal")]
    public function deal(int $players, int $cards): Response
    {
        $data = [];

        return $this->render('card/dicehand.html.twig', $data);
    }

}
