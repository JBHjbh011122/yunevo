<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;
use App\Models\Progres;
use App\Models\Photo;
use App\Models\User;
use App\Models\Commande;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    /**
     * La page Comptes clients est affichée
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user(); // Obtenir l'utilisateur actuellement connecté
        if (!$user) {
            return redirect('login')->with('error', 'Vous devez être connecté pour ajouter une vidéo.');
        }
        $client = $user->client;
        if (!$client) {
            return redirect()->back()->with('error', 'Utilisateur non associé à un client.');
        }
        $clientId = $client->id;

        if ($user) {
            session(['prenom' => $user->prenom]);
            session(['nom' => $user->nom]);

            $client = Client::where('client_id', $user->id)->first();
            $latestProgres = null;

            if ($client) {

                // Obtenir les dernières mises à jour des utilisateurs sur leurs progrès
                $latestProgres = Progres::where('client_id', $client->id)->orderBy('created_at', 'desc')->first();

                // Demande de renseignements sur les deux dernières images
                $latestPhotos = Photo::where('client_id', $client->id)
                ->orderBy('created_at', 'desc')
                ->take(2)
                ->get();

                // Obtenir respectivement l'image la plus récente et la deuxième image la plus récente, si elles existent.
                $latestPhoto = $latestPhotos->first();
                $secondLatestPhoto = $latestPhotos->skip(1)->first();
                // Obtenir une valeur spécifique
                $taille = $client->taille;
                $poidsDepart = $client->poids_depart;
                $poidsSouhaite = $client->poids_souhait;
                $poidsActuel = $latestProgres ? $latestProgres->poids_actuel : null;

                $taille2 = $client->taille / 100;
                $latestWeightRecord = Progres::where('client_id', $client->id)
                ->orderBy('date_de_prise', 'desc')
                ->first();
                $poids = $latestWeightRecord ? $latestWeightRecord->poids_actuel : null;

                $imc=null;
                $signification = null;
                if ($taille2 > 0 && $poids) {
                    $imc = $poids / ($taille2 * $taille2);
                }

                // Déterminer l'état de santé à partir de l'IMC
                if ($imc < 18.5) {
                    $signification = "Poids insuffisant";
                } elseif ($imc <= 25) {
                    $signification = "Poids santé";
                } elseif ($imc <= 30) {
                    $signification = "Léger excès de poids";
                } else {
                    $signification = "Obésité";
                }
                // Obtenir tous les rapports d'avancement pertinents, triés par date
                $progressRecords = Progres::where('client_id', $client->id)
                                          ->orderBy('date_de_prise', 'asc')
                                          ->get();
                $weights = ['Start' => $poidsDepart];
                // Ajouter d'autres enregistrements de poids au tableau
                foreach ($progressRecords as $record) {
                    $date = Carbon::parse($record->date_de_prise); // Utiliser Carbon pour analyser les dates
                    $weights[$date->format('Y-m-d')] = $record->poids_actuel;
                }
                // Ajouter le poids cible comme dernier élément
                    $weights['Target'] = $poidsSouhaite;
            }
            // Transmettre ces valeurs à la vue
            return view('yunevo.compte-client', compact('user', "client",'taille', 'poidsDepart',
                        'poidsSouhaite', 'poidsActuel','latestPhoto', 'secondLatestPhoto','weights',
                        'imc','signification'));
        } else {
            // Redirection vers la page de connexion si l'utilisateur n'est pas connecté
            return redirect('index');
        }
    }

    public function showUpdateForm($client_id)
    {
        $user = Auth::user();
        $client = Client::find($client_id);

        if (!$client) {
            abort(404);
        }
        return view('yunevo.form-client-compte-modifier', compact('user','client'));
    }

    public function destroy($id)
    {
    $user = User::findOrFail($id); // Obtenir l'utilisateur connecté actuel

    if ($user) {
        DB::beginTransaction(); // Début de transaction
        try {
            // Vérifiez si l'utilisateur est associé à un client
            $client = Client::where('client_id', $user->id)->first();

            if ($client) {
                $clientId = $client->id;

                // Supprimer les enregistrements associés dans les tables photos, progres, et commandes
                Photo::where('client_id', $clientId)->delete();
                Progres::where('client_id', $clientId)->delete();
                Commande::where('client_id', $clientId)->delete();

                // Supprimer l'enregistrement dans la table clients
                $client->delete();
            }
            // Suppression définitive du compte utilisateur
            $user->delete();

            DB::commit(); // Soumission des transactions

            // L'utilisateur a été supprimé, redirigé vers la page de connexion
            return redirect('/')->with('status', 'Votre compte a été supprimé avec succès.');
            } catch (\Exception $e) {
                DB::rollback(); // Annulation des transactions

                // Redirige vers la page du compte et affiche un message d'erreur
                return redirect()->back()->with('error', 'Une erreur est survenue lors de la suppression du compte.');
            }
        } else {
            // L'utilisateur n'est pas connecté, rediriger vers la page de connexion
            return redirect('/');
        }
    }
}


