<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AlunoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\NivelController;
use App\Http\Controllers\TurmaController;
use App\Http\Controllers\ComprovanteController;
use App\Http\Controllers\DeclaracaoController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Aluno\HomeController as AlunoHomeController;
use App\Http\Controllers\Aluno\ComprovanteAlunoController;
use App\Http\Controllers\Admin\GraficoController;

use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsAluno;


Route::get('/', fn () => redirect('/login'));

Route::get('/dashboard', function () {
    if (Auth::check() && Auth::user()->is_admin) {
        return redirect()->route('admin.home');
    } elseif (Auth::check()) {
        return redirect()->route('aluno.home');
    }
    return redirect('/login');
})->middleware(['auth'])->name('dashboard');


Route::middleware(['auth', IsAluno::class])->prefix('aluno')->name('aluno.')->group(function () {
    Route::get('/home', [AlunoHomeController::class, 'index'])->name('home');
    Route::get('comprovantes', [ComprovanteAlunoController::class, 'index'])->name('comprovantes.index');
    Route::get('comprovantes/create', [ComprovanteAlunoController::class, 'create'])->name('comprovantes.create');
    Route::post('comprovantes', [ComprovanteAlunoController::class, 'store'])->name('comprovantes.store');

    // Futuro: declarações
    // Route::get('declaracao', [DeclaracaoAlunoController::class, 'show'])->name('declaracao');
});


Route::middleware(['auth', IsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/home', [AdminHomeController::class, 'index'])->name('home');

    // CRUDs
    Route::resources([
        'alunos' => AlunoController::class,
        'categorias' => CategoriaController::class,
        'cursos' => CursoController::class,
        'niveis' => NivelController::class,
        'turmas' => TurmaController::class,
        'comprovantes' => ComprovanteController::class,
        'declaracoes' => DeclaracaoController::class,
        'documentos' => DocumentoController::class,
    ]);

    Route::patch('/comprovantes/{id}/aprovar', [ComprovanteController::class, 'aprovar'])->name('comprovantes.aprovar');
    Route::patch('/comprovantes/{id}/reprovar', [ComprovanteController::class, 'reprovar'])->name('comprovantes.reprovar');


    Route::get('/graficos', [GraficoController::class, 'index'])->name('graficos');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';