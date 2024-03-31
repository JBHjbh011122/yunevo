<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BoiteReceptionController extends Controller
{
    /// Méthode pour afficher la page des messages reçus
    public function index()
    {
        if (Auth::user()->isEntraineur()) {
            // Récupération des messages envoyés à l'entraîneur, сортировка по дате создания в обратном порядке
            $messages = Message::where('destinataire_id', Auth::id())->orderBy('created_at', 'desc')->get();
        } elseif (Auth::user()->isClient()) {
            // Récupération des messages envoyés au client, сортировка по дате создания в обратном порядке
            $messages = Message::where('destinataire_id', Auth::id())->orderBy('created_at', 'desc')->get();
        } else {
            // Pour les utilisateurs non authentifiés ou d'autres types d'utilisateurs
            $messages = collect(); // Collection vide
        }
        session(['previousPage' => 'recus']);
        return view('boite-reception.recus', compact('messages'));
    }
        // Méthode pour afficher la page des messages envoyés
        public function sent()
        {
            // Extraction des messages envoyés par l'utilisateur, сортировка по дате создания в обратном порядке
            $sentMessages = Message::where('expediteur_id', auth()->user()->id)->orderBy('created_at', 'desc')->get();

            session(['previousPage' => 'envoyes']);
            return view('boite-reception.envoyes', compact('sentMessages'));
        }
    // Méthode pour afficher les détails d'un message spécifique
    public function showRecu($id)
    {
        $message = Message::with('expediteur')->where('id', $id)->firstOrFail();
        $expediteurId = $message->expediteur_id;
        //  Vérification : assurez-vous que l'utilisateur actuel est le destinataire du message
        if ($message->destinataire_id == Auth::id() && $message->est_lu == 0) {
            $message->est_lu = 1; // Étiquette : message lu
            $message->save();
        }
        $contactedUser = User::find($expediteurId);

        $trainerId = null;
        $clientId = null;

        if (Auth::user()->isEntraineur()) {
            $trainerId = $message->destinataire_id;
            $clientId = $expediteurId;
        } elseif (Auth::user()->isClient()) {
            $trainerId = $expediteurId;
            $clientId = $message->destinataire_id;
        }
        return view('boite-reception.recu-detail', compact('message', 'expediteurId', 'contactedUser', 'trainerId', 'clientId'));
    }

    public function getTrainerAndClientIds($message)
    {
        $trainerId = null;
        $clientId = null;

        if (Auth::user()->isEntraineur()) {
            $trainerId = $message->expediteur_id;
            $clientId = $message->destinataire_id;
        } elseif (Auth::user()->isClient()) {
            $trainerId = $message->destinataire_id;
            $clientId = $message->expediteur_id;
        }
        return [
            'trainerId' => $trainerId,
            'clientId' => $clientId
        ];
    }

    // Méthode pour afficher les détails d'un message envoyé
    public function showEnvoye($id)
    {
        $message = Message::where('id', $id)
            ->where('expediteur_id', auth()->user()->id)
            ->firstOrFail();
        return view('boite-reception.envoye-detail', ['message' => $message]);
    }

    // Méthode pour supprimer un message
    public function destroy($id)
    {
        $message = Message::findOrFail($id);
        if ($message->expediteur_id == auth()->user()->id || $message->destinataire_id == auth()->user()->id) {
            $message->delete();
        }
        // Récupération des informations de la page précédente à partir de la session
        $previousPage = session('previousPage', 'recus');

        // Redirection de l'utilisateur vers la page appropriée
        $redirectRoute = $previousPage === 'envoyes' ? 'boite-reception.envoyes' : 'boite-reception.recus';
        return redirect()->route($redirectRoute)->with('success', 'Message supprimé avec succès.');
    }

    // Méthode pour supprimer plusieurs messages
    public function destroyMultiple(Request $request)
    {
        $idsToDelete = $request->input('ids', []);

        // Vérification des droits de suppression des messages
        $messagesToDelete = Message::whereIn('id', $idsToDelete)
            ->where(function ($query) {
                $query->where('expediteur_id', auth()->id())
                    ->orWhere('destinataire_id', auth()->id());
            })->get();

        if ($messagesToDelete->count() !== count($idsToDelete)) {
            return response()->json(['error' => 'Tentative de suppression de messages sans autorisation.'], 403);
        }
        // Suppression des messages
        Message::destroy($idsToDelete);

        $redirectRoute = $request->input('source') === 'sent' ? 'boite-reception.envoyes' : 'boite-reception.recus';
        return redirect()->route($redirectRoute)->with('success', 'Messages supprimés avec succès.');
    }

    // Méthode pour enregistrer un nouveau message
    public function store(Request $request)
    {
        $request->validate([
            'destinataire_id' => 'required|integer|exists:users,id',
            'sujet' => 'required|string|max:255',
            'texte_message' => 'required|string',
        ]);
        $message = new Message([
            'expediteur_id' => Auth::id(), // ID de l'utilisateur actuel (expéditeur)
            'destinataire_id' => $request->destinataire_id, // ID du destinataire obtenu du formulaire
            'sujet' => $request->sujet, // Sujet du message du formulaire
            'texte_message' => $request->texte_message, // Texte du message du formulaire
            'date_message' => now(), // Définition de la date et de l'heure actuelles
            'est_lu' => 0, // Statut de lecture (0 - non lu)
        ]);
        $message->save(); // Enregistrement du message dans la base de données

        return redirect()->route('boite-reception.envoyes')->with('success', 'Message envoyé avec succès.');
    }

    // Méthode pour composer un message à un entraîneur
    public function composeMessage($entraineurId)
    {
        if (!Auth::check() || Auth::user()->user_type !== 'client') {
            // Redirection vers la page précédente sans message d'erreur, car des fenêtres modales sont utilisées
            return redirect()->back();
        }
        // Recherche de l'entraîneur par son ID
        $entraineurUser = User::where('id', $entraineurId)->first();

        if (!$entraineurUser || $entraineurUser->user_type !== 'entraineur') {
            // Redirection vers la page précédente sans message d'erreur
            return redirect()->back();
        }
        // Création et enregistrement d'un nouveau message
        $message = new Message([
            'expediteur_id' => Auth::id(),
            'destinataire_id' => $entraineurUser->id,
            'sujet' => 'Demande d’entraînement',
            'texte_message' => 'Bonjour, je suis intéressé(e) par votre entraînement.',
            'date_message' => now(),
            'est_lu' => 0,
        ]);
        $message->save();

        // Redirection de l'utilisateur avec un message de succès
        return redirect()->route('boite-reception.envoyes')->with('success', 'Message envoyé avec succès.');
    }

    public function compose(Request $request, $replyTo = null)
    {
        $user = Auth::user();

        // Variable pour stocker l'utilisateur sélectionné par défaut
        $selectedUser = null;

        // Vérification de la présence du paramètre replyTo
        if ($replyTo) {
            $selectedUser = User::find($replyTo);
        }

        // Obtention de la liste des utilisateurs avec lesquels il y a eu correspondance
        $contactedUsersIds = Message::where('expediteur_id', $user->id)
            ->pluck('destinataire_id')
            ->merge(Message::where('destinataire_id', $user->id)->pluck('expediteur_id'))
            ->unique();

        // Obtention des modèles de ces utilisateurs
        $contactedUsers = User::whereIn('id', $contactedUsersIds)->get();

        // Variable supplémentaire pour déterminer dans la vue qu'il s'agit d'un nouveau message
        $isNew = is_null($selectedUser);

        return view('boite-reception.compose', compact('contactedUsers', 'selectedUser', 'isNew'));
    }
}




