<?php

class FinanceiroController extends BaseController {

	public function visualizarRelatorioFinanceiro()
	{
		// SQL equivalente em Query Builder do Laravel
		$relatorio = DB::table('pessoas as p')
			->join('debitos as d', 'd.pessoa_id', '=', 'p.id')
			->join('parcelas as pa', 'pa.debito_id', '=', 'd.id')
			->select(
				'p.nome',
				'p.telefone',
				DB::raw('COUNT(pa.id) as qtd_parcelas_nao_pagas'),
				DB::raw('SUM(pa.valor) as valor_total_nao_pago')
			)
			->where('pa.pago', '=', false)
			->groupBy('p.id', 'p.nome', 'p.telefone')
			->orderBy('valor_total_nao_pago', 'desc')
			->get();

		return View::make('relatorios.financeiro')->with('relatorio', $relatorio);
	}
}
