<?php

namespace RHBundle\Controller;

use RHBundle\Entity\UserParent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Userparent controller.
 *
 */
class UserParentController extends Controller
{
    /**
     * Lists all userParent entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $query = $em->getRepository('RHBundle:UserParent')->findAll();
        $paginator = $this->get('knp_paginator');
        $inscriptions = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            6 /*limit per page*/
        );
        return $this->render('userparent/index.html.twig', array(
            'userParents' => $inscriptions,
            'error' => null,
            'success' => null
        ));
    }

    /**
     * Creates a new userParent entity.
     *
     */
    public function newAction(Request $request)
    {
        $userParent = new Userparent();
        $form = $this->createForm('RHBundle\Form\UserParentType', $userParent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($userParent);
            $em->flush();

            return $this->redirectToRoute('userparent_show', array('id' => $userParent->getId()));
        }

        return $this->render('userparent/new.html.twig', array(
            'userParent' => $userParent,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a userParent entity.
     *
     */
    public function showAction(UserParent $userParent)
    {
        $deleteForm = $this->createDeleteForm($userParent);

        return $this->render('userparent/show.html.twig', array(
            'userParent' => $userParent,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing userParent entity.
     *
     */
    public function editAction(Request $request, UserParent $userParent)
    {
        $deleteForm = $this->createDeleteForm($userParent);
        $editForm = $this->createForm('RHBundle\Form\UserParentType', $userParent);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('userparent_edit', array('id' => $userParent->getId()));
        }
        return $this->render('userparent/edit.html.twig', array(
            'userParent' => $userParent,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a userParent entity.
     *
     */
    public function deleteAction(Request $request, UserParent $userParent)
    {
        $form = $this->createDeleteForm($userParent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($userParent);
            $em->flush();
        }

        return $this->redirectToRoute('userparent_index');
    }

    /**
     * Creates a form to delete a userParent entity.
     *
     * @param UserParent $userParent The userParent entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(UserParent $userParent)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('userparent_delete', array('id' => $userParent->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
    public function editParentAction($id, Request $request)
    {
        $error = null;
        $success = null;
        $tabTel = $this->getDoctrine()->getRepository(UserParent::class)->findby(["tel" => $request->request->get('tel' . $id)]);
        if (count($tabTel)>1) {
            $error = new Response('numero de telephone existe deja');
        } else {
                $myParent = $this->getDoctrine()->getRepository(UserParent::class)->find($id);
                $myParent->setTel($request->request->get('tel' . $id));
                $myParent->setNom($request->request->get('nom' . $id));
                $myParent->setAdresse($request->request->get('adresse' . $id));
                $myParent->setPrenom($request->request->get('prenom' . $id));
                $this->getDoctrine()->getManager()->persist($myParent);
                $this->getDoctrine()->getManager()->flush();
                $success = new Response('la modification de profile de' . $myParent->getNom() . 'a ete effectue avec succssé');
            }
            return $this->redirectToRoute('userparent_index', array('error' => $error, 'success' => $success));
        }
}