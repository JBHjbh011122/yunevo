<?php
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserTypeController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Controllers\ClientCompteController;
use App\Http\Controllers\EntraineurCompteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EntraineurController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\BoiteReceptionController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\ProgresController;
use App\Http\Controllers\VideoFormController;
use App\Http\Controllers\BlogFormController;
use App\Http\Controllers\ListeEntraineursController;
use App\Http\Controllers\DialogflowController;
use App\Http\Controllers\AvisController;
use App\Http\Controllers\CommandeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AvisController::class, 'showReviewsAccueil']);
Route::get('/generate-presigned-url', [VideoFormController::class, 'generatePresignedUrl'])->middleware('auth')->name('generate-presigned-url');

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::post('/ajoute-avis', [AvisController::class, 'addReview'])->name('ajout-avis');
Route::get('/avis', [AvisController::class, 'showReviews'])->name('avis');
Route::delete('/delete-review/{id}', [AvisController::class, 'deleteReview'])->name('delete-review');
Route::get('/form-avis-ajoute', function () {
    return view('yunevo.form-avis-ajoute');
})->name('form-avis-ajoute');

// =========================================== Comande  ====================
Route::get('/videos-commande/{clientId}/{trainerId}', [CommandeController::class, 'showVideos'])->name('commande-privees-video');
Route::post('/commande-ajouter/{clientId}/{trainerId}/{videoId}', [CommandeController::class, 'createCommande'])->name('commande-ajouter');
Route::get('/videos-privees', [CommandeController::class, 'showVideosClient'])->name('videos-privees');

// ================================== video ===============================================
Route::post('/ajout-video', [VideoFormController::class, 'store'])->name('ajout-video');
Route::put('/video/{video_id}', [VideoFormController::class, 'update'])->name('video.update');
Route::delete('/video/{video_id}', [VideoController::class, 'destroy'])->name('video.destroy');
Route::get('/modifier-video/{video_id}', [VideoController::class, 'showUpdateForm'])->name('modifie-video');
Route::get('/videos-publiques-par-categorie/{category}', [VideoController::class, 'showPublicVideosByCategory'])->name('videos-par-categorie');
Route::get('/videos-publiques-entraineur', [VideoController::class, 'showPublicVideos'])->name('voir-public-video');
Route::get('/videos-privees-entraineur', [VideoController::class, 'showPrivateVideos'])->name('voir-privees-video');
Route::get('/videos-publiques', [VideoController::class, 'showAllPublicVideos'])->name('videos-publiques');
Route::get('/detail-video/{video_id}', [VideoController::class, 'show'])->name('detail-video');

//  ========== Blog ==================================
Route::get('/blog', [App\Http\Controllers\BlogController::class, 'index'])->name('blog.index');
Route::get('/detail-blog/{blog_id}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/blog-entraineur', [BlogController::class, 'showEntraineurBlogs'])->name('yunevo.blog-entraineur');
Route::post('/form-blog-ajoute', [BlogFormController::class, 'store'])->name('ajout-blog');
Route::delete('/blog/{blog_id}', [BlogController::class, 'destroy'])->name('blog.destroy');
Route::get('/blog/{blog}/edit', [BlogFormController::class, 'edit'])->name('modifie-blog');
Route::put('/blog/{blog}', [BlogFormController::class, 'update'])->name('blog.update');
Route::get('/form-blog-ajoute', function () {
    return view('yunevo/form-blog-ajoute');
});

Route::get('/responsabilite', function () {
    return view('yunevo/responsabilite');
})->name('responsabilite');

Route::post('/send-message', [DialogflowController::class, 'sendMessage'])->name('send-message');

Route::get('/form-photo-ajoute', [PhotoController::class, 'showForm']);
Route::get('/photo-client-progression', [PhotoController::class, 'showClientPhotos'])->name('yunevo.photo-client-progression');
Route::delete('/photo/{photo_id}', [PhotoController::class, 'destroy'])->name('photo.destroy');
Route::post('/ajout-photo', [PhotoController::class, 'addPhoto'])->name('ajout-photo');

Route::get('/form-video-ajoute', function () {
    return view('yunevo/form-video-ajoute');
})->name('video-ajoute');

Route::post('/form-poids-ajoute', [ProgresController::class, 'store'])->name('ajouter-poids');
Route::get('/form-poids-ajoute', function () {
    return view('yunevo/form-poids-ajoute');
})->name('ajout-poids');

Route::get('/form-chat-bot', function () {
    return view('/yunevo/form-chat-bot');
});

Route::get('/yunevo/form-client-compte', [ClientCompteController::class, 'clientForm'])->name('show-form-client-compte');
Route::post('/yunevo/form-client-compte', [ClientCompteController::class, 'submitForm'])->name('submit-form-client-compte');
Route::post('/yunevo/form-client-compte-modifier', [ClientCompteController::class, 'updateForm'])
->name('submit-form-client-compte-modifier');

Route::get('/yunevo/form-entraineur-compte', [EntraineurCompteController::class, 'entraineurForm'])->name('show-form-entraineur-compte');
Route::post('/yunevo/form-entraineur-compte', [EntraineurCompteController::class, 'submitForm'])->name('submit-form-entraineur-compte');
Route::post('/yunevo/form-entraineur-compte-modifier', [EntraineurCompteController::class, 'updateForm'])
->name('submit-form-entraineur-compte-modifier');

Route::get('nos-entraineurs', [ListeEntraineursController::class, 'showEntraineurs']);
Route::get('/entraineurs-par-categorie/{category}', [ListeEntraineursController::class, 'showEntraineursByCategory'])
->name('entraineurs-par-categorie');

Route::get('/compte-entraineur', [EntraineurController::class, 'index'])->name('compte-entraineur')->middleware('auth');
Route::get('/modifie-compte-entraineur/{entraineur_id}', [EntraineurController::class, 'showUpdateForm'])
->name('modifie-compte-entraineur');
Route::delete('/entraineur/delete/{id}', [EntraineurController::class, 'destroy'])
     ->middleware('auth');

Route::get('/compte-client', [ClientController::class, 'index'])->name('compte-client')->middleware('auth');
Route::get('/modifie-compte-client/{client_id}', [ClientController::class, 'showUpdateForm'])->name('modifie-compte-client');
Route::delete('/client/delete/{id}', [ClientController::class, 'destroy'])
    ->middleware('auth');

// Routage pour rediriger les utilisateurs vers la page OAuth de Google
Route::get('auth/google', function () {
    /** @var \Laravel\Socialite\Two\AbstractProvider $provider */
    $provider = Socialite::driver('google');
    return $provider->stateless()->with(['prompt' => 'select_account'])->redirect();
})->name('google.login');

Route::get('yunevo/choose-type', [UserTypeController::class, 'showChooseTypeForm'])->name('choose-type');
Route::post('yunevo/choose-type', [UserController::class, 'updateUserType'])->name('update-user-type');

// Route de rappel Google, les utilisateurs seront redirigés vers cette route après s'être connectés à Google
Route::get('auth/google/callback', function () {
     /** @var \Laravel\Socialite\Two\AbstractProvider $abstractProvider */
     $abstractProvider = Socialite::driver('google');
     $googleUser = $abstractProvider->stateless()->user();

    // Essayer de trouver des utilisateurs existants
    $user = User::where('email', $googleUser->getEmail())->first();

    if (!$user) {
        // Si l'utilisateur n'existe pas, créer un nouvel utilisateur
        $names = explode(' ', $googleUser->getName(), 2);
        $prenom = $names[0];
        $nom = count($names) > 1 ? $names[1] : '';

        $user = User::create([
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $googleUser->getEmail(),
            'user_type' => 'initial',
            'password' => Hash::make(Str::random(40)),
        ]);

        session(['nom' => $nom, 'prenom' => $prenom]);

        switch ($user->user_type) {
            case 'initial':
                Auth::login($user);
                return redirect('yunevo/choose-type');
            case 'client':
                Auth::login($user);
                return redirect('/yunevo/form-client-compte');
            case 'entraineur':
                Auth::login($user);
                return redirect('/yunevo/form-entraineur-compte');
            default:
                Auth::login($user);
                return redirect('/dashboard');
        }
    }
    // L'utilisateur existe déjà
    Auth::login($user);
    // Déterminer les cibles de redirection en fonction du type d'utilisateur
    if ($user->user_type === 'client') {
        return redirect('/compte-client'); // Redirection vers la page du client
    } elseif ($user->user_type === 'entraineur') {
        return redirect('/compte-entraineur'); // Redirection vers la page de coaching
    }
    // Si le type d'utilisateur n'est pas déterminé
    return redirect('/yunevo/choose-type'); // Redirige vers la page Sélectionner un type d'utilisateur
});

Route::get('/policy', function () {
    return view('policy');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/register-entraineur', function () {
    return view('auth.register-entraineur');
})->middleware(['guest'])->name('register-entraineur');


Route::get('/form-inscrire', function () {
    return view('register');
})->name('form-inscrire');

Route::get('/responsabilite', function () {
    return view('yunevo/responsabilite');
})->name('responsabilite');

// ========================= Boite reception ==================================================
Route::get('/boite-reception/recus', [BoiteReceptionController::class, 'index'])->name('boite-reception.recus');
Route::get('/boite-reception/envoyes', [BoiteReceptionController::class, 'sent'])->name('boite-reception.envoyes');
// Route::get('/boite-reception/compose', [BoiteReceptionController::class, 'compose'])->name('boite-reception.compose');
Route::get('/boite-reception/recu-detail/{id}', [BoiteReceptionController::class, 'showRecu'])->name('boite-reception.showRecu');
Route::delete('/boite-reception/destroy/{id}', [BoiteReceptionController::class, 'destroy'])->name('boite-reception.destroy');
Route::get('/boite-reception/envoye-detail/{id}', [BoiteReceptionController::class, 'showEnvoye'])->name('boite-reception.showEnvoye');
Route::post('/boite-reception/store', [BoiteReceptionController::class, 'store'])->name('boite-reception.store');
// Lettre automatique
Route::get('/entraineur/{entraineurId}/contacter', [BoiteReceptionController::class, 'composeMessage'])->name('compose.message');
Route::get('/compose/{replyTo?}', [BoiteReceptionController::class, 'compose'])->name('boite-reception.compose');
// Itinéraire pour la suppression massive de messages
Route::post('/boite-reception/destroy-multiple', [BoiteReceptionController::class, 'destroyMultiple'])->name('boite-reception.destroyMultiple');

Route::get('/messages-entraineur', function () {
    return view('yunevo/messages-entraineur');
});

Route::get('/form-entraineur-compte', function () {
    return view('yunevo/form-entraineur-compte');
});

Route::get('/supprimer_compte', function () {
    return view('yunevo/supprimer_compte');
});

Route::get('/form-client-compte', function () {
    return view('yunevo/form-client-compte');
});



