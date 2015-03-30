<?php

/**
 * This is a "CMS" model for quotes, but with bogus hard-coded data.
 * This would be considered a "mock database" model.
 *
 * @author jim
 */
class Menu extends CI_Model {

    public $patties = array();
    public $toppings = array(); 
    public $cheeses = array();
    public $sauces = array();    

    // Constructor
    public function __construct() {
        parent::__construct();
        global $patties;        
        global $toppings;
        global $cheeses;
        global $sauces;        

        $xml = simplexml_load_file(DATAPATH . 'menu.xml');

        // build a full list of patties - approach 2
        foreach ($xml->patties->patty as $patty) {
            $record = new stdClass();
            $record->code = (string) $patty['code'];
            $record->name = (string) $patty;
            $record->price = (float) $patty['price'];
            $patties[$record->code] = $record;
        }

        foreach($xml->toppings->topping as $topping)
        {
            $record = new stdClass();
            $record->code = (string) $topping['code'];
            $record->name = (string) $topping;
            $record->price = (float) $topping['price'];
            $toppings[$record->code] = $record;
        }

        foreach($xml->cheeses->cheese as $cheese)
        {
            $record = new stdClass();
            $record->code = (string) $cheese['code'];
            $record->name = (string) $cheese;
            $record->price = (float) $cheese['price'];
            $cheeses[$record->code] = $record;
        }


        foreach($xml->sauces->sauce as $sauce)
        {
            $record = new stdClass();
            $record->code = (string) $sauce['code'];
            $record->name = (string) $sauce;
            $record->price = (float) $sauce['price'];
           $sauces[$record->code] = $record;
        }
    }

    // retrieve a patty record, perhaps for pricing
    function getPatty($code) {
        global $patties;
        $code = (string)$code;
        if ($patties[$code])
            return (array)$patties[$code];
        else
            return null;
    }

    function getTopping($code) {
        global $toppings;
        $code = (string)$code;
        if (isset($toppings[$code]))
            return (array)$toppings[$code];
        else
            return null;
    }

    function getCheese($code) {
        global $cheeses;
        $code = (string)$code;
        if (isset($cheeses[$code]))
            return (array)$cheeses[$code];
        else
            return null;
    }

    function getSauce($code) {
        global $sauces;
        $code = (string)$code;
        if (isset($sauces[$code]))
            return (array)$sauces[$code];
        else
            return null;
    }
}
