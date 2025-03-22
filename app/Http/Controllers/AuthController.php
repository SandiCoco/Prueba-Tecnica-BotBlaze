<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccessTokenMail; 

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $user = User::where('email', $request->email)->first();

        // Verificar si el usuario existe y si la contraseña es correcta
        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);

            $token = $user->createToken('auth_token')->plainTextToken;

            // Enviar el token en el correo
            Mail::to($user->email)->send(new AccessTokenMail($token));


            return redirect('/productos');
        } else {
            return redirect()->back()->with('error', 'Correo o contraseña incorrectos.');
        }
    }

    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect('/productos');
        }

        return view('auth.login');
    }

    public function logout()
    {
        Auth::logout();

        return redirect('/login');
    }
}
