<?php

namespace App\Interfaces;

/**
 * Interface ValidatorInterface.
 *
 * @author Eduardo Galbiati <eduardo.galbiati7@gmail.com>
 */
interface ValidatorInterface
{
    /**
     * Método de validação/limpeza.
     *
     * @param array $query
     *
     * @return array Com os dados validados
     */
    public static function validate(array $query);
}
