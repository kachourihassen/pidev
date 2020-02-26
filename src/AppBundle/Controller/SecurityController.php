<?php


namespace AppBundle\Controller;


use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;


/**
 * Class SecurityController
 *
 * @package AppBundle\Controller
 */
class SecurityController implements AuthenticationSuccessHandlerInterface
{

    private $router;

    /**
     * SecurityController constructor.
     *
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @param Request $request
     *
     * @param TokenInterface $token
     *
     * @return RedirectResponse
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $roles = $token->getRoles();

        $rolesTab = array_map(function ($role) {
            return $role->getRole();
        }, $roles);

        if (in_array('ROLE_ENSEIGNANT', $rolesTab, true)) {
            $redirection = new RedirectResponse($this->router->generate('rh_homepage'));

        } else if (in_array('ROLE_PARENT', $rolesTab, true)) {

            $redirection = new RedirectResponse($this->router->generate('paiement_homepage'));
        }else if (in_array('ROLE_ADMIN', $rolesTab, true)) {

            $redirection = new RedirectResponse($this->router->generate('reclamation_homepage'));
        }


        return $redirection;
    }
}
