<?php

namespace BibliothequeBundle\Controller;


use BibliothequeBundle\Entity\BD;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BDController extends Controller
{


    /**
     * Lists all Bd entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $bds = $em->getRepository('BibliothequeBundle:BD')->findAll();

        return $this->render('bd/index.html.twig', array(
            'bds' => $bds,
        ));
    }


    /**
     * Creates a new bd entity.
     *
     */
    public function newAction(Request $request)
    {
        $bd = new BD();
        $form = $this->createForm('BibliothequeBundle\Form\BDType', $bd);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $bd->upload();
            $date=new \DateTime(Date('yy-m-d', strtotime("-1 days")));
            $bd->setEndDateEmprunt($date);
            $em->persist($bd);
            $em->flush();

            return $this->redirectToRoute('bd_show', array('id' => $bd->getId()));
        }

        return $this->render('bd/new.html.twig', array(
            'bd' => $bd,
            'form' => $form->createView(),
        ));
    }



    /**
     * Finds and displays a bd entity.
     *
     */
    public function showAction(BD $bd)
    {
        $deleteForm = $this->createDeleteForm($bd);

        return $this->render('bd/show.html.twig', array(
            'bd' => $bd,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing bd entity.
     *
     */
    public function editAction(Request $request, BD $bd)
    {
        $deleteForm = $this->createDeleteForm($bd);
        $editForm = $this->createForm('BibliothequeBundle\Form\BDType', $bd);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('bd_edit', array('id' => $bd->getId()));
        }

        return $this->render('bd/edit.html.twig', array(
            'bd' => $bd,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    public function consulterbdAction()
    {
        $em = $this->getDoctrine()->getManager();

        $bds = $em->getRepository('BibliothequeBundle:BD')->getBdByDate();

        return $this->render('bd/bdfront.html.twig', array(
            'bds' => $bds,
        ));
    }

    /**
     * Deletes a bd entity.
     *
     */
    public function deleteAction(Request $request, BD $bd)
    {
        $form = $this->createDeleteForm($bd);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($bd);
            $em->flush();
        }

        return $this->redirectToRoute('bd_index');
    }

    /**
     * Creates a form to delete a bd entity.
     *
     * @param BD $bd The bd entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(BD $bd)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('bd_delete', array('id' => $bd->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }


}
