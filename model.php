<?php

class Dados_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getDados($dt_inicial = null, $dt_final = null, $limite = 0, $inicio = 0) 
    {    
        if($limite > 0){

            $query = $this->db->query("
            SELECT *
                FROM (SELECT INNER_QUERY.*, ROWNUM RNUM
                    FROM (  
                        SELECT TRANSACAO.CD_TRANSACAO, PESSOA.NOME, PESSOA.CPF, TRANSACAO.DT_TRANSACAO, CIDADE.NM_CIDADE
                          FROM TRANSACAO INNER JOIN PESSOA ON PESSOA.CPF = TRANSACAO.CPF
                                         INNER JOIN CIDADE ON CIDADE.CD_CIDADE = PESSOA.CD_CIDADE
                                         AND TRANSACAO.DT_TRANSACAO BETWEEN $dt_inicial AND $dt_final
                                         ORDER BY CIDADE.NM_CIDADE ASC
                        )INNER_QUERY
                        WHERE ROWNUM < ($limite + $inicio)
                        )
            WHERE RNUM >= $inicio
            ");
           
        }
        
        return $query->result_array();
    }
    
    function quantidade($dt_inicial = null, $dt_final = null)
    {
        $query = $this->db->query("
            SELECT TRANSACAO.CD_TRANSACAO
                    FROM TRANSACAO INNER JOIN PESSOA ON PESSOA.CPF = TRANSACAO.CPF
                                   INNER JOIN CIDADE ON CIDADE.CD_CIDADE = PESSOA.CD_CIDADE
                                   AND TRANSACAO.DT_TRANSACAO BETWEEN $dt_inicial AND $dt_final
        "); 
        
        return $query->num_rows();
    }  

}
