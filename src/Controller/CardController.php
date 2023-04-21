<?php

namespace App\Controller;

use App\Card\CardHand;
use App\Card\DeckOfCards;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CardController extends AbstractController
{
    #[Route("/card", name: "card_start")]
    public function card(SessionInterface $session): Response
    {
        self::getSessionDeck($session);
        $data = [
            'title'=>'Card'
        ];

        return $this->render('card/card_home.html.twig', $data);
    }

    #[Route("/card/deck", name: "card_deck")]
    public function deck(SessionInterface $session): Response
    {
        $deck = self::getSessionDeck($session);
        $deck->sort();
        $data = [
            'title'=>'Card Deck',
            'deck'=>$deck->getString(),
            'count'=>$deck->getNumberCards()
        ];

        return $this->render('card/deck.html.twig', $data);
    }

    #[Route("/card/deck/shuffle", name: "card_shuffle")]
    public function shuffle(SessionInterface $session): Response
    {
        $deck = self::getSessionDeck($session);

        if ($deck->getNumberCards() === 0) {
            $session->remove('deck');
            $deck = self::getSessionDeck($session);
        }

        $deck->shuffle();
        $data = [
            'title'=>'Shuffled Card Deck',
            'deck'=>$deck->getString(),
            'count'=>$deck->getNumberCards()
        ];

        return $this->render('card/deck.html.twig', $data);
    }

    #[Route("/card/deck/draw", name: "card_draw")]
    public function draw(SessionInterface $session): Response
    {

        $deck = self::getSessionDeck($session);
        $deck->shuffle();
        $hand = new CardHand();
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
    public function drawNumber(int $num, SessionInterface $session): Response
    {
        $deck = self::getSessionDeck($session);
        $deck->shuffle();
        $hand = new CardHand();
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
    public function deal(int $players, int $cards, SessionInterface $session): Response
    {
        $deck = self::getSessionDeck($session);
        $deck->shuffle();

        $hands = [];
        for ($i = 0; $i < $players; $i++) {
            $hand = new CardHand();
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

    public function getSessionDeck(SessionInterface $session): DeckOfCards
    {
        $deck = $session->get('deck');
        if (!$deck) {
            $deck = new DeckOfCards();
            $session->set('deck', $deck);
        }

        return $deck;
    }
}
