@extends('layouts.app')

@section('title', 'Turmas')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="mb-0">Turmas</h1>
    <a href="{{ route('admin.turmas.create') }}" class="btn btn-primary">Nova Turma</a>
</div>

@if($turmas->isEmpty())
    <div class="alert alert-info text-center">
        Nenhuma turma cadastrada.
    </div>
@else
    <div class="row g-4">
        @foreach($turmas as $turma)
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $turma->nome ?? '—' }}</h5>
                        <p class="card-text mb-1"><strong>Curso:</strong> {{ $turma->curso->nome ?? '—' }}</p>
                        <p class="card-text mb-1"><strong>Nível:</strong> {{ $turma->nivel->nome ?? '—' }}</p>
                        <p class="card-text mb-3"><strong>Ano:</strong> {{ $turma->ano }}</p>

                        <div class="mt-auto d-flex justify-content-between">
                            <a href="{{ route('admin.turmas.show', $turma) }}" class="btn btn-sm btn-info">Ver</a>
                            <a href="{{ route('admin.turmas.edit', $turma) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('admin.turmas.destroy', $turma) }}" method="POST" onsubmit="return confirm('Tem certeza?')" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" type="submit">Excluir</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection
