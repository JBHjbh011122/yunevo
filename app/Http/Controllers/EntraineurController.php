<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Entraineur;
use Illuminate\Support\Facades\DB;
use App\Models\Video;
use App\Models\Blog;
use App\Models\Commande;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class EntraineurController extends Controller
{
    // Trainer account GET method
    public function index()
    {
        $user = Auth::user(); // Obtenir l'utilisateur actuellement connecté
        if ($user) {
            session(['prenom' => $user->prenom]);
            session(['nom' => $user->nom]);

            $entraineur = Entraineur::where('entraineur_id', $user->id)->first();

            if ($entraineur) {
                $videosPublic = Video::where('entraineur_id', $entraineur->id)
                ->where('est_public', 1)
                ->orderBy('created_at', 'desc')
                ->take(2)
                ->get();

                $videosPrivee = Video::where('entraineur_id', $entraineur->id)
                ->where('est_public', 0)
                ->orderBy('created_at', 'desc')
                ->take(2)
                ->get();

                $articles = Blog::where('entraineur_id', $entraineur->id)
                            ->orderBy('created_at', 'desc')
                            ->take(2)
                            ->get();

                // Transmission d'informations sur l'utilisateur et le formateur aux vues
                return view('yunevo.compte-entraineur', compact('user','entraineur','videosPublic','videosPrivee','articles'));
            } else {
                // Traitement des cas où l'utilisateur actuel n'est pas un formateur
                return back()->with('error', 'Vous n\'êtes pas un entraîneur.');
            }
        } else {
            // L'utilisateur n'est pas connecté, rediriger vers la page de connexion
            return redirect('login');
        }
    }

    public function showUpdateForm($entraineur_id)
    {
        $user = Auth::user();
        $entraineur = Entraineur::find($entraineur_id);

        if (!$entraineur) {
            abort(404);
        }
        return view('yunevo.form-entraineur-compte-modifier', compact('user','entraineur'));
    }


    // Trainer account Delete
    public function destroy($id)
    {
        $user = User::findOrFail($id); // Obtenir l'utilisateur connecté actuel
        if ($user) {
            DB::beginTransaction(); // Début de transaction
            try {
                // Vérifiez si l'utilisateur est un entraineur
                $entraineur = Entraineur::where('entraineur_id', $user->id)->first();

                if ($entraineur) {
                    // Supprimer les enregistrements associés dans les tables videos, blogs, et commandes
                    Video::where('entraineur_id', $entraineur->id)->delete();
                    Blog::where('entraineur_id', $entraineur->id)->delete();
                    Commande::where('entraineur_id', $entraineur->id)->delete();

                    // Supprimer l'enregistrement dans la table entraineurs
                    $entraineur->delete();
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
            return redirect('/'); // L'utilisateur n'est pas connecté, rediriger vers la page de connexion
        }
    }
}


