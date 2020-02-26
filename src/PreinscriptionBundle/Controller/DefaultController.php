<?php

namespace PreinscriptionBundle\Controller;

use AppBundle\Entity\User;
use DateTime;
use PreinscriptionBundle\Entity\EnfantPreInscrit;
use PreinscriptionBundle\Entity\InscriptionParent;
use PreinscriptionBundle\Entity\ParentPreInscrit;
use RHBundle\Entity\Classe;
use RHBundle\Entity\Enfant;
use RHBundle\Entity\UserParent;
use RHBundle\Repository\ClasseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $this->getUser();
        $em = $this->getDoctrine()->getManager();
        if ($request->getMethod() == Request::METHOD_POST){
            $userManager = $this->get('fos_user.user_manager');
            $preinscription = new InscriptionParent();
            $preinscription->setDate( new DateTime());
            $preinscription->setStatus("non traitee");
            $parent = new ParentPreInscrit();
            $parent->setNom($request->request->get('nom'));
            $parent->setPrenom($request->request->get('prenom'));
            $parent->setAdresse($request->request->get('adress'));
            $date = DateTime::createFromFormat('Y-m-d', $request->request->get('dateNaissance'));
            $parent->setDateNaissance($date);
            $parent->setEmail($request->request->get('email'));
            $parent->setTel($request->request->get('tel'));
            $em->persist($parent);
             $request->request->get('NbEnf');
            for ($x = 0; $x < $request->request->get('NbEnf'); $x++) {
                $enfant = new EnfantPreInscrit();
                $enfant->setNom($request->request->get('name' . $x));
                $enfant->setPrenom($request->request->get('prenom' . $x));
                $enfant->setSexe($request->request->get('sexe' . $x));
                $dateN = DateTime::createFromFormat('Y-m-d', $request->request->get('date' . $x));
                $enfant->setDateNaissance($dateN);
                print  $enfant->getDateNaissance()->format('Y-m-d');
                $enfant->setParent($parent);
                $em->persist($enfant);
            }
            $preinscription->setParent($parent);
            $em->persist($preinscription);
            $em->flush();
        }
        return $this->render('PreinscriptionBundle:Default:index.html.twig');
    }
    public function inscriptionAction(Request $request){
        $query  = $this->getDoctrine()->getRepository(InscriptionParent::class)->findBy(
            array(),
            array('date' => 'DESC')
        );
        $classes = $this->getDoctrine()->getRepository(Classe::class)->getClassesIncomplet();
        $userManager = $this->get('fos_user.user_manager');
        if ($request->getMethod() == Request::METHOD_POST){
            $insc =  $request->request->get('insc');
            if ( $insc != null){
                $monInscription =  $this->getDoctrine()->getRepository(InscriptionParent::class)->find($insc);
                $parent = $this->getDoctrine()->getRepository(ParentPreInscrit::class)->find($monInscription->getParent()->getId());
                if($userManager->findUserByEmail($parent->getEmail())){
                    return false;
                }
                $newUser = new UserParent();
                $newUser->setNom($parent->getNom());
                $newUser->setPrenom($parent->getPrenom());
                $newUser->setSexe('garçcon');
                $newUser->setDateDeNaissance($parent->getDateNaissance());
                $newUser->setAdresse($parent->getAdresse());
                $newUser->setEmail($parent->getEmail());
                try {
                    $newUser->setPlainPassword($newUser->getNom() . $newUser->getPrenom() . random_int(1, 10000));
                } catch (\Exception $e) {
                }
                $newUser->setEnabled(1);
                try {
                    $newUser->setUsername($newUser->getNom() . $newUser->getPrenom() . $random = random_bytes(10));
                } catch (\Exception $e) {
                }
                $this->getDoctrine()->getManager()->persist($newUser);
                foreach ($parent->getEnfants() as $enfant){
                  $classe = $this->getDoctrine()->getRepository(Classe::class)->find($request->request->get('enfClasse'. $enfant->getId()));
                    $newEnfant = new Enfant();
                    $newEnfant->setSexe($enfant->getSexe());
                    $newEnfant->setPrenom($enfant->getPrenom());
                    $newEnfant->setNom($enfant->getNom());
                    $newEnfant->setDateNaissance($enfant->getDateNaissance());
                    $newEnfant->setParent($newUser);
                    $newEnfant->setClasse($classe);
                    $this->getDoctrine()->getManager()->persist($newEnfant);
                }
                $monInscription->setStatus('validee');
                $this->getDoctrine()->getManager()->persist($monInscription);
                $this->getDoctrine()->getManager()->flush();
            }
        }
        $paginator = $this->get('knp_paginator');
        $inscriptions = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            6 /*limit per page*/
        );
        return $this->render('PreinscriptionBundle:Default:inscription.html.twig', array('inscriptions'=> $inscriptions ,'classes'=>$classes));
    }

    public function refuserInscriptionAction($id)
    {
        $inscription = $this->getDoctrine()->getRepository(InscriptionParent::class)->find($id);
        $inscription->setStatus('refusée');
        $this->getDoctrine()->getManager()->persist($inscription);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('preinscription_homepage_list');
    }


    public function attendreInscriptionAction($id)
    {
        $inscription = $this->getDoctrine()->getRepository(InscriptionParent::class)->find($id);
        $inscription->setStatus('en attente');
        $this->getDoctrine()->getManager()->persist($inscription);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('preinscription_homepage_list');
    }
}
