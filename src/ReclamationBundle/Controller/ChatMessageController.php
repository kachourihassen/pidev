<?php

namespace ReclamationBundle\Controller;

use http\Env\Response;
use ReclamationBundle\Entity\ChatMessage;
use ReclamationBundle\Form\ChatMessageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;


/**
 * Chatmessage controller.
 *
 * @Route("dashboard/chatmessage")
 */
class ChatMessageController extends Controller
{
    /**
     * Lists all chatMessage entities.
     *
     * @Route("/", name="dashboard_chatmessage_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $chatMessages = $em->getRepository('ReclamationBundle:ChatMessage')->findAll();

        return $this->render('chatmessage/index.html.twig', array(
            'chatMessages' => $chatMessages,
            'page_title' => 'Chat'
        ));
    }

    /**
     * Lists all chatMessage entities.
     *
     * @Route("/direct_chat_messages", name="dashboard_chatmessage_direct_chat_messages")
     * @Method("GET")
     */
    public function directchatmessagesAction()
    {
        $em = $this->getDoctrine()->getManager();

        $chatMessages = $em->getRepository('ReclamationBundle:ChatMessage')->findAll();

        return $this->render('chatmessage/direct_chat_messages.html.twig', array(
            'chatMessages' => $chatMessages,
            'page_title' => 'Chat'
        ));
    }

}
