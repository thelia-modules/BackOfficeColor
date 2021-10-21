<?php
/**
 * Created by PhpStorm.
 * User: gbarral
 * Date: 27/09/15
 * Time: 10:05
 */

namespace BackOfficeColor\Form;


use Symfony\Component\Form\Extension\Core\Type\TextType;
use Thelia\Form\BaseForm;
use Thelia\Model\Lang;
use BackOfficeColor\BackOfficeColor;

class BackOfficeColorConfigForm extends BaseForm
{
    protected function buildForm()
    {
        $configVariables = BackOfficeColor::getModuleConfigVariables();

        foreach ($configVariables as $keyVariable => $configVariable) {

            $this->formBuilder
                ->add(
                    $keyVariable,
                    TextType::class,
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
}
