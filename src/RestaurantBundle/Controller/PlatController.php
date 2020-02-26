<?php

namespace RestaurantBundle\Controller;

use RestaurantBundle\Entity\Plat;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Plat controller.
 *
 */
class PlatController extends Controller
{
    /**
     * Lists all plat entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $plats = $em->getRepository('RestaurantBundle:Plat')->findAll();

        return $this->render('plat/index.html.twig', array(
            'plats' => $plats,
        ));
    }

    /**
     * Creates a new plat entity.
     *
     */
    public function newAction(Request $request)
    {
        $plat = new Plat();
        $form = $this->createForm('RestaurantBundle\Form\PlatType', $plat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            print $plat->getRepas()->indexOf(0);
            $em->persist($plat);
            $em->flush();

            return $this->redirectToRoute('plat_show', array('id' => $plat->getId()));
        }

        return $this->render('plat/new.html.twig', array(
            'plat' => $plat,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a plat entity.
     *
     */
    public function showAction(Plat $plat)
    {
        $deleteForm = $this->createDeleteForm($plat);

        return $this->render('plat/show.html.twig', array(
            'plat' => $plat,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing plat entity.
     *
     */
    public function editAction(Request $request, Plat $plat)
    {
        $deleteForm = $this->createDeleteForm($plat);
        $editForm = $this->createForm('RestaurantBundle\Form\PlatType', $plat);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('plat_edit', array('id' => $plat->getId()));
        }

        return $this->render('plat/edit.html.twig', array(
            'plat' => $plat,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a plat entity.
     *
     */
    public function deleteAction(Request $request, Plat $plat)
    {
        $form = $this->createDeleteForm($plat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($plat);
            $em->flush();
        }

        return $this->redirectToRoute('plat_index');
    }

    /**
     * Creates a form to delete a plat entity.
     *
     * @param Plat $plat The plat entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Plat $plat)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('plat_delete', array('id' => $plat->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
