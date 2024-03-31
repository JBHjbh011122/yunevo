<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Photo;
use App\Models\Client;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PhotoController extends Controller
{
    // Afficher le formulaire d'ajout de photos
    public function showForm()
    {
        return view('yunevo/form-photo-ajoute');
    }

    public function showClientPhotos()
    {
        $user = Auth::user();
        $client = $user->client ?? null;

        if (!$client) {
            return redirect('login')->with('error', 'Seuls les clients peuvent consulter cette page.');
        }

        $photos = Photo::where('client_id', $client->id)
                     ->orderBy('created_at', 'desc')
                     ->get();
        return view('yunevo.photo-client-progression', compact('photos', 'user'));
    }

    // Traitement des formulaires de photos soumis
    public function addPhoto(Request $request)
    {
        $request->validate([
            'photo_profil' => 'required|image|max:2048',
            'datePrise'=>'required'
        ]);

        $user = Auth::user();
        if (!$user) {
            return redirect('login')->with('error', 'Vous devez être connecté pour ajouter une vidéo.');
        }

        $client = $user->client;
        if (!$client) {
            return redirect()->back()->with('error', 'Utilisateur non associé à un client.');
        }
        $clientId = $client->id;

        // Traitement du téléchargement de la photo
        if ($request->hasFile('photo_profil')) {
            $file = $request->file('photo_profil');
            if ($file->isValid()) {
                $filename = time() . '_' . $file->getClientOriginalName();

                // Télécharger le fichier sur S3
                $path = $request->file('photo_profil')->store('photos', 's3');

                if ($path) {
                    $url = Storage::disk('s3')->url($path);
                    $imageUrl = $url;

                    // Mettre à jour le champ 'lien_aws' pour le photo
                    $photo = new Photo;
                    $photo->client_id = $clientId ;
                    $photo->lien_aws = $imageUrl;
                    $photo->date_image = $request->datePrise;
                    $photo->save();

                    return redirect('/compte-client');
                } else {
                    // Enregistrer un message d'erreur si le téléchargement échoue
                    Log::error('Échec du téléchargement du fichier vers S3.', ['filename' => $filename]);
                }
            } else {
                // Enregistrer un message d'erreur si le fichier n'est pas valide
                Log::error("Le fichier téléchargé n'est pas valide.", ['name' => $file->getClientOriginalName()]);
            }
        } else {
             // Enregistrer un avertissement si aucun fichier n'est téléchargé
            Log::warning('Aucun fichier à télécharger dans la requête.');
        }
    }

    public function destroy($photo_id)
    {
        $photo = Photo::find($photo_id);

        if ($photo) {

            $photo->delete();

            return redirect()->route('yunevo.photo-client-progression')->with('success', 'Le photo a été supprimé avec succès.');
        } else {
            abort(404);
        }
    }
}

