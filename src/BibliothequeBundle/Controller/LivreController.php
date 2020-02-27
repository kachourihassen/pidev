<?php

namespace BibliothequeBundle\Controller;

use BibliothequeBundle\Entity\Document;
use BibliothequeBundle\Entity\Emprunter;
use BibliothequeBundle\Entity\Livre;
use RHBundle\Entity\Enfant;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Livre controller.
 *
 */
class LivreController extends Controller
{
    /**
     * Lists all livre entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $livres = $em->getRepository('BibliothequeBundle:Livre')->findAll();

        return $this->render('livre/index.html.twig', array(
            'livres' => $livres,
        ));
    }

    /**
     * Creates a new livre entity.
     *
     */
    public function newAction(Request $request)
    {
        $livre = new Livre();
        $form = $this->createForm('BibliothequeBundle\Form\LivreType', $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $livre->upload();
            $date=new \DateTime(Date('yy-m-d', strtotime("-1 days")));
            $livre->setEndDateEmprunt($date);
            $em->persist($livre);
            $em->flush();

            return $this->redirectToRoute('livre_show', array('id' => $livre->getId()));
        }

        return $this->render('livre/new.html.twig', array(
            'livre' => $livre,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a livre entity.
     *
     */
    public function showAction(Livre $livre)
    {
        $deleteForm = $this->createDeleteForm($livre);

        return $this->render('livre/show.html.twig', array(
            'livre' => $livre,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing livre entity.
     *
     */
    public function editAction(Request $request, Livre $livre)
    {
        $deleteForm = $this->createDeleteForm($livre);
        $editForm = $this->createForm('BibliothequeBundle\Form\LivreType', $livre);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('livre_edit', array('id' => $livre->getId()));
        }

        return $this->render('livre/edit.html.twig', array(
            'livre' => $livre,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    public function emprunterAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $emprunter = new Emprunter();

        $enfant = $em->getRepository(Enfant::class)->find(1);

        $document = $em->getRepository(Document::class)->find($request->get('id'));

        $date=new \DateTime(Date('yy-m-d', strtotime("+3 days")));
        $emprunter->setEnfant($enfant);
        $emprunter->setDocument($document);
        $emprunter->setDateEmprunt($date);

        $document->setEndDateEmprunt($date);
        $em->persist($emprunter);
        $em->flush();

        return $this->redirectToRoute('app_index');

    }
    public function showlivrefrontAction()
    {
        $em = $this->getDoctrine()->getManager();

        $livres = $em->getRepository(Document::class)->findAll();

        return $this->render('livre/showlivre.html.twig', array(
            'livres' => $livres,
        ));
    }
    public function consulterlivreAction()
    {
        $em = $this->getDoctrine()->getManager();

        $livres = $em->getRepository('BibliothequeBundle:Livre')->getLivreByDate();

        return $this->render('livre/livrefront.html.twig', array(
            'livres' => $livres,
        ));
    }


    /**
     * Deletes a livre entity.
     *
     */
    public function deleteAction(Request $request, Livre $livre)
    {
        $form = $this->createDeleteForm($livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($livre);
            $em->flush();
        }

        return $this->redirectToRoute('livre_index');
    }

    /**
     * Creates a form to delete a livre entity.
     *
     * @param Livre $livre The livre entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Livre $livre)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('livre_delete', array('id' => $livre->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
