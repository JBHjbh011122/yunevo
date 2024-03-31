<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class UserTypeController extends Controller
{
    public function showChooseTypeForm()
    {
        return view('yunevo/choose-type'); // Créer un fichier de vue pour afficher le formulaire de sélection
    }

    public function saveUserType(Request $request)
    {
        $userId = session('user_id');
        $userType = $request->input('user_type');

        $user = User::find($userId);
        if ($user) {
            $user->user_type = $userType;
            $user->save();

            // Déterminer la page vers laquelle rediriger en fonction du type d'utilisateur
            if ($userType == 'client') {
                return redirect('yunevo/form-client-compte');
            } elseif ($userType == 'entraineur') {
                return redirect('yunevo/form-entraineur-compte');
            }
        }
        return redirect()->intended('dashboard');
    }
}
