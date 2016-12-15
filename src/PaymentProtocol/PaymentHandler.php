<?php

namespace BitWaspNew\Bitcoin\PaymentProtocol;

use BitWaspNew\Bitcoin\PaymentProtocol\Protobufs\Payment;
use BitWaspNew\Bitcoin\PaymentProtocol\Protobufs\PaymentACK;

class PaymentHandler
{
    /**
     * @param Payment $payment
     * @param string $memo
     * @return PaymentACK
     */
    public function getPaymentAck(Payment $payment, $memo = null)
    {
        $ack = new PaymentACK();
        $ack->setPayment($payment);

        if (is_string($memo)) {
            $ack->setMemo($memo);
        }

        return $ack;
    }
}
