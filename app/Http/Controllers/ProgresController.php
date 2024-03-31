<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Progres;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProgresController extends Controller
{
    // Méthodes de traitement des soumissions de poids
    public function store(Request $request)
    {
        try {
            // Vérifier que l'utilisateur est connecté
            if (!Auth::check()) {
                return back()->with('error', 'Vous devez être connecté pour effectuer cette action.');
            }
            // valider une demande
            $validatedData = $request->validate([
                'poid' => 'required|numeric',  // Assurez-vous que le poids indiqué est un nombre
            ]);
            // Obtenir l'utilisateur actuellement connecté
            $user = Auth::user();

            // Obtenir l'enregistrement client correspondant
            $client = Client::where('client_id', $user->id)->firstOrFail();

            // Créer un nouvel enregistrement de progrès et l'enregistrer dans la base de données
            $progres = new Progres();
            $progres->client_id = $client->id;
            $progres->poids_actuel = $validatedData['poid'];
            $progres->date_de_prise = now();  // Fixer la date actuelle à date_de_prise
            $progres->save();

            return redirect('/compte-client')->with('success', 'Le poids a été ajouté avec succès!');

        } catch (ModelNotFoundException $e) {
            // Gestion de l'exception "enregistrement introuvable" du client
            return back()->with('error', 'Enregistrement client non trouvé.');
        } catch (\Exception $e) {
            // Traitement d'autres exceptions générales
            return back()->with('error', 'Une erreur est survenue: ' . $e->getMessage());
        }
    }
}
