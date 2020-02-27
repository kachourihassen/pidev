<?php

namespace PaiementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PaiementBundle:Default:parent_act.html.twig');
    }
    public function payAction()
    {
        return $this->render('PaiementBundle:Default:payment_form.html.twig');
    }
    public function show_factureAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $id=$user->getId();

        $fact = $em->getRepository('PaiementBundle:Facture')->findBy(['parent' => $id ]);

        return $this->render('activite/show_facture.html.twig', array(
            'facts' =>$fact,
        ));
    }
}
