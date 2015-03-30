<?php

/**
 * Our homepage. Show the most recently added quote.
 * 
 * controllers/Welcome.php
 *
 * ------------------------------------------------------------------------
 */
class Welcome extends Application {

    function __construct()
    {
       parent::__construct();
   }

    //-------------------------------------------------------------
    //  Homepage: show a list of the orders on file
    //-------------------------------------------------------------

   function index()
   {
	// Build a list of orders
    $this->data['orders'] = array();
    $files = getXmlFiles( directory_map(DATAPATH) );

    foreach( $files as $file ){
        $order = $this->Order->getOrder($file);
        $customer = $order['customer'];
        array_push( $this->data['orders'], array( 'link' => "welcome/order/$file", 'filename' => $file, 'customer' => $customer ) );
    }

	// Present the list to choose from
    $this->data['pagebody'] = 'homepage';
    $this->render();
}

    //-------------------------------------------------------------
    //  Show the "receipt" for a specific order
    //-------------------------------------------------------------

function order($filename)
{
	// Build a receipt for the chosen order
	$order = $this->Order->getOrder($filename);
	// Present the list to choose from
    $this->data['customer'] = $order['customer'];
    $this->data['burgers'] = $order['burgers'];
    $this->data['total'] = $order['total'];
	$this->data['pagebody'] = 'justone';
	$this->render();
}


}
