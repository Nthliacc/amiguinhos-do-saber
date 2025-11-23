<?php

class Pessoa extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'pessoas';

    protected $fillable = array('id', 'nome', 'email', 'cpf','telefone', 'grupo_id');

    public function grupo()
    {
        return $this->belongsTo('Grupo');
    }

}