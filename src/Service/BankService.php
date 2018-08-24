<?php
/**
 * Created by PhpStorm.
 * User: marcus.vinicius
 * Date: 24/08/2018
 * Time: 17:54
 */

namespace Paggcerto\Service;

use stdClass;

class BankService extends PaggcertoService
{
    const SEARCH_BANKS = "v2/banks";

    protected function initialize()
    {
        $this->data = new stdClass();
        $this->data->banks = [];
    }

    protected function populate(stdClass $response)
    {
        $this->data->banks = [];
        foreach ($response->banks as $bank) {
            $temp = new stdClass();
            $temp->code = $this->getIfSet("number", $bank);
            $temp->name = $this->getIfSet("name", $bank);
            array_push($this->data->banks, $temp);
        }

        return $this->data->banks;
    }
}