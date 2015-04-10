<?php


class Orders extends CI_Model {

    protected $orders = array();

    public function __construct() {
        global $orders;
        parent::__construct();
        $files = getOrders( directory_map(DATAPATH) );
        foreach( $files as $file ){
            $xml = simplexml_load_file(DATAPATH . $file);
            $orders[$file] = $this->makeOrder($xml);
        }
    }

    public function getOrder( $name )
    {
        global $orders;
        if( isset($orders[$name]) )
            return $orders[$name];
        return null;
    }

    public function makeOrder( $xml )
    {

        $burgers = $this->makeBurgers($xml->burger);
        $note = empty($xml->note) ? '' : $xml->note;
        $order = array(
            'customer' => $xml->customer,
            'burgers' => $burgers,
            'total' => $this->total($burgers),
            'special' => $note
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

    private function makeBurgers( $tickets )
    {
        $CI =& get_instance();
        $CI->load->model('Menu');
        $count = 1;
        $burgers = array();

        foreach( $tickets as $ticket )
        {
            $burger = array();
            $toppings = array();
            $sauces = array();
            $cheeses = array();
            $note = '';
            $total = 0;
            
            $patty = $CI->Menu->getPatty($ticket->patty['type']);
            $total += $patty['price'];

            if($topCheese = $CI->Menu->getCheese($ticket->cheeses['top']))
                $total += $topCheese['price'];
            else
                $topCheese = array('name'=>'None');

            if( $botCheese = $CI->Menu->getCheese($ticket->cheeses['bottom']) )
                $total += $botCheese['price'];
            else
                $botCheese = array('name'=>'None');

            foreach($ticket->topping as $topping){
                if( $t = $CI->Menu->getTopping($topping['type']) ){
                    $total += $t['price'];
                    array_push($toppings, $t);
                }
                
            }

            foreach($ticket->sauce as $sauce){
               if( $s = $CI->Menu->getSauce($sauce['type']) ){
                   array_push($sauces, $s);
                   $total += $s['price'];
               }
           }

           $burger['num'] = $count++;
           $burger['patty'] = $patty['name'];
           $burger['toppings'] = $toppings;
           $burger['sauces'] = $sauces;
           $burger['botCheese'] = $botCheese['name'];
           $burger['topCheese'] = $topCheese['name'];
           $burger['note'] = $note;
           $burger['price'] = $total;

           array_push($burgers, $burger);
       }

       return $burgers;
   }

}
