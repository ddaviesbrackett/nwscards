<?php

class WebhookController extends Laravel\Cashier\WebhookController {
    
    public function handleInvoicePaymentSucceeded($payload)
    {
        // Handle The Event
    }

}