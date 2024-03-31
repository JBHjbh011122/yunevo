<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Google\Auth\ApplicationDefaultCredentials;

class DialogflowController extends Controller
{
    public function sendMessage(Request $request)
    {
        $message = $request->input('message');
        // Appeler l'API Dialogflow
        $responseText = $this->sendMessageToDialogflow($message);

        // Renvoie la réponse au front-end
        return response()->json(['reply' => $responseText]);
    }

    public function sendMessageToDialogflow($message)
    {
        $projectId = 'yunevo';
        $languageCode = 'fr';
        $sessionId = "yunevo777";

        $url = "https://dialogflow.googleapis.com/v2/projects/{$projectId}/agent/sessions/{$sessionId}:detectIntent";

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->getAccessToken(),
                'Content-Type' => 'application/json',
            ])->post($url, [
                'queryInput' => [
                    'text' => [
                        'text' => $message,  // Le message à envoyer à Dialogflow
                        'languageCode' => $languageCode,  // Le code de langue pour la requête
                    ],
                ],
            ]);

            // Traiter la réponse de Dialogflow
            if ($response->successful()) {
                $responseBody = $response->json();
                return $responseBody['queryResult']['fulfillmentText'];  // Traiter la réponse de Dialogflow
            } else {
                 // Gérer le cas d'une requête non réussie
                return "Error: Unable to process the request. Status code: " . $response->status();
            }
        } catch (\Exception $e) {
             // Gérer les exceptions lors de l'envoi de la requête
            return "Error: Exception occurred while sending message to Dialogflow.";
        }
    }

    protected function getAccessToken()
    {
        // Définir les scopes nécessaires pour l'accès à l'API
        $scopes = ['https://www.googleapis.com/auth/cloud-platform', 'https://www.googleapis.com/auth/dialogflow'];
        // Obtenir les credentials par défaut de l'application
        $credentials = ApplicationDefaultCredentials::getCredentials($scopes);
        // Obtenir le token d'accès
        $authHttpHandler = \Google\Auth\HttpHandler\HttpHandlerFactory::build();
        $authToken = $credentials->fetchAuthToken($authHttpHandler);
        return $authToken['access_token'];  // Retourner le token d'accès
    }
}
