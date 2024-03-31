<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Blog;
use Carbon\Carbon;
use App\Models\Entraineur;

class BlogController extends Controller
{
    public function show($blog_id)
    {
        $blog = Blog::with('entraineur')->find($blog_id);
        // Vérifier que l'utilisateur est connecté et qu'il s'agit d'un entraineur.
        $isEntraineur = Auth::check() && Auth::user()->user_type == 'entraineur';

        // Vérifier si l'entraineur connecté est l'éditeur de la vidéo
        if ($isEntraineur) {
            // Récupère l'entraineur_id de l'entraîneur actuellement connecté
            $currentEntraineurId = Entraineur::where('entraineur_id', Auth::id())->value('id');

            // Vérifiez si l'entraîneur actuel est l'éditeur de la vidéo
            $isOwner = $currentEntraineurId == $blog->entraineur_id;
        } else {
            $isOwner = false;
        }
        if (!$blog) {

            abort(404, 'Article de blog introuvable.');
        }
        $user = $blog->entraineur;
        return view('yunevo.detail-article', compact('blog','isOwner'));
    }

    public function showEntraineurBlogs()
    {
        $user = Auth::user();
        $entraineur = $user->entraineur ?? null;

        if (!$entraineur) {
            return redirect('login')->with('error', 'Seuls les entraîneurs peuvent consulter cette page.');
        }
        $blogs = Blog::where('entraineur_id', $entraineur->id)
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('yunevo.blog-entraineur', compact('blogs', 'user'));
    }

    public function index()
    {
        $blogs = Blog::orderBy('created_at', 'desc')->get();
        return view('yunevo.blog', compact('blogs'));
    }

    public function destroy($blog_id)
    {
        $blog = Blog::find($blog_id);
        if ($blog) {

            $blog->delete();

            $blog->delete();

            return redirect()->route('yunevo.blog-entraineur')->with('success', 'L\'article de blog a été supprimé avec succès.');
        } else {
            abort(404);
        }
    }
}

