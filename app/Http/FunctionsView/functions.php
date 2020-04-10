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