<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Video;

class VideoFormController extends Controller
{
    public function store(Request $request)  // Ajouter video
    {
        $request->validate([
            'titre' => 'required|string|max:50',
            'video-file' => 'nullable|file|max:50000|mimes:mp4,mov,ogg,qt,wmv,flv', // Recherche de fichiers jusqu'à 50 Mo et certains types de fichiers
            'video_type' => 'required|in:Publique,Privee',
            'description' => 'required',
        ]);

        $user = Auth::user();
        if (!$user) {
            return redirect('login')->with('error', 'Vous devez être connecté pour ajouter une vidéo.');
        }

        $entraineur = $user->entraineur;
        if (!$entraineur) {
            return redirect()->back()->with('error', 'Utilisateur non associé à un entraineur.');
        }
        $entraineurId = $entraineur->id;

        if ($request->hasFile('video-file')) {
            $file = $request->file('video-file');
            if ($file->isValid()) {

                $path = $file->store('videos', 's3');
                $url = Storage::disk('s3')->url($path);

                $video = new Video([
                    'entraineur_id' =>$entraineurId,
                    'est_public' => $request->video_type === 'Publique' ? 1 : 0,
                    'description' => $request->description,
                    'lien_aws' => $url,
                    'date_de_prise' => now(),
                    'titre' => $request->titre,
                    'date_publication' => now(),
                ]);
                $video->save();

                return redirect('/compte-entraineur');
            }
        }
        return redirect()->back()->with('error', 'Erreur lors de l\'ajout de la vidéo.');
    }

    public function update(Request $request, $video_id)
    {
        $request->validate([
            'titre' => 'required|string|max:50',
            'video-file' => 'nullable|file|max:50000|mimes:mp4,mov,ogg,qt,wmv,flv',
            'video_type' => 'required|in:Publique,Privee',
            'description' => 'required',
        ]);

        $user = Auth::user();
        if (!$user) {
            return redirect('login')->with('error', 'Vous devez être connecté pour ajouter une vidéo.');
        }

        $entraineur = $user->entraineur;
        if (!$entraineur) {
            return redirect()->back()->with('error', 'Utilisateur non associé à un entraineur.');
        }

        $video = Video::findOrFail($video_id);
        $video->titre = $request->titre;
        $video->est_public = $request->video_type === 'Publique' ? 1 : 0;
        $video->description = $request->description;

        if ($request->hasFile('video-file')) {
            $file = $request->file('video-file');
            if ($file->isValid()) {
                $path = $file->store('videos', 's3');
                $url = Storage::disk('s3')->url($path);
                $video->lien_aws = $url;
            }
        }
        $video->save();

        return redirect('/compte-entraineur')->with('success', 'La vidéo a été modifiée avec succès.');
    }
}


