<?php

namespace VisioCrudModeler\JQueryValidator;

use Zend\InputFilter\InputFilterAwareInterface;

class ValidatorManager implements InputFilterAwareInterface
{
    
    /**
     * 
     * @var InputFilter 
     */
    protected $inputFilter;
    
    /**
     * Template for validate plugin
     * @var string
     */
    protected $template = "
            (function(jQuery) {
                $('#%s').validate({
                        rules: {
                            %s
                        }
                    }
                );
            })(jQuery);"
    ;
    
    
    /**
     * Ommitet classed for generating jquery validate rules
     * @var array 
     */
    protected $classToOmmit = array(
     'Zend\Validator\InArray',
        
    );
    
    /**
     * Return prepared Jquery Validate Script
     * 
     * @param formName
     * @return string
     */
    public function getScript($formName)
    {
        $rules = '';
        
        foreach($this->getInputFilter()->getInputs() as $inputFilter){
            
            $name = $inputFilter->getName();
            
            if($inputFilter->isRequired()){
                $validatorsRules = ValidatorFactory::factory('Required', 'true')->getRule();
                
            }
            
            $validators = $inputFilter->getValidatorChain()->getValidators();
            if(!empty($validators)){
                foreach($validators as $validator){
                    $class = get_class($validator['instance']);
                    if(in_array($class, $this->classToOmmit)){
                        continue;
                    }
                    $validatorsRules .= ValidatorFactory::factory($class, $validator['instance'])->getRule();
                }
            }
            $rules .= 
                    " $name: {
                        $validatorsRules
                    },"
            ;
            
            $validatorsRules = '';
        }
        
        return sprintf($this->template, $formName, $rules);
        
    }

    /**
     * 
     * @param \Zend\InputFilter\InputFilterInterface $inputFilter
     */
    public function setInputFilter(\Zend\InputFilter\InputFilterInterface $inputFilter)
    {
        $this->inputFilter = $inputFilter;
    }

    /**
     * 
     * @return InputFilter
     */
    public function getInputFilter()
    {
        return $this->inputFilter;
    }
    
}
