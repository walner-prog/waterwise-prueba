<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit()
    {
        // Lógica para la edición del perfil
        return view('profile.edit'); // Reemplaza 'profile.edit' con la vista adecuada
    }

    /**
     * Update the profile.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validación para la foto de perfil
        ]);

        // Usar una transacción para asegurar la integridad de los datos
        DB::beginTransaction();

        try {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            if ($request->hasFile('profile_photo')) {
                $profilePhoto = $request->file('profile_photo');
                $photoName = 'profile_' . time() . '.' . $profilePhoto->getClientOriginalExtension();
                
                // Mover la foto de perfil al directorio público
                $profilePhoto->move(public_path('images'), $photoName);
                
                // Actualizar la foto de perfil del usuario
                $user->profile_photo = $photoName;
                $user->save();
            }

            DB::commit();

            return redirect()->route('home', $user)->with('info', 'El perfil se actualizó con éxito');
        } catch (\Exception $e) {
            // Revertir la transacción si algo falla
            DB::rollBack();

            // Manejar el error (puedes personalizar el mensaje de error según sea necesario)
            return redirect()->route('profile')->withErrors(['error' => 'Ocurrió un error al actualizar el perfil. Por favor, intenta nuevamente.']);
        }
    }
}
