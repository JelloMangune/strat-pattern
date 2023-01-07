<?php

namespace Strategy;

use Strategy\Cart\Item;
use Strategy\Cart\ShoppingCart;
use Strategy\Order\Order;
use Strategy\Invoice\TextInvoice;
use Strategy\Invoice\PDFInvoice;
use Strategy\Customer\Customer;
use Strategy\Payments\CashOnDelivery;
use Strategy\Payments\CreditCardPayment;
use Strategy\Payments\PaypalPayment;

class Application
{
    public static function run()
    {
        $zoro = new Item('ZORO', 'One Piece Figurine Set 1' , 1000);
        $nami = new Item('NAMI', 'One Piece Figurine Set 2', 2000);
        $luffy = new Item('LUFFY', 'One Piece Figurine Set 3', 3000);

        $cart = new ShoppingCart();
        $cart->addItem($luffy, 2);
        $cart->addItem($zoro, 6);

        $customer = new Customer('Jello Mangune', 'Purok 5, Pulung Cacutud Angeles City', 'mangune.jello@auf.edu.ph');
        
        $order = new Order($customer, $cart);

        $text_invoice = new TextInvoice();
        $order->setInvoiceGenerator($text_invoice);
        $text_invoice->generate($order);

        $cash_on_delivery = new CashOnDelivery($customer);
        $order->setPaymentMethod($cash_on_delivery);
        $order->payInvoice();
        
    }
}