<?php

namespace BackOfficeColor\Controller\Admin;

use BackOfficeColor\Form\BackOfficeColorConfigForm;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Model\Lang;
use Thelia\Tools\URL;
use BackOfficeColor\BackOfficeColor;

/**
 * Created by PhpStorm.
 * User: gbarral
 * Date: 27/09/15
 * Time: 11:30
 */
class BackOfficeColorAdminController extends BaseAdminController
{
    public function configuration()
    {

        $form = $this->createForm(BackOfficeColorConfigForm::class);

        try {
            $formValidate = $this->validateForm($form);

            foreach (BackOfficeColor::getModuleConfigVariables() as $keyVariable => $labelVariable) {

                BackOfficeColor::setConfigValue(
                    $keyVariable,
                    $formValidate->get($keyVariable)->getData(),
                    Lang::getDefaultLanguage()->getLocale(),
                    true
                );

            }

            $response = $this->generateRedirect(URL::getInstance()->absoluteUrl("/admin/module/BackOfficeColor"));

        } catch (\Exception $e) {
            $error = $e->getMessage();

            $form->setErrorMessage($error);

            $this
                ->getParserContext()
                ->addForm($form)
                ->setGeneralError($error)
            ;

            $response = $this->render(
                "module-configure",
                [
                    'module_code' => BackOfficeColor::MODULE_CODE
                ]
            );
        }

        return $response;
    }
}
