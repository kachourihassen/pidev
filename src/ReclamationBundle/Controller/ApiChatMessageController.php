<?php

namespace ReclamationBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
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
use FOS\RestBundle\Controller\FOSRestController;


/**
 * Chatmessage controller.
 *
 * @Route("dashboard/chatmessage")
 */
class ApiChatMessageController extends FOSRestController
{

    /**
     * @Get(
     *     path = "/api",
     *     name = "app_messages_show",
     * )
     * @View
     */
    public function showAction()
    {
        $em = $this->getDoctrine()->getManager();

        $chatMessages = $em->getRepository('ReclamationBundle:ChatMessage')->findAll();
        return $chatMessages;
    }

    /**
     * @Rest\Post(
     *    path = "/api",
     *    name = "app_messages_create"
     * )
     * @Rest\View(StatusCode = 201)
     */
    public function createAction(Request $request)
    {
        //$data = $this->get('jms_serializer')->deserialize($request->getContent(), 'array', 'json');
        $data =  $this->get('jms_serializer')->deserialize($request->getContent(), 'array', 'json');
        $chat_message = new ChatMessage;
        $chat_message->setUser($this->getUser());
        $chat_message->setDate(new \DateTime("now"));
        $form = $this->get('form.factory')->create(ChatMessageType::class, $chat_message);
        $form->submit($data);


        $em = $this->getDoctrine()->getManager();

        $em->persist($chat_message);
        $em->flush();

        return $this->view($chat_message, Response::HTTP_CREATED, ['Location' => $this->generateUrl('app_messages_show')]);

    }
}