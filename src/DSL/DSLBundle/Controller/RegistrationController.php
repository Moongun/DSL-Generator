<?php

namespace DSL\DSLBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Controller\RegistrationController as BaseController;
use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\Finder\Exception\AccessDeniedException;

class RegistrationController extends BaseController {
    public function confirmedAction(){
        $user = $this->getUser();
        if (!is_object($user)) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        
        $url = $this->generateUrl('start');
        return $this->redirect($url);
    }
}
