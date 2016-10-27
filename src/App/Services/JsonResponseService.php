<?Php

namespace App\Services;

use App\Interfaces\ResponseInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class JsonResponseService
 * @package App
 * @author Eduardo Galbiati <eduardo.galbiati7@gmail.com>
 */
class JsonResponseService implements ResponseInterface
{
	protected $response;
	protected $app;

	/**
     * Método construtor
     * @param Silex\Applcation $app;
     * @return void
     */
	function __construct($app){
		$this->app = $app;
	}

	/**
     * Método para construção de um response com uma exceção
     * @param Exception $e;
     * @return JsonResponse $response
     */
	public function makeWithException(\Exception $e)
	{
		$response = new JsonResponse();

		$response->setStatusCode(JsonResponse::HTTP_BAD_REQUEST);
		$response->setData([
			'status' => 0,
			'alerta' => 'Erro ao processar a requisição',
			'data' => [
				'exception' => [
					'message' => $e->getMessage(),
					'code' => $e->getCode(),
				]
			]
		]);
		
		return $response;

	}
	
	/**
     * Método para construção de um response com sucesso
     * @param Array $data
     * @param String $alerta
     * @return JsonResponse $response
     */
	public function makeWithSuccess($data = array(), $alerta)
	{
		$response = new JsonResponse();

		$response->setStatusCode(JsonResponse::HTTP_OK);
		$response->setData([
			'status' => 1,
			'alerta' => $alerta,
			'data' => $data,
		]);
		return $response;
	}
	
}