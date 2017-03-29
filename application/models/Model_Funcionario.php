<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Model_Funcionario
 *
 * @author denner.fernandes
 */
class Model_Funcionario extends MY_Model {

    const TABELA = 'FUNCIONARIO';
    const ID = 'ID_FUNCIONARIO';
    const EMPRESA = 'CD_EMPRESA';
    const FILIAL = 'CD_FILIAL';
    const CHAPA = 'CD_CHAPA';
    const NOME = 'NM_NOME';
    const BANCO = 'CD_BANCO';
    const AGENCIA = 'CD_AGENCIA';
    const DIGITOAG = 'CD_AGENCIA_DIGITO';
    const CONTA = 'CD_CONTA';
    const DIGITO = 'CD_CONTA_DIGITO';
    const CPF = 'CD_CPF';
    const CCUSTO = 'CD_CCUSTO';
    const SECAO = 'CD_SECAO';
    const SITUACAO = 'CD_SITUACAO';
    const PERIODO = 'CD_PERIODO_PAGTO';
    const LOGRADOURO = 'DS_LOGRADOURO';
    const NUMERO = 'DS_NUMERO';
    const COMPL = 'DS_COMPL';
    const BAIRRO = 'DS_BAIRRO';
    const CIDADE = 'DS_CIDADE';
    const CEP = 'DS_CEP';
    const UF = 'DS_UF';

    private $RM;

    public function __construct() {
        parent::__construct();
        $this->RM = $this->load->database('rm', TRUE);
    }

    public function getFilialRM($coligada, $cpf) {

        $query = $this->RM->query('SELECT PF.CODFILIAL ' . self::FILIAL . ', PF.CODSITUACAO ' . self::SITUACAO . '
                         FROM RM.PFUNC PF
                         INNER JOIN RM.PPESSOA PP
                            ON PP.CODIGO = PF.CODPESSOA
                         WHERE PP.CPF = \'' . $cpf . '\'
                           AND PF.CODCOLIGADA = ' . $coligada
        );

        if ($query->num_rows > 0) {
            return $query->result_array();
        } else {
            return NULL;
        }
    }

    public function getFuncionariosRM($coligada, $chapa, $cpf) {

        $query = $this->RM->query('SELECT PF.CODCOLIGADA ' . self::EMPRESA . ' ,
                                PF.CHAPA ' . self::CHAPA . ',
                                PF.NOME ' . self::NOME . ',
                                PF.CODBANCOPAGTO ' . self::BANCO . ',
                                PF.CODAGENCIAPAGTO ' . self::AGENCIA . ',
                                GA.DIGAG ' . self::DIGITOAG . ',
                                REPLACE(REPLACE(PF.CONTAPAGAMENTO, \'.\'), \'-\') ' . self::CONTA . ',
                                PF.CODSECAO ' . self::SECAO . ',
                                PC.CODCCUSTO ' . self::CCUSTO . ',
                                ST.DESCRICAO ' . self::SITUACAO . ',
                                CR.DESCRICAO ' . self::PERIODO . ',
                                PF.CODFILIAL ' . self::FILIAL . ',
                                REGEXP_REPLACE(LPAD(PP.CPF, 11, \'0\'), \'([0-9]{3})([0-9]{3})([0-9]{3})([0-9]{2})\',\'\1.\2.\3-\4\') ' . self::CPF . ',
                                PP.RUA ' . self::LOGRADOURO . ',
                                PP.NUMERO ' . self::NUMERO . ',
                                PP.COMPLEMENTO ' . self::COMPL . ',
                                PP.BAIRRO ' . self::BAIRRO . ',
                                PP.CIDADE ' . self::CIDADE . ',
                                PP.ESTADO ' . self::UF . ',
                                REPLACE(REPLACE(PP.CEP, \'-\', \'\'), \' \', \'\') ' . self::CEP . '
                         FROM RM.PFUNC PF
                         LEFT JOIN RM.PCODSITUACAO ST
                            ON ST.CODCLIENTE = PF.CODSITUACAO
                         LEFT JOIN RM.PCODRECEB CR
                            ON CR.CODCLIENTE = PF.CODRECEBIMENTO
                         LEFT JOIN RM.GAGENCIA GA
                            ON PF.CODBANCOPAGTO    = GA.NUMBANCO
                            AND PF.CODAGENCIAPAGTO = GA.NUMAGENCIA
                         LEFT JOIN RM.PPESSOA PP
                            ON PP.CODIGO = PF.CODPESSOA
                         LEFT JOIN RM.PSECAO PS
                            ON PS.CODCOLIGADA = PF.CODCOLIGADA
                            AND PS.CODIGO = PF.CODSECAO
                         LEFT JOIN RM.PCCUSTO PC
                            ON PC.CODCOLIGADA = PS.CODCOLIGADA
                            AND PC.CODCCUSTO = PS.NROCENCUSTOCONT
                         WHERE CHAPA = \'' . $chapa . '\'
                           AND PP.CPF = \'' . $cpf . '\'
                           AND PF.CODCOLIGADA = ' . $coligada
        );
        if ($query->num_rows > 0) {
            return $query->result_array();
        } else {
            return NULL;
        }
    }

    public function getAll($page = NULL, $paginacao = NULL) {

        try {

            $return = NULL;

            $this->db->select('FU.*, EM.' . Model_Empresa::NOME . ' EMPRESA, BA.' . Model_Banco::NOME . ' BANCO, FI.' . Model_Filial::NOME . ' FILIAL');
            $this->db->order_by(self::ID, "ASC");
            $this->db->join(Model_Empresa::TABELA . ' EM', 'EM.' . Model_Empresa::COLIGADA . ' = FU.' . self::EMPRESA);
            $this->db->join(Model_Banco::TABELA . ' BA', 'BA.' . Model_Banco::COD . ' = FU.' . self::BANCO);
            $this->db->join(Model_Filial::TABELA . ' FI', 'FI.' . Model_Filial::FILIAL . ' = FU.' . self::FILIAL . ' AND FI.' . Model_Filial::EMPRESA . ' = FU.' . self::EMPRESA, 'LEFT');

            if (!is_null($page) && !is_null($paginacao)) {
                $query = $this->db->get(self::TABELA . ' FU', $page, $paginacao);
            } else {
                $query = $this->db->get(self::TABELA . ' FU');
            }

            $return = $query->result_array();

            if (!is_null($return)) {
                return $return;
            } else {
                throw new Exception('Não há registros.');
            }
        } catch (Exception $exc) {
            return $exc->getMessage();
        }
    }

    public function getForExcel($chapa, $banco, $agencia, $digAgencia = NULL, $conta, $digConta = NULL, $cpf) {

        if (!is_null($cpf)) {
            $query = $this->RM->query('SELECT PF.CHAPA ' . self::CHAPA . ',
                                PF.NOME ' . self::NOME . ',
                                PF.CODSITUACAO ' . self::SITUACAO . ',
                                REGEXP_REPLACE(LPAD(PP.CPF, 11, \'0\'), \'([0-9]{3})([0-9]{3})([0-9]{3})([0-9]{2})\',\'\1.\2.\3-\4\') ' . self::CPF . '
                         FROM RM.PFUNC PF
                         LEFT JOIN RM.PPESSOA PP
                            ON PP.CODIGO = PF.CODPESSOA
                         WHERE PP.CPF = \'' . $cpf . '\''
            );
            if ($query->num_rows > 0) {
                return $query->result_array();
            }
        }
        if (!is_null($chapa)) {

            $query = $this->RM->query('SELECT PF.CHAPA ' . self::CHAPA . ',
                                PF.NOME ' . self::NOME . ',
                                PF.CODSITUACAO ' . self::SITUACAO . ',
                                REGEXP_REPLACE(LPAD(PP.CPF, 11, \'0\'), \'([0-9]{3})([0-9]{3})([0-9]{3})([0-9]{2})\',\'\1.\2.\3-\4\') ' . self::CPF . '
                         FROM RM.PFUNC PF
                         LEFT JOIN RM.PPESSOA PP
                            ON PP.CODIGO = PF.CODPESSOA
                         WHERE PF.CHAPA = \'' . $chapa . '\''
            );
            if ($query->num_rows > 0) {
                return $query->result_array();
            }
        }

        if (is_null($digAgencia)) {
            $dig = '';
        } else {
            $dig = ' AND GA.DIGAG = \'' . $digAgencia . '\'';
        }

        if (is_null($digConta)) {
            $digC = '';
        } else {
            $digC = ' AND SUBSTR(TRIM(PF.CONTAPAGAMENTO), -1, 1) = \'' . $digConta . '\'';
        }

        $query = $this->RM->query('SELECT PF.CHAPA ' . self::CHAPA . ',
                                PF.NOME ' . self::NOME . ',
                                PF.CODSITUACAO ' . self::SITUACAO . ',
                                REGEXP_REPLACE(LPAD(PP.CPF, 11, \'0\'), \'([0-9]{3})([0-9]{3})([0-9]{3})([0-9]{2})\',\'\1.\2.\3-\4\') ' . self::CPF . '
                         FROM RM.PFUNC PF
                         LEFT JOIN RM.PPESSOA PP
                            ON PP.CODIGO = PF.CODPESSOA
                         LEFT JOIN RM.GAGENCIA GA
                            ON PF.CODBANCOPAGTO    = GA.NUMBANCO
                            AND PF.CODAGENCIAPAGTO = GA.NUMAGENCIA
                         WHERE PF.CODBANCOPAGTO = ' . $banco . '
                           AND PF.CODAGENCIAPAGTO = \'' . $agencia . '\'
                           ' . $dig . $digC . '
                           AND TO_NUMBER(
                              SUBSTR(
                              REPLACE(
                                REPLACE(
                                  TRIM(PF.CONTAPAGAMENTO)
                                , \'-\', \'\')
                              , \'.\', \'\'), 1,
                                  LENGTH(
                                    REPLACE(
                                      REPLACE(
                                        TRIM(PF.CONTAPAGAMENTO)
                                      , \'-\', \'\')
                                    , \'.\', \'\')
                                  ) - 1
                                )
                              )  = ' . $conta
        );

        if ($query->num_rows > 0) {
            return $query->result_array();
        }

        if (is_null($digConta)) {
            $digC = '';
        } else {
            $digC = ' AND SUBSTR(TRIM(FH.CONTAPGTO), -1, 1) = \'' . $digConta . '\'';
        }

        $query = $this->RM->query('SELECT PF.CHAPA ' . self::CHAPA . ',
                                PF.NOME ' . self::NOME . ',
                                PF.CODSITUACAO ' . self::SITUACAO . ',
                                REGEXP_REPLACE(LPAD(PP.CPF, 11, \'0\'), \'([0-9]{3})([0-9]{3})([0-9]{3})([0-9]{2})\',\'\1.\2.\3-\4\') ' . self::CPF . '
                         FROM RM.PFUNC PF
                         LEFT JOIN RM.PPESSOA PP
                            ON PP.CODIGO = PF.CODPESSOA
                         LEFT JOIN RM.PFHSTCPGTO FH
                            ON FH.CODCOLIGADA = PF.CODCOLIGADA
                            AND FH.CHAPA = PF.CHAPA
                         LEFT JOIN RM.GAGENCIA GA
                            ON GA.NUMBANCO = FH.CODBANCOPGTO
                            AND GA.NUMAGENCIA = FH.CODAGENCIAPGTO
                         WHERE FH.CODBANCOPGTO = ' . $banco . '
                           AND FH.CODAGENCIAPGTO = \'' . $agencia . '\'
                           ' . $dig . $digC . '
                           AND TO_NUMBER(
                              SUBSTR(
                              REPLACE(
                                REPLACE(
                                  TRIM(FH.CONTAPGTO)
                                , \'-\', \'\')
                              , \'.\', \'\'), 1,
                                  LENGTH(
                                    REPLACE(
                                      REPLACE(
                                        TRIM(FH.CONTAPGTO)
                                      , \'-\', \'\')
                                    , \'.\', \'\')
                                  ) - 1
                                )
                              )  = ' . $conta
        );
        if ($query->num_rows > 0) {
            return $query->result_array();
        } else {
            return NULL;
        }
    }

    public function __destruct() {

    }

}
