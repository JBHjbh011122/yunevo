<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;
use App\Models\Entraineur;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Models\User;

class AvisController extends Controller{

    public function addReview(Request $request)
    {
        // Vérification de l'authentification de l'utilisateur
        $user = auth()->user();
        if (!$user) {
            return redirect()->back()->with('nonSuccess', 'Seuls les clients ou les entraîneurs peuvent laisser un avis.');
        }
        // Vérification d'une note
    if (!$request->filled('rating')) {
        return redirect()->back()->with('nonSuccess', 'Vous devez fournir une évaluation.');
    }
        // Validation des données de révocation
        $request->validate([
            'rating' => 'required|numeric|min:1|max:5',
        ]);
        // Ajouter un avis à la base de données
        Review::create([
            'personnel_id' => $user->id,
            'commentaire' => $request->description,
            'evaluation' => $request->rating,
            'date_evaluation' => now(),
        ]);
        return redirect()->route('avis')->with('success', 'Votre avis a été ajouté avec succès.');
    }

    public function showReviews()
    {
        // Récupération de tous les avis de la base de données
        $reviews = Review::all();        
        // Calcul de la note moyenne
        $averageRating = $reviews->avg('evaluation');
        return view('yunevo.avis', compact('reviews', 'averageRating'));
    }
 
    public function deleteReview($id)
    {
        // Trouver un avis par son identifiant
        $review = Review::findOrFail($id);
        // Supprimer un avis de la base de données
        $review->delete();
        // Après avoir supprimé avec succès un avis, nous redirigeons l'utilisateur vers nouveau
        return redirect()->back()->with('success', 'Le commentaire a été supprimé avec succès.');
    }
}





