<?php

namespace ReclamationBundle\Controller;

use ReclamationBundle\Entity\Notification;
use ReclamationBundle\Entity\NotificationParent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Notification controller.
 *
 */
class NotificationController extends Controller
{
    /**
     * Lists all notification entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery(
            'SELECT n.id,n.texte
            FROM ReclamationBundle:NotificationParent n
            WHERE n.vueParLAdmin = FALSE
            '
        );
        $notifications = $query->getArrayResult();

        $response = new Response(json_encode($notifications));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }


    /**
     * Displays a form to edit an existing notification entity.
     *
     */
    public function editAction(Request $request, NotificationParent $notification)
    {

        $em = $this->getDoctrine()->getManager();
        $notification = $em->getRepository(NotificationParent::class)->find($notification->getId());
        $notification->setVueParLAdmin(true);
        $em->flush();
        return new Response();
    }

}
