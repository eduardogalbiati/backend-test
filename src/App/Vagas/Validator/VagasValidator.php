<?php

namespace App\Vagas\Validator;

use App\Interfaces\ValidatorInterface;
use App\Exceptions\ValidatorException;
use Gump;

/**
 * Class VagasValidator.
 *
 * @author Eduardo Galbiati <eduardo.galbiati7@gmail.com>
 */
abstract class VagasValidator implements ValidatorInterface
{
    /**
     * Método de validação/limpeza.
     *
     * @param array $query
     *
     * @return array Com os dados validados
     */
    public static function validate(array $query)
    {
        $gump = new Gump();

        $gump->validation_rules(array(
            'title' => 'max_len,255',
            'description' => 'max_len,255',
            'cidade' => 'max_len,50',
            'field' => 'max_len,10',
            'order' => 'contains,asc desc',
        ));

        $gump->filter_rules(array(
            'title' => 'trim|sanitize_string',
            'description' => 'trim|sanitize_string',
            'cidade' => 'trim|sanitize_string',
            'field' => 'trim|sanitize_string',
            'order' => 'trim|sanitize_string',
        ));

        $validateData = $gump->run($query);

        if ($validateData === false) {
            throw new ValidatorException(json_encode($gump->get_errors_array(true)), 1);
        }

        return $validateData;
    }

    /**
     * Método para segregação dos filtros na query.
     *
     * @param array $query
     *
     * @return array Com os dados do filtro
     */
    public static function getFiltersFromQuery(array $query)
    {
        return [
            'title' => (isset($query['title']) ? $query['title'] : ''),
            'description' => (isset($query['description']) ? $query['description'] : ''),
            'cidade' => (isset($query['cidade']) ? $query['cidade'] : ''),
        ];
    }

    /**
     * Método para segregação da ordenação na query.
     *
     * @param array $query
     *
     * @return array Com os dados da ordenação
     */
    public static function getOrderFromQuery(array $query)
    {
        return [
            'order' => (isset($query['order']) ? $query['order'] : ''),
            'field' => (isset($query['field']) ? $query['field'] : ''),
        ];
    }
}
