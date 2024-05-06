<?php
// app/Http/Controllers/UserController.php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('persona')->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $personas = Persona::all();
        $roles = ['admin', 'user', 'director bancario'];
        return view('users.create', compact('personas', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_usuario' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            'persona_id' => 'required|exists:personas,id',
            'rol' => 'required|string'
        ]);
    
        $user = new User();
        $user->username = $request->nombre_usuario; // Asegúrate de que 'username' es el nombre correcto de la columna en la base de datos
        $user->password = Hash::make($request->password);
        $user->persona_id = $request->persona_id;
        $user->rol = $request->rol;
        $user->save();
    
        return redirect()->route('users.index'); // O la ruta que corresponda
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $personas = Persona::all();
        $roles = ['admin', 'user', 'director bancario'];
        return view('users.edit', compact('user', 'personas', 'roles'));
    }

    public function update(Request $request, User $user)
{
    $request->validate([
        'password' => 'sometimes|nullable|string|min:8|confirmed',
        'rol' => 'required|string'
    ]);

    // Actualiza solo los campos que son permitidos cambiar
    $user->rol = $request->rol;  // Asegúrate de que estás utilizando el campo correcto para el rol

    // Solo actualiza la contraseña si se proporciona una nueva
    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    return redirect()->route('users.index')->with('success', 'Usuario actualizado correctamente.');
}

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index');
    }
}
