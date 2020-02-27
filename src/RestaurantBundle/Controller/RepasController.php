<?php

namespace RestaurantBundle\Controller;

use RestaurantBundle\Entity\InscriptionRepas;
use RestaurantBundle\Entity\Repas;
use RHBundle\Entity\UserParent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Repa controller.
 *
 */
class RepasController extends Controller
{

    /**
     * Lists all repa entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $repas = $em->getRepository('RestaurantBundle:Repas')->findAll();

        return $this->render('repas/index.html.twig', array(
            'repas' => $repas,
        ));
    }

    public function construireRepasAction()
    {
        //$em = $this->getDoctrine()->getManager();

        //$repas = $em->getRepository('RestaurantBundle:Repas')->findAll();

        return $this->render('repas/construirerepas.html.twig');
    }

    /**
     * Creates a new repa entity.
     *
     */
    public function newAction(Request $request)
    {
        $repa = new Repas();
        $form = $this->createForm('RestaurantBundle\Form\RepasType', $repa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($repa);
            $em->flush();

            return $this->redirectToRoute('repas_show', array('id' => $repa->getId()));
        }

        return $this->render('repas/new.html.twig', array(
            'repa' => $repa,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a repa entity.
     *
     */
    public function showAction(Repas $repa)
    {
        $deleteForm = $this->createDeleteForm($repa);

        return $this->render('repas/show.html.twig', array(
            'repa' => $repa,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    public function listeinscriptionAction( )
    {$i=0;$t=0;
        $em = $this->getDoctrine();
        $repas = $em->getRepository('RestaurantBundle:Repas')->findAll();
        $nb = array();
        echo "tab 1";
        foreach($repas as $e)
        {
            $nb[]=$em->getRepository(InscriptionRepas::class)->countInscri($e->getId());$i++;
          //  print_r($nb);
        }
        echo " </br> nb ";print_r($nb);
        echo " </br> nb 0 ";print_r($nb[0]);
      while ($t < $i){
           $tab[$t]=$nb[$t];$t++;
       }echo " </br> tab ";print_r($tab);

        return $this->render('repas/listeinscription.html.twig', array('nb' => $nb,'repas'=>$repas));
    }

    public function mesinscriptionsAction(){
        $user=$this->container->get('security.token_storage')->getToken()->getUser();
        $parent=$this->getDoctrine()->getRepository(UserParent::class)->find($user->getId());
        $insc=$this->getDoctrine()->getRepository(InscriptionRepas::class)->findAll();

        return $this->render('repas/mesinscriptions.html.twig', array(
            'insc' => $insc,'parent' => $parent
        ));

    }



    /**
     * Displays a form to edit an existing repa entity.
     *
     */
    public function editAction(Request $request, Repas $repa)
    {
        $deleteForm = $this->createDeleteForm($repa);
        $editForm = $this->createForm('RestaurantBundle\Form\RepasType', $repa);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('repas_edit', array('id' => $repa->getId()));
        }

        return $this->render('repas/edit.html.twig', array(
            'repa' => $repa,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a repa entity.
     *
     */
    public function deleteAction(Request $request, Repas $repa)
    {
        $form = $this->createDeleteForm($repa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($repa);
            $em->flush();
        }

        return $this->redirectToRoute('repas_index');
    }

    /**
     * Creates a form to delete a repa entity.
     *
     * @param Repas $repa The repa entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Repas $repa)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('repas_delete', array('id' => $repa->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
    public function getPlatsAction(Request $request, Repas $repa)
    {
        $form = $this->createDeleteForm($repa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($repa);
            $em->flush();
        }

        return $this->redirectToRoute('repas_index');
    }

}
