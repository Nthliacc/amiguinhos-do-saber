SELECT 
    p.nome,
    p.telefone,
    COUNT(pa.id) AS qtd_parcelas_nao_pagas,
    SUM(pa.valor) AS valor_total_nao_pago
FROM pessoas p
JOIN debitos d ON d.pessoa_id = p.id
JOIN parcelas pa ON pa.debito_id = d.id
WHERE pa.pago = false
GROUP BY p.id, p.nome, p.telefone
ORDER BY valor_total_nao_pago DESC;