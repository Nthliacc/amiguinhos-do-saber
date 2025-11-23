<?php

use Illuminate\Support\Facades\DB;

class ImportController extends BaseController
{
    public function importarPessoas()
    {
        $path = storage_path('import/dados.csv');

        if (!file_exists($path)) {
            return "Arquivo CSV não encontrado em: {$path}";
        }

        $delimiter = ',';
        $enclosure = '"';

        $importados = 0;

        if (($handle = fopen($path, 'r')) !== false) {

            $header = fgetcsv($handle, 0, $delimiter, $enclosure);

            $removeBom = function ($str) {
                return preg_replace('/^\xEF\xBB\xBF/', '', $str);
            };

            DB::beginTransaction();

            try {
                while (($row = fgetcsv($handle, 0, $delimiter, $enclosure)) !== false) {
                    if (count($row) < 5) {
                        continue;
                    }

                    $nome     = $removeBom(trim($row[0]));
                    $email    = trim($row[1]);
                    $cpfRaw   = trim($row[2]);
                    $telRaw   = trim($row[3]);
                    $grupoRaw = trim($row[4]);

                    $cpf = preg_replace('/\D/', '', $cpfRaw);
                    $telefone = preg_replace('/\D/', '', $telRaw);

                    if (empty($nome) || empty($email) || empty($cpf)) {
                        continue;
                    }

                    $grupoNormalizado = $this->removerAcentos(mb_strtoupper(trim($grupoRaw)));
                    $grupos = Grupo::all();
                    $grupo = null;

                    foreach ($grupos as $g) {
                        $nomeGrupoNormalizado = $this->removerAcentos(mb_strtoupper(trim($g->nome)));
                        if ($nomeGrupoNormalizado === $grupoNormalizado) {
                            $grupo = $g;
                            break;
                        }
                    }                    
                
                    if (!$grupo) {
                        DB::rollBack();
                        return "Grupo não encontrado para a linha com nome: {$nome} (grupo fornecido: '{$grupoRaw}')";
                    }

                    Pessoa::create([
                        'nome'      => $nome,
                        'email'     => $email,
                        'cpf'       => $cpf,
                        'telefone'  => $telefone,
                        'grupo_id'  => $grupo->id,
                    ]);

                    $importados++;
                }

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                return "Erro durante importação: " . $e->getMessage();
            } finally {
                fclose($handle);
            }

            return "Importação finalizada. Registros importados: {$importados}";
        }

        return "Não foi possível abrir o arquivo CSV.";
    }

    function removerAcentos($string)
    {
        return preg_replace(
            [
                '/(á|à|ã|â|ä)/u',
                '/(Á|À|Ã|Â|Ä)/u',
                '/(é|è|ê|ë)/u',
                '/(É|È|Ê|Ë)/u',
                '/(í|ì|î|ï)/u',
                '/(Í|Ì|Î|Ï)/u',
                '/(ó|ò|õ|ô|ö)/u',
                '/(Ó|Ò|Õ|Ô|Ö)/u',
                '/(ú|ù|û|ü)/u',
                '/(Ú|Ù|Û|Ü)/u',
                '/(ñ)/u','/(Ñ)/u'
            ],
            explode(' ', 'a A e E i I o O u U n N'),
            $string
        );
    }
}
