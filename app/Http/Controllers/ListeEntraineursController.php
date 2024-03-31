<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Entraineur;

class ListeEntraineursController extends Controller
{
    public function showEntraineurs() {
        // Récupérer tous les entraineurs avec leurs données d'utilisateur associées
        $entraineurs = Entraineur::with('user')->get();

        // En supposant que vous ayez un champ 'categories_d_entraineur' dans le modèle Entraineur
        $categories = Entraineur::select('categories_d_entraineur')->distinct()->pluck('categories_d_entraineur');

        return view('yunevo.nos-entraineurs', compact('entraineurs', 'categories'));
    }

    public function showEntraineursByCategory($category) {
        // Récupérer les entraineurs avec leurs données d'utilisateur associées pour la catégorie donnée.
        $entraineurs = Entraineur::with('user')->where('categories_d_entraineur', $category)->get();

        return view('yunevo.entraineurParCategorie', compact('entraineurs', 'category'));
    }

}
