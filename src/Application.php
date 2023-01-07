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
        
        echo "\n ************************************************* \n\n";

        $cart2 = new ShoppingCart();
        $cart2->addItem($nami,1);
        $cart2->addItem($zoro,1);
        $cart2->addItem($luffy,1);

        $order2 = new Order($customer, $cart2);

        $pdf_invoice = new PDFInvoice();
        $order2->setInvoiceGenerator($pdf_invoice);
        $pdf_invoice->generate($order2);

        $paypal_payment = new PaypalPayment('mangune.jello@auf.edu.ph', '12345678');
        $order2->setPaymentMethod($paypal_payment);
        $order2->payInvoice();

        echo "\n ************************************************* \n\n";

        $customer2 = new Customer('John Doe', '170 Balasticio, Turo Magalang', 'doe.john@auf.edu.ph');

        $cart3 = new ShoppingCart();
        $cart3->addItem($luffy, 10);

        $order3 = new Order($customer2, $cart3);
        $order3->setInvoiceGenerator($text_invoice);
        $text_invoice->generate($order3);

        $credit_card_payment = new CreditCardPayment('John Doe', '33333333', '1414', '01/80');
        $order3->setPaymentMethod($credit_card_payment);
        $order3->payInvoice();
    }
}