<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function updateUserType(Request $request)
    {
        $request->validate([
            'user_type' => 'required|in:client,entraineur',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->user_type = $request->user_type;
        $user->save();

        // Reconnexion de l'utilisateur pour rafraîchir la session
        Auth::login($user, true);

        // Redirection par type d'utilisateur
        if ($user->user_type == 'client') {
            return redirect('/yunevo/form-client-compte');
        } elseif ($user->user_type == 'entraineur') {
            return redirect('/yunevo/form-entraineur-compte');
        }
        return redirect('/dashboard');
    }
}
