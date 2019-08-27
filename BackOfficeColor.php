<?php
/*************************************************************************************/
/*      This file is part of the Thelia package.                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace BackOfficeColor;

use Thelia\Core\Translation\Translator;
use Thelia\Module\BaseModule;

class BackOfficeColor extends BaseModule
{
    const MESSAGE_DOMAIN = "backofficecolor";
    const MODULE_CODE = "BackOfficeColor";

    const MODULE_CONFIG_BEFORE_CONTENT_MESSAGE = "before_content_message";
    const MODULE_CONFIG_DEFAULT_BACKGROUND_COLOR = "default_background_color";


    public static function getModuleConfigVariables()
    {
        return [

            self::MODULE_CONFIG_BEFORE_CONTENT_MESSAGE =>
                [
                    'type' => 'text',
                    'label' => Translator::getInstance()->trans(
                        'Message visible on all backOffice templates',
                        [],
                        self::MESSAGE_DOMAIN
                    ),
                    'helper' => Translator::getInstance()->trans(
                        'Keep it empty to remove this message on all templates',
                        [],
                        self::MESSAGE_DOMAIN
                    ),
                    'class' => 'col-md-12'
                ],
            self::MODULE_CONFIG_DEFAULT_BACKGROUND_COLOR =>
                [
                    'type' => 'color',
                    'label' => Translator::getInstance()->trans(
                        'Default background color',
                        [],
                        self::MESSAGE_DOMAIN
                    ),
                    'helper' => '',
                    'class' => 'col-md-4'
                ]
        ];
    }

    public static function adjustBrightness($hex, $steps)
    {
        // Steps should be between -255 and 255. Negative = darker, positive = lighter
        $steps = max(-255, min(255, $steps));

        // Normalize into a six character long hex string
        $hex = str_replace('#', '', $hex);
        if (strlen($hex) == 3) {
            $hex =
                str_repeat(substr($hex, 0, 1), 2).
                str_repeat(substr($hex, 1, 1), 2).
                str_repeat(substr($hex, 2, 1), 2)
            ;
        }

        // Split into three parts: R, G and B
        $color_parts = str_split($hex, 2);
        $return = '#';

        foreach ($color_parts as $color) {
            $color   = hexdec($color); // Convert to decimal
            $color   = max(0, min(255, $color + $steps)); // Adjust color
            $return .= str_pad(dechex($color), 2, '0', STR_PAD_LEFT); // Make two char hex code
        }

        return $return;
    }
}
