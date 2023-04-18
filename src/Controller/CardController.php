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
        $data = [
            'title'=>'Card'
        ];

        return $this->render('card/card_home.html.twig', $data);
    }

    #[Route("/card/deck", name: "card_deck")]
    public function deck(): Response
    {
        $deck = new DeckOfCards;
        $data = [
            'title'=>'Card Deck',
            'deck'=>$deck->getString()
        ];

        return $this->render('card/deck.html.twig', $data);
    }

    #[Route("/card/deck/shuffle", name: "card_shuffle")]
    public function shuffle(): Response
    {
        $deck = new DeckOfCards;
        $deck->shuffle();
        $data = [
            'title'=>'Shuffled Card Deck',
            'deck'=>$deck->getString()
        ];

        return $this->render('card/deck.html.twig', $data);
    }

    #[Route("/card/deck/draw", name: "card_draw")]
    public function draw(): Response
    {
        $deck = new DeckOfCards;
        $deck->shuffle();
        $hand = new CardHand;
        $hand->draw(1, $deck);
        $data = [
            'title'=>'Draw Cards',
            'hand'=>$hand->getString(),
            'deck'=>$deck->getString(),
            'count'=>$deck->getNumberCards()
        ];

        return $this->render('card/draw.html.twig', $data);
    }

    #[Route("/card/deck/draw/{num<\d+>}", name: "draw_number")]
    public function drawNumber(int $num): Response
    {
        $deck = new DeckOfCards;
        $deck->shuffle();
        $hand = new CardHand;
        $hand->draw($num, $deck);
        $data = [
            'title'=>'Draw Cards',
            'hand'=>$hand->getString(),
            'deck'=>$deck->getString(),
            'count'=>$deck->getNumberCards()
        ];

        return $this->render('card/draw.html.twig', $data);
    }

    #[Route("/card/deck/deal/{players<\d+>}/{cards<\d+>}", name: "card_deal")]
    public function deal(int $players, int $cards): Response
    {
        $deck = new DeckOfCards;
        $deck->shuffle();

        $hands = [];
        for ($i = 0; $i < $players; $i++) {
            $hand = new CardHand;
            $hand->draw($cards, $deck);
            $hands[] = $hand;
        }

        $data = [
            'title' => 'Deal Cards',
            'hands' => $hands,
            'deck' => $deck->getString(),
            'count' => $deck->getNumberCards(),
        ];

        return $this->render('card/deal.html.twig', $data);
    }

}
