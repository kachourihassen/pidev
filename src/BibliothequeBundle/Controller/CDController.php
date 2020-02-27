<?php

namespace BibliothequeBundle\Controller;

use BibliothequeBundle\Entity\CD;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Date;

/**
 * Cd controller.
 *
 */
class CDController extends Controller
{
    /**
     * Lists all cD entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cDs = $em->getRepository('BibliothequeBundle:CD')->findAll();

        return $this->render('cd/index.html.twig', array(
            'cds' => $cDs,
        ));
    }

    /**
     * Creates a new cD entity.
     *
     */
    public function newAction(Request $request)
    {
        $cD = new Cd();
        $form = $this->createForm('BibliothequeBundle\Form\CDType', $cD);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $cD->upload();
            $date=new \DateTime(Date('yy-m-d', strtotime("-1 days")));
            $cD->setEndDateEmprunt($date);
            $em->persist($cD);
            $em->flush();

            return $this->redirectToRoute('cd_show', array('id' => $cD->getId()));
        }

        return $this->render('cd/new.html.twig', array(
            'cD' => $cD,
            'form' => $form->createView(),
        ));
    }

    public function consultercdAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cds = $em->getRepository('BibliothequeBundle:CD')->getCDByDate();

        return $this->render('cd/cdfront.html.twig', array(
            'cds' => $cds,
        ));
    }

    /**
     * Finds and displays a cD entity.
     *
     */
    public function showAction(CD $cD)
    {
        $deleteForm = $this->createDeleteForm($cD);

        return $this->render('cd/show.html.twig', array(
            'cD' => $cD,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cD entity.
     *
     */
    public function editAction(Request $request, CD $cD)
    {
        $deleteForm = $this->createDeleteForm($cD);
        $editForm = $this->createForm('BibliothequeBundle\Form\CDType', $cD);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cd_edit', array('id' => $cD->getId()));
        }

        return $this->render('cd/edit.html.twig', array(
            'cD' => $cD,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a cD entity.
     *
     */
    public function deleteAction(Request $request, CD $cD)
    {
        $form = $this->createDeleteForm($cD);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cD);
            $em->flush();
        }

        return $this->redirectToRoute('cd_index');
    }

    /**
     * Creates a form to delete a cD entity.
     *
     * @param CD $cD The cD entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CD $cD)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cd_delete', array('id' => $cD->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
