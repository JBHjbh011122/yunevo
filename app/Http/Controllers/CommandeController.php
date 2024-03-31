<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Entraineur;
use App\Models\Client;
use App\Models\Commande;
use Illuminate\Http\Request;
use App\Models\Video;
use Illuminate\Support\Facades\Log;


class CommandeController extends Controller
{
    public function showVideos($clientId, $trainerId)
    {
    $user = Auth::user(); // Obtenir l'utilisateur actuel
        if (!$user) {
            return redirect('login')->with('error', 'Vous devez être connecté pour ajouter une vidéo.');
        }
         // Obtenir les formateurs associés à l'utilisateurID
        $entraineur = $user->entraineur; // Disons que vous avez une configuration d'association comme celle-ci
        if (!$entraineur) {
            return redirect()->back()->with('error', 'Utilisateur non associé à un entraineur.');
        }
        $entraineurId = $entraineur->id;

        if ($user) {
            $entraineur = Entraineur::where('entraineur_id', $user->id)->first();

            if ($entraineur) {
                 // Recevons uniquement des vidéos Privees pour ce Entraineur
                $videosPrivees = Video::where('entraineur_id', $entraineurId)
                    ->where('est_public', 0) // 0 Vidéos Privees
                    ->orderBy('created_at', 'desc')
                    ->get();

                 return view('yunevo.videos-commande', compact('videosPrivees', 'trainerId', 'clientId'));
            } else {
                return back()->with('error', 'Vous n\'êtes pas un entraîneur.');
            }
        } else {
            return redirect('login');
        }
    }

    public function createCommande($clientId, $trainerId, $videoId) 
    {
        // obtenons la date d'aujourd'hui
        $today = now()->toDateString();

        // Créer une nouvelle Commande
        $commande = new Commande([
            'client_id' => $clientId,
            'entraineur_id' => $trainerId,
            'video_id' => $videoId,
            'date_commande' => $today
        ]);
        $commande->save();
        
        return redirect()->back()->with('success', 'Commande créée avec succès'); 
    }
    
    public function showVideosClient()
    {
        $user = Auth::user(); 
    
        if (!$user) {
            return redirect('login')->with('error', 'Vous devez être connecté pour voir vos vidéos.');
        }   
        $clientId = $user->id;
    
        // Obtenez toutes les vidéos clients de la table Commande
        $allVideosClient = Commande::where('client_id', $clientId)
                        ->with('video.entraineur.user')
                        ->orderBy('date_commande', 'desc')
                        ->get()
                        ->pluck('video'); // extraire uniquement la vidéo du résultat
    
        // Créer un tableau vide pour stocker des vidéos triées
        $sortedVideos = [];
    
        // Regrouper les vidéos par catégorie d'entraîneur
        foreach ($allVideosClient as $video) {
            $category = $video->entraineur->categories_d_entraineur ?? null;
    
            if ($category) {
                $sortedVideos[$category][] = $video;
            }
        }   
        // Afficher des vidéos pour chaque catégorie
        return view('yunevo.videos-privees', compact('sortedVideos'));
    }
}




