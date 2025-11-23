# ✅ **Solução — Processo Seletivo Proesc (Analista N3)**

Este repositório contém todas as entregas solicitadas no desafio técnico do processo seletivo Proesc.
Cada item foi implementado seguindo os requisitos do enunciado, utilizando **PHP 5.6**, **Laravel**, **PostgreSQL**, **HTML/CSS**, além de consultas SQL quando necessário.

---

# 📌 **1. Relatório Financeiro — SQL e Visualização**

**Consulta solicitada:** listar todas as pessoas que **não pagaram mensalidades**, trazendo:

* nome
* telefone
* quantidade de parcelas não pagas
* valor total em aberto

**Arquivo da entrega:**
- `sql/relatorio_financeiro.sql`
- `app/controllers/FinanceiroController.php`
- `app/views/relatorios/financeiro.blade.php`

**Consulta desenvolvida:**
```sql
SELECT 
    p.nome,
    p.telefone,
    COUNT(pa.id) AS qtd_parcelas_nao_pagas,
    SUM(pa.valor) AS valor_total_nao_pago
FROM pessoas p
JOIN debitos d ON d.pessoa_id = p.id
JOIN parcelas pa ON pa.debito_id = d.id
WHERE pa.pago = FALSE
GROUP BY p.nome, p.telefone
ORDER BY p.nome;
```

Visualização disponível em `/relatorio-financeiro`.

---

# 📌 **2. Ajuste de Boletim — Cálculo com Peso nos Bimestres (PHP)**

Implementado conforme solicitado:

Fórmula →
`(1bim + 2bim + (3bim * 2) + (4bim * 2)) / 6`

**Arquivo da entrega:**
- `app/Services/NotasFormatar.php`

---

# 📌 **3. Novo Requisito — Arredondamento ≥ 0.7 (PHP)**

Notas finais com frações ≥ 0.7 são arredondadas para o próximo inteiro.

**Arquivo da entrega:**
- `app/Services/NotasFormatar.php`

**Lógica implementada:**
```php
protected function arredondamento3($valor_nota)
{
    $parte_decimal = $valor_nota - floor($valor_nota);
    if ($parte_decimal >= 0.7) {
        return ceil($valor_nota);
    }
    return floor($valor_nota);
}
```

---

# 📌 **4. Ajuste de Boletim — Layout + Notas Vermelhas**

Incluído no boletim:

* nota mínima: **70**
* nota máxima: **100**
* destaque automático de nota vermelha (abaixo de 70)
* aplicação das regras do cálculo dos itens 2 e 3

**Arquivos da entrega:**
- `app/views/relatorios/boletim.blade.php`
- `app/controllers/BoletimController.php`

Exemplo de regra aplicada no Blade:
```php
<td @if($nota !== null && $nota < 70) style="color: red; font-weight: bold;" @endif>
    {{ $nota !== null ? $nota : '-' }}
</td>
```

![Imagem com resultado final do Boletim](boletim.png)

---

# 📌 **5. Cadastro de Pessoas — Correção e Funcionamento**

Corrigido e validado no controller:

* Normalização do CPF e telefone (remoção de caracteres não numéricos)
* Validação dos campos obrigatórios
* Cadastro funcional via formulário

**Arquivo:**
- `app/controllers/PessoasController.php`
- `app/views/formularios/cadastro.blade.php`
- `models/Pessoa.php`

---

# 📌 **6. Importação de Pessoas via Planilha (CSV)**

Implementado importador completo, com:

* remoção de acentos
* normalização de CPF e telefone
* detecção do grupo pela versão não acentuada
* inserção direta no PostgreSQL
* tratamento de erros

**Arquivo da entrega:**
- `app/Http/Controllers/ImportController.php`
- `storage/import/dados.csv`

Comando disponível em:
```
/importar-pessoas
```

---

# ▶️ **Como rodar o projeto**

Para iniciá-lo, siga os passos abaixo:

1 -  Clone o projeto para o seu computador:
```bash
$ git clone https://github.com/v-gama/processo_seletivo.git
```

2 - Entre na pasta do projeto
```bash
$ cd processo_seletivo
```
3 - Instale as depêndencias

```bash
$ sudo add-apt-repository ppa:ondrej/php
```

```bash
$ sudo apt install php5.6 -y
```

```bash
$ curl -sS https://getcomposer.org/installer | php
```

```bash
$ composer install
```

4 - Crie o arquivo arquivo .env.local.php copiando o arquivo [.env.local.example.php](.env.local.example.php) e configure com as informações do seu banco local

5 - Rode as migrations
```bash
$ php artisan migrate
```
6 - Rode o seeder
```bash
$ php artisan db:seed
```
7 - Inicie o projeto:
```bash
$ php artisan serve
```

---

# 📬 **Entrega**

Todas as solicitações foram implementadas com foco em:

* clareza
* consistência analítica
* performance dentro das limitações do Laravel 5.1 / PHP 5.6
* cuidados com dados sensíveis e normalização

Em caso de dúvidas, estou à disposição.