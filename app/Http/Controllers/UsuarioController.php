<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class UsuarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        /*
        $this->middleware('permission:ver-usuario|crear-usuario|borrar-usuario', ['only' => ['index']]);
        $this->middleware('permission:crear-usuario', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-usuario', ['only' => ['edit', 'update']]);
        $this->middleware('permission:borrar-usuario', ['only' => ['destroy']]); */
    }
    public function index()
    {
        // Realiza la paginación primero
        $usuarios = User::with('roles')
            ->select(['id', 'name', 'password', 'email'])
            ->paginate(100);
    
        // Aplica la transformación a los resultados paginados
        $usuarios->getCollection()->transform(function ($usuario) {
            $usuario->nombre_completo = $usuario->first_name . ' ' . $usuario->last_name;
            return $usuario;
        });
    
        // Obtener los roles
        $roles = Role::pluck('name', 'id')->toArray();
    
        // Retornar la vista con los datos
        return view('usuarios.index', compact('usuarios', 'roles'));
    }
    
    

    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('usuarios.crear', compact('roles'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'roles' => 'required',
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El email no es válido.',
            'email.unique' => 'El email ya está en uso.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'roles.required' => 'El rol es obligatorio.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error', 'Por favor corrige los errores.');
        }

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        return redirect()->route('usuarios.index')->with('info', 'Usuario creado exitosamente.');
    }

    public function edit($id)
{
    $usuario = User::with('roles')->findOrFail($id); // Obtener el usuario con roles
    $roles = Role::pluck('name', 'id')->toArray(); // Obtener todos los roles disponibles
    return view('usuarios.edit', compact('usuario', 'roles'));
}

public function show($id)
{
    // Encuentra al usuario por su ID
    $usuario = User::find($id);

    // Si no se encuentra el usuario, devuelve un error 404
    if (!$usuario) {
        abort(404);
    }

    // Retorna una vista y pasa el usuario encontrado
    return view('usuarios.show', compact('usuario'));
}

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:8',
            'roles' => 'required',
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El email no es válido.',
            'email.unique' => 'El email ya está en uso.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'roles.required' => 'El rol es obligatorio.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error', 'Por favor corrige los errores.');
        }

        $input = $request->except(['_method', '_token', 'roles']);

        if (!empty($request->input('password'))) {
            $input['password'] = Hash::make($request->input('password'));
        } else {
            unset($input['password']);
        }

        $user = User::find($id);
        $user->update($input);

        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $user->assignRole($request->input('roles'));

        return redirect()->route('usuarios.index')->with('update', 'Usuario actualizado exitosamente.');
    }

    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('usuarios.index')->with('delete', 'Usuario eliminado exitosamente.');
    }

    public function showChangePasswordForm()
    {
        return view('cambiar.password');
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ], [
            'current_password.required' => 'La contraseña actual es obligatoria.',
            'new_password.required' => 'La nueva contraseña es obligatoria.',
            'new_password.min' => 'La nueva contraseña debe tener al menos 8 caracteres.',
            'new_password.confirmed' => 'La confirmación de la nueva contraseña no coincide.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error', 'Por favor corrige los errores.');
        }

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'La contraseña actual es incorrecta.'])->with('error', 'La contraseña actual es incorrecta.');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();
    
        return redirect()->route('usuarios.index')->with('update', 'Contraseña actualizada exitosamente.');
    }

    
    public function buscarUsuario(Request $request) {
        $query = $request->get('query');
        $usuarios = User::where('name', 'LIKE', "%{$query}%")
                         ->orWhere('email', 'LIKE', "%{$query}%")
                         ->paginate(5);
    
        return response()->json($usuarios);
    }

    // En el controlador de usuarios para api/usuarios ruta web 
public function obtenerUsuario($id) {
    $usuario = User::find($id);
    return response()->json($usuario);
}


    
}
