<?php

namespace App\Controller;

use App\Card\CardHand;
use App\Card\DeckOfCards;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ReportControllerJson extends AbstractController
{
    #[Route("/api", name: "api")]
    public function api(SessionInterface $session): Response
    {
        $data = [
            'title'=>'API',
        ];

        return $this->render('api.html.twig', $data);
    }

    #[Route("/api/quote", name: "quote", methods: ['GET'])]
    public function jsonQuote(): Response
    {
        $jsonFile = 'data/quotes.json';
        $jsonString = file_get_contents($jsonFile);
        $jsonData = json_decode($jsonString, true);
        $randomIndex = array_rand($jsonData);
        $randomQuote = $jsonData[$randomIndex];

        $data = [
            'quote' => $randomQuote['quote'],
            'author' => $randomQuote['author'],
            'date' => date('Y-m-d'),
            'timestamp' => time()
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/deck", name: "json_deck", methods: ['GET'])]
    public function json_jsonDeck(SessionInterface $session): Response
    {
        $deck = self::getSessionDeck($session);
        $deck->sort();
        $data = [
            'deck'=>$deck->getString(),
            'count'=>$deck->getNumberCards()
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/deck/shuffle", name: "json_card_shuffle", methods: ['POST'])]
    public function json_shuffle(SessionInterface $session): Response
    {

        $deck = self::getSessionDeck($session);

        if ($deck->getNumberCards() === 0) {
            $session->remove('deck');
            $deck = self::getSessionDeck($session);
        }

        $deck->shuffle();

        $data = [
            'deck'=>$deck->getString(),
            'count'=>$deck->getNumberCards()
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/deck/draw", name: "json_card_draw", methods: ['POST'])]
    public function json_draw(SessionInterface $session): Response
    {

        $deck = self::getSessionDeck($session);
        $deck->shuffle();
        $hand = new CardHand;
        $hand->draw(1, $deck);
        $data = [
            'hand'=>$hand->getString(),
            'deck'=>$deck->getString(),
            'count'=>$deck->getNumberCards()
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/deck/draw/{num<\d+>}", name: "json_draw_number", methods: ['POST'])]
    public function json_drawNumber(int $num, SessionInterface $session): Response
    {
        $deck = self::getSessionDeck($session);
        $deck->shuffle();
        $hand = new CardHand;
        $hand->draw($num, $deck);
        $data = [
            'hand'=>$hand->getString(),
            'deck'=>$deck->getString(),
            'count'=>$deck->getNumberCards()
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/deck/deal/{players<\d+>}/{cards<\d+>}", name: "json_card_deal", methods: ['POST'])]
    public function json_card_deal(int $players, int $cards, SessionInterface $session): Response
    {
        $deck = self::getSessionDeck($session);
        $deck->shuffle();

        $data = [];
        for ($i = 1; $i <= $players; $i++) {
            $hand = new CardHand;
            $hand->draw($cards, $deck);
            $data["player{$i}"] = $hand->getString();
        }


        $data['deck'] = $deck->getString();
        $data['count'] = $deck->getNumberCards();

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    public function getSessionDeck(SessionInterface $session): DeckOfCards
    {
        $deck = $session->get('deck');
        if (!$deck) {
            $deck = new DeckOfCards;
            $session->set('deck', $deck);
        }

        return $deck;
    }
}
