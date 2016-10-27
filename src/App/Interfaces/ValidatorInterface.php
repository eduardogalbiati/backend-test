<?php

namespace App\Interfaces;

/**
 * Interface ValidatorInterface
 * @package App
 * @author Eduardo Galbiati <eduardo.galbiati7@gmail.com>
 */
interface ValidatorInterface
{
	/**
     * Método de validação/limpeza
     * @param Array $query
     * @return Array Com os dados validados
     */
	public static function validate(array $query);
}