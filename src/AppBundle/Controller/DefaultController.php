<?php

namespace AppBundle\Controller;

use RestaurantBundle\Entity\Repas;
use RHBundle\Entity\UserParent;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DefaultController extends Controller
{
    
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    public function adminAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => "Admin test page",
        ]);
    }
    public function pdfAction(Request $request,$id) {

        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $parent = $this->getDoctrine()->getRepository(UserParent::class)->find($user->getId());


        //pdf
        $snappy = $this->get('knp_snappy.pdf');
        $snappy->setOption('no-outline', true);
        $snappy->setOption('page-size','LETTER');
        $snappy->setOption('encoding', 'UTF-8');
        $snappy->setOptions(['user-style-sheet' => realpath('pdfstyle.css')]);

        $em = $this->getDoctrine()->getManager();
        $repas = $this->getDoctrine()->getRepository(Repas::class)->find($id);

        //print $repas->getId();
        // $repas=$this->getParameter(nom);
        //$tab=$plat->plats;

        $html = $this->renderView('pdf.html.twig', array(
            //..Send some data to your view if you need to //
            "id"=>$id,
            "repas"=>$repas,
            //"plat"=>$plats,
            "title"=>"hey safi"
        ));

        $filename = 'myFirstSnappyPDF';

        return new Response(
            $snappy->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'inline; filename="'.$filename.'.pdf"'
            )
        );

    }
    public function indexparentAction()
    {
        // replace this example code with whatever you need
        return $this->render('indexParent.html.twig');
    }
    public function logAction(Request $request){
        $session = $request->getSession();

       //$authErrorKey = Security::AUTHENTICATION_ERROR;
        //$lastUsernameKey = Security::LAST_USERNAME;
        $authChecker = $this->container->get('security.authorization_checker');
        $router = $this->container->get('router');
        if ($authChecker->isGranted('ROLE_ADMIN')) {
            return new RedirectResponse($router->generate('admin_home'), 307);
        }

        if ($authChecker->isGranted('ROLE_PARENT')) {
            return new RedirectResponse($router->generate('parent_home'), 307);
        }
        if ($authChecker->isGranted('ROLE_ENSEIGNANT')) {
            return new RedirectResponse($router->generate('enseignant_home'), 307);
        }
    }
    public function admin_homeAction()
    {
        // replace this example code with whatever you need
        return $this->render('admin1.html.twig');
    }
    public function parent_homeAction()
    {
        // replace this example code with whatever you need
        return $this->render('base1.html.twig');
    }
    public function enseignant_homeAction()
    {
        // replace this example code with whatever you need
        return $this->render('ense.html.twig');
    }
}
