<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Entraineur;
use Illuminate\Http\Request;
use App\Models\Video;
use Illuminate\Support\Facades\Log;

class VideoController extends Controller
{
    // Regarder la vidéo sélectionnée
    public function show($video_id)
    {
        $selected_video = Video::find($video_id);
        // Vérifier que l'utilisateur est connecté et qu'il s'agit d'un entraineur.
        $isEntraineur = Auth::check() && Auth::user()->user_type == 'entraineur';

        // Vérifier si l'entraineur connecté est l'éditeur de la vidéo
        if ($isEntraineur) {
            // Récupère l'entraineur_id de l'entraîneur actuellement connecté
            $currentEntraineurId = Entraineur::where('entraineur_id', Auth::id())->value('id');

            // Vérifiez si l'entraîneur actuel est l'éditeur de la vidéo
            $isOwner = $currentEntraineurId == $selected_video->entraineur_id;
        } else {
            $isOwner = false;
        }       
        if ($selected_video) {

        $trainer = $selected_video->entraineur;

        $trainerName = null;
        $trainerSurname = null;
        $trainerTrainingType = null;

        if ($trainer) {
            $trainerName = $trainer->user->nom;
            $trainerSurname = $trainer->user->prenom;
            $trainerTrainingType = $trainer->categories_d_entraineur;
        }
        return view('yunevo.detail-video', compact('selected_video', 'trainerName', 'trainerSurname', 'trainerTrainingType','isOwner'));
        } else {
            abort(404);
        }
    }

   // Regardez la vidéo publique d'entraineur
    public function showPublicVideos()
    {
        $user = Auth::user(); // Obtenir l'utilisateur actuel
        if (!$user) {
            return redirect('login')->with('error', 'Vous devez être connecté pour ajouter une vidéo.');
        }
        $entraineur = $user->entraineur;
        if (!$entraineur) {
            return redirect()->back()->with('error', 'Utilisateur non associé à un entraineur.');
        }
        $entraineurId = $entraineur->id;

        if ($user) {
            $entraineur = Entraineur::where('entraineur_id', $user->id)->first();
            if ($entraineur) {
                // Recevons uniquement des vidéos publiques pour ce Entraineur
                $videosPublic = Video::where('entraineur_id', $entraineurId)
                    ->where('est_public', 1) // 1 Vidéos publiques
                    ->orderBy('created_at', 'desc')
                    ->get();

                return view('yunevo.videos-publiques-entraineur', compact('videosPublic'));
            } else {
                return back()->with('error', 'Vous n\'êtes pas un entraîneur.');
            }
        } else {
            return redirect('login');
        }
    }

    // Regardez la vidéo Privees d'entraineur
    public function showPrivateVideos()
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

                 return view('yunevo.videos-privees-entraineur', compact('videosPrivees'));
            } else {
                return back()->with('error', 'Vous n\'êtes pas un entraîneur.');
            }
        } else {
            return redirect('login');
        }
    }

    // Regarde toutes les vidéos publique
    public function showAllPublicVideos()
    {
        // Obtenons des catégories uniques d'Entraineur
        $trainerCategories = Entraineur::distinct('categories_d_entraineur')->pluck('categories_d_entraineur');

        // Obtenez toutes les vidéos publiques et préchargez les entraîneurs associés
        $allPublicVideos = Video::with('entraineur')
        ->where('est_public', 1) // Obtenez uniquement des vidéos publiques
        ->orderBy('created_at', 'desc')
        ->get();
        return view('yunevo.videos-publiques', compact('allPublicVideos', 'trainerCategories'));
    }

    // Delete Video 
    public function showDeleteForm($video_id)
    {
        $video = Video::find($video_id);
        if (!$video) {
            abort(404);
        }

        return view('yunevo.supprimer-video', compact('video'));
    }

    public function destroy($videoId)
    {
        $video = Video::with('commandes')->find($videoId);

        if ($video) {
            // Si la vidéo est privée, supprimez tous les enregistrements des commandes correspondantes.
            if (!$video->est_public) {
                foreach ($video->commandes as $commande) {
                    $commande->delete();
                }
            }
            $video->delete();

            return redirect()->back()->with('success', 'La vidéo a été supprimée avec succès.');
        } else {
            // renvoie une erreur 404 si la vidéo n'existe pas
            abort(404);
        }
    }

    // Méthode pour modifier de vidéo 
    public function modifierVideo(Request $request, $video_id)
    {
        //Vérifier les données de la demande
        $validatedData = $request->validate([
            'titre' => 'required|string|max:50',
            'description' => 'required',
            'est_public' => 'required|boolean',
        ]);
        $video = Video::findOrFail($video_id);

        // Mettez à jour la vidéo directement avec les données vérifiées
        $video->update($validatedData);

        return redirect()->route('compte-entraineur')->with('success', 'La vidéo a été modifiée avec succès.');
    }


    public function showUpdateForm($video_id)
    {
        $video = Video::find($video_id);

        if (!$video) {
            abort(404);
        }

        return view('yunevo.form-video-modifie', compact('video'));
    }

    // Afficher les vidéos par catégorie sélectionnée
    public function showPublicVideosByCategory($category)
    {
        // Obtenons toutes les vidéos publiques de la base de données pour la catégorie sélectionnée
        $entraineursInCategory = Entraineur::where('categories_d_entraineur', $category)->pluck('id');

        $videosByCategory = Video::with(['entraineur', 'entraineur.user'])
        ->whereIn('entraineur_id', $entraineursInCategory)
        ->where('est_public', 1)
        ->orderBy('created_at', 'desc')
        ->get();

        return view('yunevo.videos-publiques-type', compact('videosByCategory', 'category'));
    }
}




