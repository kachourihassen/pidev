<?php

namespace EvenementBundle\Controller;

use EvenementBundle\Entity\Evenement;
use EvenementBundle\Entity\Inscription;
use FOS\RestBundle\Controller\Annotations\Post;
use PaiementBundle\Entity\Facture;
use RHBundle\Entity\Enfant;
use Symfony\Component\HttpFoundation\JsonResponse;
use RHBundle\Entity\UserParent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


/**
 * Evenement controller.
 *
 */
class EvenementController extends Controller
{
    /**
     * Lists all evenement entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $evenements = $em->getRepository('EvenementBundle:Evenement')->findAll();
        $query=$em->createQuery('SELECT evenement from EvenementBundle:Evenement evenement order by evenement.titre ASC');
        $eveViews=$query->getResult();

        return $this->render('evenement/index.html.twig', array(
            'evenements' => $eveViews,$evenements
        ));
    }

    /**
     * Creates a new evenement entity.
     *
     */
    public function newAction(Request $request)
    {
        $evenement = new Evenement();
        $form = $this->createForm('EvenementBundle\Form\EvenementType', $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $evenement->upload();
            $em->persist($evenement);
            $em->flush();
            $this->addFlash(
                'info','Ajouter Avec Succés!');
            return $this->redirectToRoute('evenement_show', array('id' => $evenement->getId()));
        }
        return $this->render('evenement/new.html.twig', array(
            'evenement' => $evenement,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a evenement entity.
     *
     */
    public function showAction(Evenement $evenement)
    {
        $deleteForm = $this->createDeleteForm($evenement);

        return $this->render('evenement/show.html.twig', array(
            'evenement' => $evenement,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    public function calendarAction()
    {

        return $this->render('evenement/calendar.html.twig' );
    }

    /**
     * Displays a form to edit an existing evenement entity.
     *
     */
    public function editAction(Request $request, Evenement $evenement)
    {
        $deleteForm = $this->createDeleteForm($evenement);
        $editForm = $this->createForm('EvenementBundle\Form\EvenementType', $evenement);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash(
                'info','Evenement Modifier !!'
            );

            return $this->redirectToRoute('evenement_edit', array('id' => $evenement->getId()));
        }

        return $this->render('evenement/edit.html.twig', array(
            'evenement' => $evenement,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a evenement entity.
     *
     */
    public function deleteAction(Request $request, Evenement $evenement)
    {
        $form = $this->createDeleteForm($evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($evenement);
            $em->flush();
        }

        return $this->redirectToRoute('evenement_index');
    }

    /**
     * Creates a form to delete a evenement entity.
     *
     * @param Evenement $evenement The evenement entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Evenement $evenement)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('evenement_delete', array('id' => $evenement->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }


    public function indexparenteventAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $user=$this->container->get('security.token_storage')->getToken()->getUser();
        $insc = new Inscription();
        $fact=new Facture();


        if($request->request->get('some_var_name') && $request->request->get('event') && $request->request->get('enfant') ){
            $arrData = ['event' => $request->request->get('event') , 'enfant' => $request->request->get('enfant') , 'user' => $user->getId()];

            $enfant = $this->getDoctrine()->getRepository(Enfant::class)->find($request->request->get('enfant'));
            $monEvenement = $this->getDoctrine()->getRepository(Evenement::class)->find($request->request->get('event'));
            $insc->setEnfant($enfant );
            $insc->setEvenement($monEvenement);

            $fact->setMontant($monEvenement->getPrix());
            $fact->setTitre($monEvenement->getTitre());
            $fact->setDescription('facture pour evenement');

            $fact->setPayee(0);
            $fact->setDateCreation(new \DateTime());
            $fact->setDatePayement(new \DateTime());
            $insc->setFacture($fact);
            $em->persist($fact);
            $em->persist($insc);
            $em->flush();

            return new JsonResponse($arrData);

        }
        $em = $this->getDoctrine()->getManager();

        $parent=$this->getDoctrine()->getRepository(UserParent::class)->find($user->getId());
        $evenement = $em->getRepository('EvenementBundle:Evenement')->findAll();


        return $this->render('evenement/showparent.html.twig', array(
            'evenement' => $evenement,'parent'=>$parent,
        ));
    }

    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $evenement = $em->getRepository('EvenementBundle:Evenement')->findAll();
        if($request ->isMethod("POST"))
        {
            $titre=$request->get('titre');
            $evenement=$em->getRepository("EvenementBundle:Evenement")->findBy(array('titre'=>$titre));



        }
        return $this->render('evenement/search.html.twig',array('evenement'=>$evenement));

    }
}
