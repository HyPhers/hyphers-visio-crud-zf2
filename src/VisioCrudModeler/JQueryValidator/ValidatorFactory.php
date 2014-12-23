<?php
namespace VisioCrudModeler\JQueryValidator;

/**
 * Factory for JqueryValidators
 *
 * @author Piotr Duda <piotr.duda@dentsuaegis.com, dudapiotrek@gmail.com>
 * @link https://github.com/HyPhers/hyphers-visio-crud-zf2
 * @copyright Copyright (c) 2014 HyPHPers Isobar Poland (Piotr Duda , Przemysław Wlodkowski, Bartlomiej Wereszczynski , Jacek Pawelec , Robert Bodych)
 * @license New BSD License
 *
 */
class ValidatorFactory
{

    /**
     * Mapper between Zend Validate Class and Jquery equivalent
     *
     * @var array
     */
    public static $mapper = array(
        'Required' => 'VisioCrudModeler\JQueryValidator\Validator\Required',
        'Zend\Validator\StringLength' => 'VisioCrudModeler\JQueryValidator\Validator\StringLength',
        'Zend\Validator\EmailAddress' => 'VisioCrudModeler\JQueryValidator\Validator\Email',
        'Zend\Validator\Digits' => 'VisioCrudModeler\JQueryValidator\Validator\Digits',
        'Zend\Validator\GreaterThan' => 'VisioCrudModeler\JQueryValidator\Validator\Min',
        'Zend\Validator\LessThan' => 'VisioCrudModeler\JQueryValidator\Validator\Max',
        'Zend\Validator\Between' => 'VisioCrudModeler\JQueryValidator\Validator\Range'
    );

    /**
     *
     * Factory Validator
     *
     * @param string $name
     * @param mixed $validatorOrValue
     * @return \VisioCrudModeler\JQueryValidator\ValidatorInterface
     * @throws \Exception
     */
    public static function factory($name, $validatorOrValue = false)
    {
        if (array_key_exists($name, self::$mapper)) {
            $className = self::$mapper[$name];
            $validator = new $className($validatorOrValue);
            return $validator;
        } else {
            throw new \Exception("Given validator doesn't not exists: " . $name);
        }
    }
}
