<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Entraineur;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class EntraineurCompteController extends Controller
{
    public function entraineurForm()
    {
        // Retourne la vue du formulaire pour les entraîneurs
        return view('/yunevo/form-entraineur-compte',['nom' => session('nom'),'prenom' => session('prenom')]);
    }

    public function submitForm(Request $request)
    {
       // Validation des données
       $validatedData = $request->validate([
            'categories' => 'required|string|max:50',
            'description' => 'required|string|max:500',
            'photo_profil' => 'nullable|image|max:2048',
        ]);
        // Commencer une transaction de base de données
        DB::beginTransaction();

        try {
            // Utiliser l'utilisateur actuellement authentifié
            $entraineurId = Auth::id();

            // Créer ou mettre à jour l'entrée dans la table Entraineur
            $entraineur = Entraineur::updateOrCreate(
                ['entraineur_id' => $entraineurId],// Condition de recherche
                [
                    'categories_d_entraineur' => $request->categories,
                    'description_d_entraineur' => $request->description,
                ]
            );
            $entraineur->save();

            // Traitement de l'upload de la photo de profil
            if ($request->hasFile('photo_profil')) {
                $file = $request->file('photo_profil');
                if ($file->isValid()) {
                    // Nom du fichier basé sur l'heure actuelle et le nom original
                    $filename = time() . '_' . $file->getClientOriginalName();

                    // Téléchargement du fichier vers S3
                      $path = $request->file('photo_profil')->store('photos', 's3');
                    if ($path) {
                        // Obtention de l'URL du fichier stocké sur S3
                        $url = Storage::disk('s3')->url($path);
                        $lien_aws_photo_compte = $url;

                        $clientId = auth()->id();

                        // Mise à jour du champ lien_aws_photo_compte de l'utilisateur
                        $user = User::where('id', $entraineurId)->firstOrFail();
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

                // Effacer les sessions nom et prénom
                session()->forget(['nom', 'prenom']);

                // Rediriger vers la page du compte client
                return redirect('/compte-entraineur');
           } catch (\Exception $e) {
           // En cas d'erreur, annuler la transaction
           DB::rollback();

           // Rediriger vers la page précédente avec un message d'erreur
           return back()->with('error', "Une erreur s'est produite lors de la création du compte.");
       }
       Log::info('Fin de la soumission du formulaire');
       }

    public function updateForm(Request $request)
    {
       // Validation des données
       $validatedData = $request->validate([
            'categories' => 'required|string|max:50',
            'description' => 'required|string|max:500',
            'photo_profil' => 'nullable|image|max:2048',
        ]);

        // Commencer une transaction de base de données
        DB::beginTransaction();

        try {
            // Utiliser l'utilisateur actuellement authentifié
            $entraineurId = Auth::id();

            // Récupérer l'instance de l'utilisateur
            $user = User::findOrFail($entraineurId);

            // Mettre à jour les champs nom et prenom si nécessaire
            $nom = $request->input('nom', $user->nom);
            $prenom = $request->input('prenom', $user->prenom);

            $user->fill([
                'nom' => $nom,
                'prenom' => $prenom,
                // Mettre à jour d'autres champs ici si nécessaire
            ])->save();

                // Créer ou mettre à jour l'entrée dans la table Entraineur
                $entraineur = Entraineur::updateOrCreate(
                    ['entraineur_id' => $entraineurId],// Condition de recherche
                    [
                        'categories_d_entraineur' => $request->categories,
                        'description_d_entraineur' => $request->description,
                    ]
                );
                $entraineur->save();

                // Traitement de l'upload de la photo de profil
                if ($request->hasFile('photo_profil')) {
                    $file = $request->file('photo_profil');
                    if ($file->isValid()) {
                        // Nom du fichier basé sur l'heure actuelle et le nom original
                        $filename = time() . '_' . $file->getClientOriginalName();

                        // Téléchargement du fichier vers S3
                        $path = $request->file('photo_profil')->store('photos', 's3');
                        if ($path) {
                            // Obtention de l'URL du fichier stocké sur S3
                            $url = Storage::disk('s3')->url($path);
                            $lien_aws_photo_compte = $url;

                            $clientId = auth()->id();

                            // Mise à jour du champ lien_aws_photo_compte de l'utilisateur
                            $user = User::where('id', $entraineurId)->firstOrFail();
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

                    // Effacer les sessions nom et prénom
                    session()->forget(['nom', 'prenom']);

                    // Rediriger vers la page du compte client
                    return redirect('/compte-entraineur');
            } catch (\Exception $e) {
            // En cas d'erreur, annuler la transaction
            DB::rollback();

            // Rediriger vers la page précédente avec un message d'erreur
            return back()->with('error', "Une erreur s'est produite lors de la création du compte.");
            }
       Log::info('Fin de la soumission du formulaire');
       }
    }
