@extends('layouts.main')

@section('title', 'BOLETIM')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">BOLETIM</h2>

    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered mb-4">
                <tbody>
                    <tr>
                        <th scope="row" class="text-left">ALUNO: {{ $aluno->nome }}</th>
                        <td class="text-left">TURMA: {{ $aluno->turma_nome }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <h4 class="text-center mb-3">NOTAS</h4>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">DISCIPLINAS</th>
                        @foreach ($diarios as $diario)
                            <th scope="col">{{ $diario->periodo_nome }}</th>
                        @endforeach
                        <th scope="col">NOTA FINAL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($disciplinas as $disciplina)
                        <tr>
                            <th scope="row">{{ $disciplina->disciplina_nome }}</th>

                            @foreach ($avaliacoes as $avaliacao)
                                @if ($avaliacao->disciplina_id == $disciplina->disciplina_id)
                                    @foreach ($notas_periodos as $nota_periodo)
                                        @if ($nota_periodo->avaliacao_id == $avaliacao->avaliacao_id && $nota_periodo->disciplina_id == $avaliacao->disciplina_id)
                                            <td class="{{ $nota_periodo->valor_nota < $nota_minima ? 'text-danger fw-bold' : '' }}">
                                                {{ $nota_periodo->valor_nota }}
                                            </td>
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach

                            @foreach ($notas_finais as $nota_final)
                                @if ($nota_final['disciplina_id'] == $disciplina->disciplina_id)
                                    <td class="{{ $nota_final['valor_nota'] < $nota_minima ? 'text-danger fw-bold' : '' }}">
                                        {{ $nota_final['valor_nota'] }}
                                    </td>
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection