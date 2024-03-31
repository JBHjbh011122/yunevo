<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Blog;
use Carbon\Carbon;

class BlogFormController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required',
            'photo_profil' => 'required|file|image',
            'texte' => 'required',
        ]);

        $user = Auth::user();
        $entraineur = $user->entraineur;
        if (!$entraineur) {
            return redirect('login')->with('error', 'Seuls les entraîneurs peuvent ajouter des articles au blog.');
        }

        if ($request->hasFile('photo_profil')) {
            $file = $request->file('photo_profil');
            if ($file->isValid()) {

                $path = $file->store('blog_photos', 's3');
                $url = Storage::disk('s3')->url($path);

                $blog = new Blog([
                    'entraineur_id' => $entraineur->id,
                    'date_publication' => Carbon::now(),
                    'texte' => $request->texte,
                    'titre' => $request->titre,
                    'lien_aws_photo_blog' => $url,
               ]);
                $blog->save();
                return redirect('/compte-entraineur');
            }
        }
        return redirect()->back()->with('error', 'Erreur lors de l\'ajout de l\'article de blog.');
    }

    public function edit(Blog $blog)
    {
        return view('yunevo.form-blog-modifie', compact('blog'));
    }
    
    public function update(Request $request, $blog_id)
    {
    $request->validate([
    'titre' => 'required',
    'photo_profil' => 'nullable|file|image',
    'texte' => 'required',
    ]);

    $blog = Blog::find($blog_id);
        if (!$blog) {
            return redirect()->back()->with('error', 'Article de blog introuvable.');
        }
        if ($request->has('titre')) {
            $blog->titre = $request->titre;
        }
        if ($request->has('texte')) {
            $blog->texte = $request->texte;
        }
        if ($request->hasFile('photo_profil') && $request->file('photo_profil')->isValid()) {
            $path = $request->file('photo_profil')->store('blog_photos', 's3');
            $url = Storage::disk('s3')->url($path);
            $blog->lien_aws_photo_blog = $url;
        }
    $blog->save();
    return redirect('/compte-entraineur')->with('success', 'L\'article de blog a été mis à jour avec succès.');
    }
}




