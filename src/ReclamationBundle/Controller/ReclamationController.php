<?php

namespace ReclamationBundle\Controller;

use ReclamationBundle\Entity\Reclamation;
use ReclamationBundle\Entity\ReclamationAdmin;
use ReclamationBundle\Entity\ReclamationParent;
use ReclamationBundle\Entity\Status;

use ReclamationBundle\Entity\NotificationAdmin;
use ReclamationBundle\Entity\NotificationParent;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

/**
 * Reclamation controller.
 *
 */
class ReclamationController extends Controller
{
    /**
     * Lists all reclamation entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $reclamations = $em->getRepository('ReclamationBundle:Reclamation')->findAll();

        $status = $em->getRepository('ReclamationBundle:Status')->findAll();

        return $this->render('reclamation/index.html.twig', array(
            'reclamations' => $reclamations,
            'status' => $status
        ));
    }

    /**
     * Creates a new reclamation entity.
     *
     */
    public function newAction(Request $request)
    {
        if(in_array('ROLE_PARENT', $this->getUser()->getRoles())) {
            $reclamation = new ReclamationParent();

        }else{
            $reclamation = new ReclamationAdmin();
        }

        $form = $this->createForm('ReclamationBundle\Form\ReclamationType', $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $reclamation->setDateEnvoie(new \DateTime());

            if(in_array('ROLE_PARENT', $this->getUser()->getRoles())) {
                $repository = $this->getDoctrine()->getRepository(Status::class);
                $status = $repository->findOneByLibelle('En cours');

                $reclamation->setStatus($status);
                $reclamation->setParent($this->getUser());

                $notification = new NotificationParent();
                $notification->setTexte("Le parent ".$this->getUser()->getFullNameWithID()." a déposé une réclamation !");

                $em->persist($notification);

            }

            $em->persist($reclamation);
            $em->flush();

            return $this->redirectToRoute('reclamation_index');
        }

        return $this->render('reclamation/new.html.twig', array(
            'reclamation' => $reclamation,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a reclamation entity.
     *
     */
    public function showAction(Reclamation $reclamation)
    {
        $deleteForm = $this->createDeleteForm($reclamation);

        return $this->render('reclamation/show.html.twig', array(
            'reclamation' => $reclamation,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing reclamation entity.
     *
     */
    public function editAction(Request $request, Reclamation $reclamation)
    {
        $deleteForm = $this->createDeleteForm($reclamation);
        $editForm = $this->createForm('ReclamationBundle\Form\ReclamationType', $reclamation);
        $class_name = $this->getDoctrine()->getManager()->getClassMetadata(get_class($reclamation))->getName();

        if((in_array('ROLE_SUPER_ADMIN', $this->getUser()->getRoles())) && ($class_name == "ReclamationBundle\Entity\ReclamationParent") ) {
            $editForm->add('status', EntityType::class, [
                // looks for choices from this entity
                'class' => 'ReclamationBundle:Status',

                // uses the User.username property as the visible option string
                'choice_label' => 'libelle',

                // used to render a select box, check boxes or radios
                // 'multiple' => true,
                // 'expanded' => true,
            ]);
            $editForm->add('reponse');
        }

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reclamation_index');
        }

        return $this->render('reclamation/edit.html.twig', array(
            'reclamation' => $reclamation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a reclamation entity.
     *
     */
    public function deleteAction(Request $request, Reclamation $reclamation)
    {
        $form = $this->createDeleteForm($reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($reclamation);
            $em->flush();
        }

        return $this->redirectToRoute('reclamation_index');
    }

    /**
     * Creates a form to delete a reclamation entity.
     *
     * @param Reclamation $reclamation The reclamation entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Reclamation $reclamation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('reclamation_delete', array('id' => $reclamation->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
