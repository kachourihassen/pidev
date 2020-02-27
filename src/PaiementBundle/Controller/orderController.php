<?php

namespace PaiementBundle\Controller;

use http\Env\Response;
use JMS\Payment\CoreBundle\PluginController\PluginController;
use mysql_xdevapi\Result;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\Payment\CoreBundle\Form\ChoosePaymentMethodType;
use Symfony\Component\Cache\Adapter\AbstractAdapter;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use PaiementBundle\Entity\Orders;
use Symfony\Component\HttpFoundation\Request;
use JMS\Payment\CoreBundle\Plugin\Exception\Action\VisitUrl;
use JMS\Payment\CoreBundle\Plugin\Exception\ActionRequiredException;



/**
 * @Route("/orders")
 */
class orderController extends AbstractController
{
    /**
     * @Route("/new/{amount}")
     */
    public function newAction($amount)
    {
        $em = $this->getDoctrine()->getManager();

        $order = new orders($amount);
        $em->persist($order);
        $em->flush();

        return $this->redirectToRoute('app_orders_show', [
            'orderId' => $order->getId(),
        ]);
    }
    /**
     * @Route("/{orderId}/show")
     */
    public function showAction($orderId, Request $request, PluginController $ppc)
    {
        $form = $this->createForm(ChoosePaymentMethodType::class, null, [
            'amount'   => $order->getAmount(),
            'currency' => 'EUR',
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ppc->createPaymentInstruction($instruction = $form->getData());

            $order->setPaymentInstruction($instruction);

            $em = $this->getDoctrine()->getManager();
            $em->persist($order);
            $em->flush($order);

            return $this->redirectToRoute('app_orders_paymentcreate', [
                'orderId' => $order->getId(),
            ]);
        }

        return $this->render('Orders/show.html.twig', [
            'order' => $order,
            'form'  => $form->createView(),
        ]);

    }

    //crer un nouveau payement
    private function createPayment(Order $order, PluginController $ppc)
    {
        $instruction = $order->getPaymentInstruction();
        $pendingTransaction = $instruction->getPendingTransaction();

        if ($pendingTransaction !== null) {
            return $pendingTransaction->getPayment();
        }

        $amount = $instruction->getAmount() - $instruction->getDepositedAmount();

        return $ppc->createPayment($instruction->getId(), $amount);
    }

    //CRER UNE ACTION DE PAYEMENT
    public function paymentCreateAction($orderId, PluginController $ppc)
    {
        $order = $this->getDoctrine()->getManager()->getRepository(Order::class)->find($orderId);

        $payment = $this->createPayment($order, $ppc);

        $result = $ppc->approveAndDeposit($payment->getId(), $payment->getTargetAmount());

        if ($result->getStatus() === Result::STATUS_SUCCESS) {
            return $this->redirectToRoute('app_orders_paymentcomplete', [
                'orderId' => $order->getId(),
            ]);
        }

        throw $result->getPluginException();

        // In a real-world application you wouldn't throw the exception. You would,
        // for example, redirect to the showAction with a flash message informing
        // the user that the payment was not successful.
        if ($result->getStatus() === Result::STATUS_PENDING) {
            $ex = $result->getPluginException();

            if ($ex instanceof ActionRequiredException) {
                $action = $ex->getAction();

                if ($action instanceof VisitUrl) {
                    return $this->redirect($action->getUrl());
                }
            }
        }

        throw $result->getPluginException();
    }
    /**
     * @Route("/{orderId}/payment/complete")
     */
    public function paymentCompleteAction($orderId)
    {
        return new Response('Payment complete');
    }

}

/*$form = $this->createForm(ChoosePaymentMethodType::class, null, [
    'amount'   => '10.42',
    'currency' => 'EUR',
]);*/


