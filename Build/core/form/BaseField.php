<?php


namespace app\core\form;

use app\core\Model;

/**
 *@author Yagya 
 * @package app\core\form
 */


abstract class BaseField
{
    public Model $model;
    public string $attribute;


    /**
     * @param \app\core\Model $model
     * @param string          $attribute
     */


    public function __construct(Model $model, string $attribute)
    {
        $this->model = $model;
        $this->attribute = $attribute;
    }



    /* abstract */
    public abstract  function renderInput(): string;


    public function __toString() //magic method 
    {

        return  sprintf(
            '<div class="form-group">
                <label>%s</label>
                      %s
                <div class="invalid-feedback">
                      %s
                </div>                
             </div>                                     
                ',
            $this->model->getLabel($this->attribute), //userfriendly label
            $this->renderInput(),
            $this->model->getFirstError($this->attribute)

        );
    }
}
