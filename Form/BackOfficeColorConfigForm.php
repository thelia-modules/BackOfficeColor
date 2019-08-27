<?php
/**
 * Created by PhpStorm.
 * User: gbarral
 * Date: 27/09/15
 * Time: 10:05
 */

namespace BackOfficeColor\Form;


use Thelia\Form\BaseForm;
use Thelia\Model\Lang;
use BackOfficeColor\BackOfficeColor;

class BackOfficeColorConfigForm extends BaseForm
{

    /**
     *
     * in this function you add all the fields you need for your Form.
     * Form this you have to call add method on $this->formBuilder attribute :
     *
     * $this->formBuilder->add("name", "text")
     *   ->add("email", "email", array(
     *           "attr" => array(
     *               "class" => "field"
     *           ),
     *           "label" => "email",
     *           "constraints" => array(
     *               new \Symfony\Component\Validator\Constraints\NotBlank()
     *           )
     *       )
     *   )
     *   ->add('age', 'integer');
     *
     * @return null
     */
    protected function buildForm()
    {
        $configVariables = BackOfficeColor::getModuleConfigVariables();

        foreach ($configVariables as $keyVariable => $configVariable) {

            $this->formBuilder
                ->add(
                    $keyVariable,
                    'text',
                    array(
                        'label' => $configVariable['label'],
                        'label_attr' => array(
                            'type' => $configVariable['type'],
                            'for' => $keyVariable,
                            'helper' => $configVariable['helper'],
                            'class' => $configVariable['class']
                        ),
                        'data' => BackOfficeColor::getConfigValue(
                            $keyVariable,
                            null,
                            Lang::getDefaultLanguage()->getLocale()
                        )
                    )
                )
            ;
        }


    }

    /**
     * @return string the name of you form. This name must be unique
     */
    public function getName()
    {
        return 'thelia_design_config_form';
    }
}
