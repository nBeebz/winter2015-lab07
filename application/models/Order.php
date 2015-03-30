<?php


class Order extends CI_Model {

    public function getOrder( $filename )
    {
        $xml = simplexml_load_file(DATAPATH . $filename);

        $burgers = $this->makeBurgers($xml->burger);

        $order = array(
            'customer' => $xml->customer,
            'burgers' => $burgers,
            'total' => $this->total($burgers)
            );

        return $order;
    }

    private function total($burgers)
    {
        $total = 0;
        foreach($burgers as $burger)
        {
            $total += $burger['price'];
        }
        return $total;
    }
    private function makeBurgers( $burgers )
    {
        $result = array();
        $num = 0;

        foreach( $burgers as $burger )
        {
            $toppings = array();
            $sauces = array();

            foreach($burger->topping as $topping)
                array_push($toppings, array( 'name' => $topping['type'] ));

            foreach ($burger->sauce as $sauce)
                array_push($sauces, array( 'name' => $sauce['type']) );

            if(empty($toppings)) 
                array_push($toppings, array('name' => 'None'));

            if(empty($sauces)) 
                array_push($sauces, array('name' => 'None'));

            $topCheese = empty($burger->cheese['top']) ? 'None' : $burger->cheese['top'];
            $botCheese = empty($burger->cheese['bottom']) ? 'None' : $burger->cheese['bottom'];

            $price = 7.95;

            $b = array(
                'num' => ++$num,
                'patty' => $burger->patty['type'],
                'topCheese' => $topCheese,
                'botCheese' => $botCheese,
                'toppings' => $toppings,
                'sauces' => $sauces,
                'price' => $price
                );

            array_push($result, $b);
        }

        return $result;
    }

}
