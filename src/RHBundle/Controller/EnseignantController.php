<?php

namespace RHBundle\Controller;

use DateTime;
use RHBundle\Entity\Classe;
use RHBundle\Entity\Enseignant;
use RHBundle\Repository\ClasseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Enseignant controller.
 *
 */
class EnseignantController extends Controller
{
    /**
     * Lists all enseignant entities.
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request  $request)
    {
        $error = null;
        $success = null;
        //$classes = $this->getDoctrine()->getRepository(Classe::class)->getWithoutTeacher();
        $classesrepository = $this->getDoctrine()
            ->getRepository(Classe::class);
        $query = $classesrepository->createQueryBuilder('c')
            ->where('c.enseignant IS NULL')
            ->getQuery();

        $classes = $query->getResult();

        $em = $this->getDoctrine()->getManager();
        if ($request->getMethod() == Request::METHOD_POST){
            $userManager = $this->get('fos_user.user_manager');
            if ($userManager->findUserByEmail($request->request->get('email'))){
                $error = new Response('Email existe déja');
            } else if($userManager->findUserByEmail($request->request->get('tel'))){
                $error = new Response('Numero de telephone  existe déja');
            }else{
                $enseignant = new Enseignant();
                $enseignant->setTel($request->request->get('tel'));
                $enseignant->setNom($request->request->get('nom'));
                $enseignant->setPrenom($request->request->get('prenom'));
                $enseignant->setSexe($request->request->get('sexe'));
                $enseignant->setEmail($request->request->get('email'));
                $enseignant->setSalaire($request->request->get('salaire'));
                $enseignant->setAdresse($request->request->get('adresse'));
                $enseignant->setEnabled(1);
                $date = DateTime::createFromFormat('Y-m-d', $request->request->get('dateNaissance'));
                $enseignant->setDateDeNaissance($date);
                $myClasse=$this->getDoctrine()->getRepository(Classe::class)->find($request->request->get('classe'));

                try {
                    $p = $enseignant->getNom() . $enseignant->getPrenom() . random_int(1, 10000);
                    $enseignant->setPlainPassword($p);
                } catch (\Exception $e) {
                }
                try {
                    $userName = $enseignant->getNom().random_int(1, 100) . $enseignant->getPrenom() . random_int(1, 10000);
                    $enseignant->setUsername($userName);
                } catch (\Exception $e) {
                }
                $em = $this->getDoctrine()->getManager();
                $em->persist($enseignant);
                $myClasse->setEnseignant($enseignant);
                $em->persist($myClasse);
                $em->flush();
                $message = \Swift_Message::newInstance()
                    ->setSubject("accepter")
                    ->setFrom('chamza97@gmail.com')
                    ->setTo('chamza97@gmail.com')
                    ->setBody($this->renderView('default/sendemail.html.twig',array('name'=>$enseignant->getNom(),'username' => $enseignant->getUsername() , 'password' => "$p")),'text/html');
                $this->get('mailer')->send($message);
                $success = new Response( $enseignant->getNom(). ' a ete ajouté avec succée');
            }
        }
        $enseignants = $em->getRepository(Enseignant::class)->findAll();
        return $this->render('enseignant/index.html.twig', array(
            'enseignants' => $enseignants,
            'error' => $error,
            'success' => $success,
            'classes'=>$classes
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
