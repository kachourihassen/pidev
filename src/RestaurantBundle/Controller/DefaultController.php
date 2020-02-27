<?php

namespace RestaurantBundle\Controller;

use PaiementBundle\Entity\Facture;
use RestaurantBundle\Entity\InscriptionRepas;
use RestaurantBundle\Entity\Repas;
use RHBundle\Entity\Enfant;
use RHBundle\Entity\UserParent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('RestaurantBundle:Default:index.html.twig');
    }
    public function inscriptionAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $user=$this->container->get('security.token_storage')->getToken()->getUser();
        $insc = new InscriptionRepas();
        $fact=new Facture();


        if($request->request->get('some_var_name') && $request->request->get('plat') && $request->request->get('enfant') ){
            $arrData = ['plat' => $request->request->get('plat') , 'enfant' => $request->request->get('enfant') , 'user' => $user->getId()];

            $enfant = $this->getDoctrine()->getRepository(Enfant::class)->find($request->request->get('enfant'));
            $monEvenement = $this->getDoctrine()->getRepository(Repas::class)->find($request->request->get('plat'));
            $insc->setEnfant($enfant );
            $insc->setRepas($monEvenement);

            $fact->setMontant($monEvenement->getPrix());
            $fact->setTitre($monEvenement->getNom());
            $fact->setDescription('facture pour evenement');

            $fact->setPayee(0);
            $fact->setDateCreation(new \DateTime());
            $fact->setDatePayement(new \DateTime());
            $insc->setFacture($fact);
            $em->persist($fact);
            $em->persist($insc);
            $em->flush();

            return new JsonResponse($arrData);

        }
        $em = $this->getDoctrine()->getManager();

        $parent=$this->getDoctrine()->getRepository(UserParent::class)->find($user->getId());
        $plats = $em->getRepository('RestaurantBundle:Repas')->findAll();


        return $this->render('plat/indexplatparent.html.twig', array(
            'plats' => $plats,'parent' => $parent
        ));
    }
}
