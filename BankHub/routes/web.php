<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CuentaBancariaController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\TransaccionController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use App\Http\Middleware\AdminAccessMiddleware;



Route::get('/', function () {
    return view('welcome');
});

// Ruta de POST para manejar el inicio de sesión
Route::post('/login', function (Request $request) {
    $credentials = $request->only('username', 'password');
    \Log::debug('Intento de inicio de sesión', $credentials);

    if (Auth::attempt($credentials)) {
        // Redirigir según el rol del usuario
        if (Auth::user()->rol === 'admin') {
            return redirect('/admin');
        } elseif (Auth::user()->rol === 'director bancario') {
            return redirect('/director/departamentos');
        } else {
            return redirect('/user');
        }
    }

    return back()->withErrors([
        'username' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
    ]);
})->name('login');

// Rutas para administradores
Route::middleware(['auth', AdminAccessMiddleware::class])->group(function () {
    Route::view('/admin', 'admin')->name('admin.dashboard');
    // Otras rutas que requieran acceso de administrador...

    // Rutas para las operaciones CRUD de los controladores
    Route::resource('personas', PersonaController::class);
    Route::resource('cuentas_bancarias', CuentaBancariaController::class);
    Route::resource('transacciones', TransaccionController::class);
    Route::resource('users', UserController::class);
    Route::put('transacciones/{transaccion}', 'TransaccionController@update')->name('transacciones.update');

    Route::get('/personas/{id}/data', [PersonaController::class, 'getData'])->name('personas.data');
});

// Asegúrate de que esta ruta solo sea accesible para usuarios autenticados
Route::middleware('auth')->get('/director/departamentos', function () {
    if (auth()->user()->rol !== 'director bancario') {
        // Redirige al usuario si no tiene el rol requerido
        return redirect('/home')->withErrors('Acceso denegado. Solo para directores bancarios.');
    }

    $resultados = DB::table('personas as p')
        ->leftJoin('cuentas_bancarias as cb', 'p.id', '=', 'cb.persona_id')
        ->leftJoin('transacciones as t', 'cb.id', '=', 't.cuenta_bancaria_id')
        ->select(
            'p.departamento',
            DB::raw("COALESCE(SUM(t.monto), 0) as total_monto"),
            DB::raw("CASE 
                        WHEN COALESCE(SUM(t.monto), 0) > 50000 THEN 'Alto'
                        WHEN COALESCE(SUM(t.monto), 0) > 20000 THEN 'Medio'
                        ELSE 'Bajo'
                     END AS categoria_monto")
        )
        ->groupBy('p.departamento')
        ->get();

    return view('director.departamentos', ['resultados' => $resultados]);
})->name('director.departamentos');


// Rutas para usuarios autenticados que no sean administradores
Route::middleware('auth')->group(function () {
    Route::view('/user', 'user')->name('user.dashboard');
    // Otras rutas para usuarios autenticados...

    // Por ejemplo, una ruta de perfil de usuario
    // Route::get('/perfil', [UserController::class, 'perfil'])->name('perfil');
});

// Ruta predeterminada para cerrar sesión
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');
