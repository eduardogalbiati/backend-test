<?php

namespace App\Interfaces;

/**
 * Interface ResponseInterface
 * @package App
 * @author Eduardo Galbiati <eduardo.galbiati7@gmail.com>
 */
interface ResponseInterface
{
	/**
     * Método para construção de um response com uma exceção
     * @param Exception $e;
     * @return JsonResponse $response
     */
	public function makeWithException(\Exception $e);

	/**
     * Método para construção de um response com sucesso
     * @param Array $data
     * @param String $alerta
     * @return JsonResponse $response
     */
	public function makeWithSuccess($data = array(), $alerta);
}