<?php

namespace BackOfficeColor\Hook;

use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;
use Thelia\Model\Lang;
use Thelia\Tools\URL;
use BackOfficeColor\BackOfficeColor;

/**
 * Created by PhpStorm.
 * User: gbarral
 * Date: 27/09/15
 * Time: 09:52
 */
class BackOfficeColorHook extends BaseHook
{
    /**
     * @param HookRenderEvent $event
     */
    public function moduleConfiguration(HookRenderEvent $event)
    {
        $event->add(
            $this->render(
                'hooks/module_configuration.html',
                [
                    'config_variables' => BackOfficeColor::getModuleConfigVariables()
                ]
            )
        );
    }

    /**
     * @param HookRenderEvent $event
     */
    public function mainHeadCss(HookRenderEvent $event)
    {
        $defaultBgColor = BackOfficeColor::getConfigValue(
            BackOfficeColor::MODULE_CONFIG_DEFAULT_BACKGROUND_COLOR,
            "",
            Lang::getDefaultLanguage()->getLocale()
        );
        $darkerBg = BackOfficeColor::adjustBrightness($defaultBgColor, -50);
        $lighterBg = BackOfficeColor::adjustBrightness($defaultBgColor, 50);

        $event->add(
            $this->render(
                'hooks/head_css.html',
                [
                    'default_bg_color' => $defaultBgColor,
                    'darker_bg' => $darkerBg,
                    'lighter_bg' => $lighterBg
                ]
            )
        );
    }

    public function beforeContent(HookRenderEvent $event)
    {
        if (null != $backgroundColor = BackOfficeColor::getConfigValue(
            BackOfficeColor::MODULE_CONFIG_BEFORE_CONTENT_MESSAGE,
            null,
            Lang::getDefaultLanguage()->getLocale()
        )) {
            $event->add(
                $this->render(
                    'hooks/before-content.html',
                    [
                        'before_content_message' => $backgroundColor,
                        'module_code' => URL::getInstance()->absoluteUrl("/admin/module/".BackOfficeColor::MODULE_CODE)
                    ]
                )
            );
        }
    }
}
