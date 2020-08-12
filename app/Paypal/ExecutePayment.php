<?php

namespace App\Paypal;

use PayPal\Api\Amount;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;

class ExecutePayment extends Paypal
{
    public function execute()
    {
        $payment = $this->getPayment();
        $execution = $this->getExecution();

        $execution->addTransaction($this->transaction());
        $result = $payment->execute($execution, $this->apiContext);

        return $result;
    }

    /**
     * @return PaymentExecution
     */
    protected function getExecution(): PaymentExecution
    {
        $execution = new PaymentExecution();
        $execution->setPayerId(request('PayerID'));

        return $execution;
    }

    /**
     * @return mixed
     */
    protected function getPayment()
    {
        $payment = Payment::get(request('paymentId'), $this->apiContext);

        return $payment;
    }

    /**
     * @param Amount $amount
     * @return Transaction
     */
    protected function transaction(): Transaction
    {
        $transaction = new Transaction();
        $transaction->setAmount($this->amount());

        return $transaction;
    }
}