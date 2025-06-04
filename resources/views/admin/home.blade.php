@extends('layouts.app')

@section('title', 'Painel Inicial')

@section('content')
<style>
  @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');

  body, html {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #dbeafe, #bfdbfe);
    min-height: 100vh;
    color: #1e293b;
  }

  /* Container geral */
  .container {
    max-width: 1200px;
  }

  /* Layout principal com grid */
  .dashboard-grid {
    display: grid;
    grid-template-columns: 2fr 1.5fr;
    grid-gap: 2rem;
    margin-bottom: 3rem;
  }

  /* Painel grande para Alunos */
  .panel-large {
    background: #fff;
    border-radius: 1rem;
    padding: 2rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    display: flex;
    flex-direction: column;
    justify-content: center;
  }

  .panel-large .stat-icon {
    font-size: 5rem;
    color: #3b82f6;
    margin-bottom: 1rem;
  }

  .panel-large h2 {
    font-weight: 700;
    font-size: 3.5rem;
    margin-bottom: 0.25rem;
    color: #1e40af;
  }

  .panel-large h5 {
    font-weight: 600;
    font-size: 1.25rem;
    color: #2563eb;
    margin-bottom: 0.5rem;
  }

  .panel-large small {
    color: #475569;
  }

  /* Painéis menores para as outras estatísticas */
  .stats-small {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
  }

  .stat-card {
    background: #ffffffcc;
    border-radius: 1rem;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    padding: 1.5rem;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    display: flex;
    align-items: center;
    gap: 1rem;
  }
  .stat-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.12);
  }
  .stat-icon {
    font-size: 3rem;
    opacity: 0.85;
    color: #2563eb;
  }
  .stat-info h5 {
    margin: 0;
    font-weight: 600;
    font-size: 1.1rem;
  }
  .stat-info h2 {
    margin: 0;
    font-weight: 700;
    font-size: 2.2rem;
  }
  .stat-info small {
    color: #64748b;
  }

  /* Gestão rápida - cards em duas colunas */
  .manage-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
  }

  .manage-card {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 4px 8px rgb(0 0 0 / 0.05);
    padding: 1.75rem 1.5rem;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    transition: box-shadow 0.3s ease, background-color 0.3s ease;
    cursor: pointer;
  }
  .manage-card:hover {
    box-shadow: 0 8px 20px rgb(0 0 0 / 0.15);
    background-color: #e0e7ff;
  }
  .manage-icon {
    font-size: 2.6rem;
    color: #3b82f6;
    transition: color 0.3s ease;
    margin-bottom: 1rem;
  }
  .manage-card:hover .manage-icon {
    color: #2563eb;
  }
  .manage-card h4 {
    font-weight: 600;
    margin-bottom: 0.5rem;
  }
  .manage-card p {
    color: #64748b;
    flex-grow: 1;
  }
  .manage-card button {
    align-self: flex-end;
    font-weight: 600;
    border-radius: 0.5rem;
  }

  /* Título seção */
  h3.section-title {
    font-weight: 700;
    color: #2563eb;
    text-align: center;
    margin-bottom: 2rem;
  }

  /* Responsividade */
  @media (max-width: 991px) {
    .dashboard-grid {
      grid-template-columns: 1fr;
    }
    .stats-small {
      grid-template-columns: 1fr 1fr;
    }
    .manage-grid {
      grid-template-columns: 1fr;
    }
  }

  @media (max-width: 576px) {
    .stats-small {
      grid-template-columns: 1fr;
    }
  }

</style>

<div class="container py-5">

  <header class="mb-5 text-center">
    <h1 class="fw-bold display-5">Painel Inicial</h1>
    <p class="text-secondary fs-5">Visão geral rápida do sistema e acesso rápido às funções</p>
  </header>

  <section class="dashboard-grid">
    {{-- Painel grande de Alunos --}}
    @php
      $alunosCount = \App\Models\Aluno::count();
    @endphp
    <div class="panel-large">
      <i class="fas fa-user-graduate stat-icon"></i>
      <h5>Alunos Matriculados</h5>
      <h2>{{ $alunosCount }}</h2>
      <small>Atualmente ativos no sistema</small>
    </div>

    {{-- Estatísticas menores --}}
    @php
      $otherStats = [
        ['label' => 'Turmas', 'icon' => 'fa-users', 'count' => \App\Models\Turma::count(), 'text' => 'registradas'],
        ['label' => 'Comprovantes', 'icon' => 'fa-file-invoice', 'count' => \App\Models\Comprovante::count(), 'text' => 'enviados'],
        ['label' => 'Declarações', 'icon' => 'fa-file-signature', 'count' => \App\Models\Declaracao::count(), 'text' => 'emitidas'],
      ];
    @endphp
    <div class="stats-small">
      @foreach ($otherStats as $stat)
        <div class="stat-card">
          <i class="fas {{ $stat['icon'] }} stat-icon"></i>
          <div class="stat-info">
            <h5>{{ $stat['label'] }}</h5>
            <h2>{{ $stat['count'] }}</h2>
            <small>{{ $stat['text'] }}</small>
          </div>
        </div>
      @endforeach
    </div>
  </section>

  <section>
    <h3 class="section-title">Gestão Rápida</h3>
    @php
      $cards = [
        ['label' => 'Alunos', 'route' => 'admin.alunos.index', 'icon' => 'fa-user-graduate', 'desc' => 'Gerencie os alunos matriculados.'],
        ['label' => 'Turmas', 'route' => 'admin.turmas.index', 'icon' => 'fa-users', 'desc' => 'Visualize e organize as turmas.'],
        ['label' => 'Cursos', 'route' => 'admin.cursos.index', 'icon' => 'fa-book-open', 'desc' => 'Cadastre cursos e conteúdos.'],
        ['label' => 'Níveis', 'route' => 'admin.niveis.index', 'icon' => 'fa-layer-group', 'desc' => 'Classifique os cursos.'],
        ['label' => 'Categorias', 'route' => 'admin.categorias.index', 'icon' => 'fa-tags', 'desc' => 'Documentos ou cursos.'],
        ['label' => 'Comprovantes', 'route' => 'admin.comprovantes.index', 'icon' => 'fa-file-alt', 'desc' => 'Arquivos comprobatórios.'],
        ['label' => 'Declarações', 'route' => 'admin.declaracoes.index', 'icon' => 'fa-file-signature', 'desc' => 'Documentos para alunos.'],
        ['label' => 'Documentos', 'route' => 'admin.documentos.index', 'icon' => 'fa-folder-open', 'desc' => 'Gerencie os anexos.'],
      ];
    @endphp

    <div class="manage-grid">
      @foreach ($cards as $card)
        <a href="{{ route($card['route']) }}" class="text-decoration-none text-dark">
          <div class="manage-card">
            <i class="fas {{ $card['icon'] }} manage-icon"></i>
            <h4>{{ $card['label'] }}</h4>
            <p>{{ $card['desc'] }}</p>
            <button class="btn btn-primary btn-sm shadow-sm" type="button">
              Gerenciar {{ strtolower($card['label']) }}
              <i class="fas fa-arrow-right ms-1"></i>
            </button>
          </div>
        </a>
      @endforeach
    </div>
  </section>

</div>
@endsection
