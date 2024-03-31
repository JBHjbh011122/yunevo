<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Client;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Exception;
use Aws\Exception\AwsException;

class ClientCompteController extends Controller
{
    public function clientForm()
    {
        // Retourne la vue du formulaire pour le client
        return view('/yunevo/form-client-compte', ['nom' => session('nom'), 'prenom' => session('prenom')]);
    }

    public function submitForm(Request $request)
    {
        // Validation des données du formulaire
        $validatedData = $request->validate([
            // Pas besoin de valider 'nom' et 'prenom' car ils sont en lecture seule
            'poids_depart' => 'required|numeric|between:0,999.99',
            'poids_desire' => 'required|numeric|between:0,999.99',
            'taille' => 'required|numeric|between:0,999.99',
            'photo_profil' => 'nullable|image|max:2048', // La photo de profil peut être nulle mais doit être un fichier image
        ]);
        // Commencer une transaction
        DB::beginTransaction();

        try {
            // Utiliser l'ID du client authentifié
            $clientId = Auth::id();

            // Créer ou mettre à jour l'enregistrement du client
            $client = Client::updateOrCreate(
                ['client_id' => $clientId], // Condition pour trouver le client
                [
                    'poids_depart' => $request->poids_depart,
                    'poids_souhait' => $request->poids_desire,
                    'taille' => $request->taille,
                    // Autres champs à mettre à jour...
                ]
            );
            // Sauvegarder l'enregistrement du client
            $client->save();

            // Traitement du téléchargement de la photo de profil
            if ($request->hasFile('photo_profil')) {
                $file = $request->file('photo_profil');
                if ($file->isValid()) {
                    $filename = time() . '_' . $file->getClientOriginalName();

                    // Télécharger le fichier sur S3
                    $path = $request->file('photo_profil')->store('photos', 's3');

                    if ($path) {
                        $url = Storage::disk('s3')->url($path);
                        $lien_aws_photo_compte = $url;

                        // Mettre à jour le champ 'lien_aws_photo_compte' pour l'utilisateur
                        $user = User::where('id', $clientId)->firstOrFail();
                        $user->lien_aws_photo_compte = $lien_aws_photo_compte;
                        $user->save();
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
                // validation de transaction
                DB::commit();
         
                // Rediriger vers la page du compte client
                return redirect('/compte-client');
           } catch (\Exception $e) {
           // En cas d'erreur, annuler la transaction
           DB::rollback();

           // Rediriger vers la page précédente avec un message d'erreur
           return back()->with('error', "Une erreur s'est produite lors de la création du compte.");
       }
    }

    public function updateForm(Request $request)
    {
        // Validation des données du formulaire
        $validatedData = $request->validate([
            // Pas besoin de valider 'nom' et 'prenom' car ils sont en lecture seule
            'poids_depart' => 'required|numeric|between:0,999.99',
            'poids_desire' => 'required|numeric|between:0,999.99',
            'taille' => 'required|numeric|between:0,999.99',
            'photo_profil' => 'nullable|image|max:2048', // La photo de profil peut être nulle mais doit être un fichier image
        ]);           
        // Commencer une transaction
        DB::beginTransaction();

        try {
            // Utiliser l'ID du client authentifié
            $clientId = Auth::id();
             // Récupérer l'instance de l'utilisateur
            $user = User::findOrFail($clientId);

            // Mettre à jour les champs nom et prenom si nécessaire
            $nom = $request->input('nom', $user->nom);
            $prenom = $request->input('prenom', $user->prenom);

            $user->fill([
                'nom' => $nom,
                'prenom' => $prenom,
                // Mettre à jour d'autres champs ici si nécessaire
            ])->save();

            // Créer ou mettre à jour l'enregistrement du client
            $client = Client::updateOrCreate(
                ['client_id' => $clientId], // Condition pour trouver le client
                [
                    'poids_depart' => $request->poids_depart,
                    'poids_souhait' => $request->poids_desire,
                    'taille' => $request->taille,
                    // Autres champs à mettre à jour...
                ]
            );
            // Sauvegarder l'enregistrement du client
            $client->save();

            // Traitement du téléchargement de la photo de profil
            if ($request->hasFile('photo_profil')) {
                $file = $request->file('photo_profil');
                if ($file->isValid()) {
                    $filename = time() . '_' . $file->getClientOriginalName();

                    // Télécharger le fichier sur S3
                    $path = $request->file('photo_profil')->store('photos', 's3');

                    if ($path) {
                        $url = Storage::disk('s3')->url($path);
                        $lien_aws_photo_compte = $url;

                        // Mettre à jour le champ 'lien_aws_photo_compte' pour l'utilisateur
                        $user = User::where('id', $clientId)->firstOrFail();
                        $user->lien_aws_photo_compte = $lien_aws_photo_compte;
                        $user->save();
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
                DB::commit();

                // Rediriger vers la page du compte client
                return redirect('/compte-client');
            } catch (\Exception $e) {
            // En cas d'erreur, annuler la transaction
            DB::rollback();

            // Rediriger vers la page précédente avec un message d'erreur
            return back()->with('error', "Une erreur s'est produite lors de la création du compte.");
            }
        }
    }
