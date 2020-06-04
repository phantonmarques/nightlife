<?php

    /**
     * Return description type user
     *
     * @param $type
     * @return string
     */
    function typeUserDescription($type){
        if ($type === 'a')
            $type = 'Administrador';
        elseif ($type === 'f')
            $type = 'Funcionário';
        elseif ($type === 'e')
            $type = 'Estabelecimento';
        elseif ($type === 'ef')
            $type = 'Funcionário Estabelecimento';
        elseif ($type === 'u')
            $type = 'Usuário Comum';

        return $type;
    }

    /**
     * Return format of cpf and cpf
     *
     * @param $value
     * @return string
     */
    function formatCnpjCpf($value)
    {
        $cnpj_cpf = preg_replace("/\D/", '', $value);

        if (strlen($cnpj_cpf) === 11) {
            return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cnpj_cpf);
        }

        return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cnpj_cpf);
    }

    /**
     * Return format of zip code
     *
     * @param $value
     * @return string
     */
    function formatZipCode($value)
    {
        if (strlen($value)===7)
            return '0'.substr($value, 0, 4) . '-' . substr($value, 4, 3);
        else
            return substr($value, 0, 5) . '-' . substr($value, 5, 3);
    }

    /**
     * Return format date br
     *
     * @param $value
     * @return string
     */
    function formatDate($value)
    {
        return date("d/m/Y", strtotime($value));
    }

    /**
     * Return format date br and time
     *
     * @param $value
     * @return string
     */
    function formatDateHour($value)
    {
        return date("d/m/Y H:i:s", strtotime($value));
    }

    /**
     * Return format time
     *
     * @param $value
     * @return string
     */
    function formatHour($value)
    {
        return date("H:i", strtotime($value));
    }

    /**
     * Return format situation
     * @param $situation
     * @return mixed|string
     */
    function formatSituation($situation)
    {
        $situations = [
            'waiting' => 'Aguardando Atendimento',
            'analyze' => 'Em análise',
            'development' => 'Em desenvolvimento',
            'closed' => 'Encerrado'
        ];

        return isset($situations[$situation]) ? $situations[$situation] : '';
    }
