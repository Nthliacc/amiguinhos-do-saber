<?php

class PessoasController extends BaseController {

    public function visualizarFormulario() {
        return View::make('formularios.cadastro');
    }

    public function cadastrarPessoa() {
        $input = Input::only(['nome', 'email', 'cpf', 'telefone', 'grupo_id']);

        $validator = Validator::make($input, [
            'nome' => 'required',
            'email' => 'required|email',
            'cpf' => 'required',
            'telefone' => 'required',
            'grupo_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return Redirect::to('/cadastro')->withErrors($validator)->withInput();
        }

        $input['cpf'] = preg_replace('/[^0-9]/', '', $input['cpf']);
        $input['telefone'] = preg_replace('/[^0-9]/', '', $input['telefone']);

        Pessoa::create($input);

        return Redirect::to('/cadastro')->with('success', 'Cadastro realizado com sucesso!');
    }
}