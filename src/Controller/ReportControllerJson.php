<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ReportControllerJson
{
    #[Route("/api/quote", name: "quote")]
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
}
