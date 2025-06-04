@extends('layouts.app')

@section('title', 'Gráficos de Horas por Turma')

@section('content')
<div class="container py-5">

    <header class="mb-5 text-center">
        <h1 class="fw-bold display-6 text-primary">
            <i class="fas fa-chart-bar me-2"></i>Horas Complementares por Aluno (por Turma)
        </h1>
        <p class="text-muted fst-italic">Visualize a distribuição das horas aprovadas em cada turma</p>
    </header>

    <form action="{{ route('admin.graficos') }}" method="GET" class="d-flex justify-content-center mb-5" role="search" aria-label="Seleção de Turma">
        <div class="input-group shadow-sm" style="max-width: 360px;">
            <label class="input-group-text bg-primary text-white" for="turma_id" id="labelTurma">Turma</label>
            <select name="turma_id" id="turma_id" class="form-select" aria-describedby="labelTurma" onchange="this.form.submit()">
                <option value="" disabled selected>Escolha a turma...</option>
                @foreach($turmas as $turma)
                    <option value="{{ $turma->id }}" {{ request('turma_id') == $turma->id ? 'selected' : '' }}>
                        {{ $turma->nome }}
                    </option>
                @endforeach
            </select>
        </div>
    </form>

    @if(isset($graficoData) && count($graficoData['labels']))
    <section aria-label="Gráfico de barras de horas aprovadas">
        <div class="card shadow-sm rounded-4 p-4 mx-auto" style="max-width: 720px;">
            <h5 class="text-center text-secondary mb-4 fw-semibold">Distribuição de Horas Aprovadas por Aluno</h5>
            <canvas id="graficoHoras" height="150" aria-describedby="descGrafico"></canvas>
            <p id="descGrafico" class="visually-hidden">
                Gráfico de barras mostrando horas aprovadas para cada aluno na turma selecionada.
            </p>
        </div>
    </section>
    @elseif(request()->has('turma_id'))
    <div class="alert alert-warning shadow-sm d-flex align-items-center justify-content-center gap-2 mx-auto" style="max-width: 480px;">
        <i class="fas fa-exclamation-triangle fs-3"></i>
        <span>Nenhum comprovante aprovado encontrado para esta turma.</span>
    </div>
    @endif

</div>
@endsection

@push('scripts')
@if(isset($graficoData) && count($graficoData['labels']))
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('graficoHoras').getContext('2d');

    // Criar gradiente vertical azul para o fundo das barras
    const gradient = ctx.createLinearGradient(0, 0, 0, 150);
    gradient.addColorStop(0, 'rgba(37, 99, 235, 0.9)');
    gradient.addColorStop(1, 'rgba(147, 197, 253, 0.7)');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($graficoData['labels']) !!},
            datasets: [{
                label: 'Horas Aprovadas',
                data: {!! json_encode($graficoData['horas']) !!},
                backgroundColor: gradient,
                borderColor: 'rgba(37, 99, 235, 1)',
                borderWidth: 1,
                borderRadius: 6,
                maxBarThickness: 48,
                hoverBackgroundColor: 'rgba(29, 78, 216, 0.85)'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                duration: 700,
                easing: 'easeOutQuart'
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    },
                    grid: {
                        color: '#e5e7eb',
                        borderColor: '#94a3b8'
                    },
                    title: {
                        display: true,
                        text: 'Horas',
                        font: {
                            size: 14,
                            weight: '600'
                        },
                        color: '#475569'
                    }
                },
                x: {
                    grid: {
                        display: false,
                    },
                    title: {
                        display: true,
                        text: 'Aluno',
                        font: {
                            size: 14,
                            weight: '600'
                        },
                        color: '#475569'
                    },
                    ticks: {
                        maxRotation: 45,
                        minRotation: 30,
                        autoSkip: false
                    }
                }
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(37, 99, 235, 0.85)',
                    titleFont: { weight: 'bold' },
                    callbacks: {
                        label: context => `${context.parsed.y} hora(s) aprovadas`
                    }
                }
            },
            interaction: {
                mode: 'nearest',
                intersect: false
            }
        }
    });
</script>
@endif
@endpush
