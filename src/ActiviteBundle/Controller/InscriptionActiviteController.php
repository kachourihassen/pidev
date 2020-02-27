<?php

namespace ActiviteBundle\Controller;

use ActiviteBundle\Entity\InscriptionActivite;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * Inscriptionactivite controller.
 *
 */
class InscriptionActiviteController extends Controller
{
    /**
     * Lists all inscriptionActivite entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $inscriptionActivites = $em->getRepository('ActiviteBundle:InscriptionActivite')->findAll();

        return $this->render('inscriptionactivite/parent_act.html.twig', array(
            'inscriptionActivites' => $inscriptionActivites,
        ));
    }

    /**
     * Finds and displays a inscriptionActivite entity.
     *
     */
    public function showAction(InscriptionActivite $inscriptionActivite)
    {

        return $this->render('inscriptionactivite/show.html.twig', array(
            'inscriptionActivite' => $inscriptionActivite,
        ));
    }
}
