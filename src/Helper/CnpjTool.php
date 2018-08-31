<?php
/**
 * User: erick.antunes
 * Date: 31/08/2018
 * Time: 14:12
 */

namespace Paggcerto\Helper;


class CnpjTool
{
    public function createCnpj($mask = "1")
    {
        $number1 = rand(0, 9);
        $number2 = rand(0, 9);
        $number3 = rand(0, 9);
        $number4 = rand(0, 9);
        $number5 = rand(0, 9);
        $number6 = rand(0, 9);
        $number7 = rand(0, 9);
        $number8 = rand(0, 9);
        $number9 = 0;
        $number10 = 0;
        $number11 = 0;
        $number12 = 1;
        $div1 = $number12 * 2 + $number11 * 3 + $number10 * 4 + $number9 * 5 + $number8 * 6 + $number7 * 7 + $number6 * 8 + $number5 * 9 + $number4 * 2 + $number3 * 3
            + $number2 * 4 + $number1 * 5;
        $div1 = 11 - ($this->mod($div1, 11));
        if ($div1 >= 10) {
            $div1 = 0;
        }
        $div2 = $div1 * 2 + $number12 * 3 + $number11 * 4 + $number10 * 5 + $number9 * 6 + $number8 * 7 + $number7 * 8 + $number6 * 9 + $number5 * 2 + $number4 * 3
            + $number3 * 4 + $number2 * 5 + $number1 * 6;
        $div2 = 11 - ($this->mod($div2, 11));
        if ($div2 >= 10) {
            $div2 = 0;
        }
        if ($mask == 1) {
            $return = '' . $number1 . $number2 . "." . $number3 . $number4 . $number5 . "." . $number6 . $number7 . $number8 . "/" . $number9 . $number10 . $number11 .
                $number12 . "-" . $div1 . $div2;
        } else {
            $return = '' . $number1 . $number2 . $number3 . $number4 . $number5 . $number6 . $number7 . $number8 . $number9 . $number10 . $number11 . $number12 . $div1 . $div2;
        }
        return $return;
    }

    private function mod($diviv1, $diviv2)
    {
        return round($diviv1 - (floor($diviv1 / $diviv2) * $diviv2));
    }
}

