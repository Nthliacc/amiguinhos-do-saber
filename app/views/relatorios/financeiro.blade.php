@extends('layouts.main')

@section('title', 'Relatório Financeiro')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Relatório de Inadimplentes</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Telefone</th>
                <th>Qtd. Parcelas Não Pagas</th>
                <th>Valor Total Não Pago</th>
            </tr>
        </thead>
        <tbody>
            @foreach($relatorio as $item)
                <tr>
                    <td>{{ $item->nome }}</td>
                    <td>{{ $item->telefone }}</td>
                    <td>{{ $item->qtd_parcelas_nao_pagas }}</td>
                    <td>R$ {{ number_format($item->valor_total_nao_pago, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection