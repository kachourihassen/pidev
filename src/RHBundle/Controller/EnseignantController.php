<?php

namespace RHBundle\Controller;

use RHBundle\Entity\Enseignant;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Enseignant controller.
 *
 */
class EnseignantController extends Controller
{
    /**
     * Lists all enseignant entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $enseignants = $em->getRepository('RHBundle:Enseignant')->findAll();

        return $this->render('enseignant/index.html.twig', array(
            'enseignants' => $enseignants,
        ));
    }

    /**
     * Creates a new enseignant entity.
     *
     */
    public function newAction(Request $request)
    {
        $enseignant = new Enseignant();
        $form = $this->createForm('RHBundle\Form\EnseignantType', $enseignant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($enseignant);
            $em->flush();

            return $this->redirectToRoute('enseignant_show', array('id' => $enseignant->getId()));
        }

        return $this->render('enseignant/new.html.twig', array(
            'enseignant' => $enseignant,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a enseignant entity.
     *
     */
    public function showAction(Enseignant $enseignant)
    {
        $deleteForm = $this->createDeleteForm($enseignant);

        return $this->render('enseignant/show.html.twig', array(
            'enseignant' => $enseignant,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing enseignant entity.
     *
     */
    public function editAction(Request $request, Enseignant $enseignant)
    {
        $deleteForm = $this->createDeleteForm($enseignant);
        $editForm = $this->createForm('RHBundle\Form\EnseignantType', $enseignant);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('enseignant_edit', array('id' => $enseignant->getId()));
        }

        return $this->render('enseignant/edit.html.twig', array(
            'enseignant' => $enseignant,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a enseignant entity.
     *
     */
    public function deleteAction(Request $request, Enseignant $enseignant)
    {
        $form = $this->createDeleteForm($enseignant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($enseignant);
            $em->flush();
        }

        return $this->redirectToRoute('enseignant_index');
    }

    /**
     * Creates a form to delete a enseignant entity.
     *
     * @param Enseignant $enseignant The enseignant entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Enseignant $enseignant)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('enseignant_delete', array('id' => $enseignant->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
