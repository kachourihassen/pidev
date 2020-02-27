<?php

namespace ActiviteBundle\Controller;

use ActiviteBundle\Entity\Activite;
use ActiviteBundle\Entity\InscriptionActivite;
use PaiementBundle\Entity\Facture;
use Payment\Payment;
use RHBundle\Entity\UserParent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


/**
 * Activite controller.
 *
 */
class ActiviteController extends Controller
{
    /**
     * Lists all activite entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $activites = $em->getRepository('ActiviteBundle:Activite')->findAll();

        return $this->render('activite/index.html.twig', array(
            'activites' => $activites,
        ));
    }

    /**
     * Creates a new activite entity.
     *
     */
    public function newAction(Request $request)
    {
        $activite = new Activite();
        $form = $this->createForm('ActiviteBundle\Form\ActiviteType', $activite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($activite);
            $em->flush();

            return $this->redirectToRoute('activite_show', array('id' => $activite->getId()));
        }

        return $this->render('activite/new.html.twig', array(
            'activite' => $activite,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a activite entity.
     *
     */
    public function showAction(Activite $activite)
    {
        $deleteForm = $this->createDeleteForm($activite);

        return $this->render('activite/show.html.twig', array(
            'activite' => $activite,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing activite entity.
     *
     */
    public function editAction(Request $request, Activite $activite)
    {
        $deleteForm = $this->createDeleteForm($activite);
        $editForm = $this->createForm('ActiviteBundle\Form\ActiviteType', $activite);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('activite_edit', array('id' => $activite->getId()));
        }

        return $this->render('activite/edit.html.twig', array(
            'activite' => $activite,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a activite entity.
     *
     */
    public function deleteAction(Request $request, Activite $activite)
    {
        $form = $this->createDeleteForm($activite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($activite);
            $em->flush();
        }

        return $this->redirectToRoute('activite_index');
    }
    public function act_parentAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $activites = $this->getDoctrine()->getRepository(Activite::class)->findAll();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $parent = $this->getDoctrine()->getRepository(UserParent::class)->find($user->getId());

        return $this->render('activite/parent_act.html.twig', array(
            'activites' => $activites,'parent' => $parent
        ));
    }
    ///participer a un event action
    public function activite_partAction(Request $request,$id){
        $em = $this->getDoctrine()->getManager();
        $activites = $this->getDoctrine()->getRepository(Activite::class)->findAll();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $parent = $this->getDoctrine()->getRepository(UserParent::class)->find($user->getId());
        if($request->getMethod() == Request::METHOD_POST) {
            foreach ($parent->getEnfants() as $e) {

                if ($request->request->get($e->getId()) == 'on') {
                    $insc = new InscriptionActivite();
                    $fact = new Facture();
                    $em = $this->getDoctrine()->getManager();
                   // $id_act = $request->request->get('act');
                    //var_dump($id);
                    // die();
                    $monActivite = $this->getDoctrine()->getRepository(Activite::class)->find($id);
                    $insc->setEnfant($e);
                    $insc->setActivite($monActivite);
                    $user = $this->get('security.token_storage')->getToken()->getUser();
                    $fact->setParent($user);
                    $fact->setMontant($monActivite->getPrix());

                    $fact->setTitre($monActivite->getNom());
                    $fact->setTitre('teste');
                    $fact->setDescription('facture pou activite');
                    $fact->setPayee(0);
                    $fact->setDateCreation(new \DateTime());
                    $insc->setFacture($fact);
                    $em->persist($fact);
                    $em->persist($insc);

                };
                $em->flush();

            }
        }
        return $this->render('activite/activite_part.html.twig', array(
            'parent' => $parent
        ));
    }

    /**
     * Creates a form to delete a activite entity.
     *
     * @param Activite $activite The activite entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Activite $activite)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('activite_delete', array('id' => $activite->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    public function filterAction(Request $request)
    {

        $nom = $request->get('nom');
        $em = $this->getDoctrine()->getManager();

        $activite = $em->getRepository('ActiviteBundle:Activite')->findName($nom);

        $jsondata = array();
        $idx = 0;
        foreach ($activite as $f) {
            $temp = array('id'=>$f->getId(),'categorie' => $f->getCategorie(), 'nom' => $f->getNom(), 'prix' => $f->getPrix(), 'description' => $f->getDescription(),
            );

            $jsondata[$idx++] = $temp;
        }
        return new JsonResponse($jsondata);

        /* return $this->render('representant/index.html.twig', array(
             'representants' => $representants,
         ));*/
    }
}
