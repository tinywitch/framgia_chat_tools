<?php

namespace User\Controller;

use User\Form\UserForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\Result;
use Zend\Uri\Uri;
use User\Form\LoginForm;
use User\Entity\User;

/**
 * This controller is responsible for letting the user to log in and log out.
 */
class AuthController extends AbstractActionController
{
    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * Auth manager.
     * @var User\Service\AuthManager
     */
    private $authManager;

    /**
     * Auth service.
     * @var \Zend\Authentication\AuthenticationService
     */
    private $authService;

    /**
     * User manager.
     * @var User\Service\UserManager
     */
    private $userManager;

    /**
     * Constructor.
     */
    public function __construct($entityManager, $authManager, $authService, $userManager)
    {
        $this->entityManager = $entityManager;
        $this->authManager = $authManager;
        $this->authService = $authService;
        $this->userManager = $userManager;
    }

    /**
     * Authenticates user given email address and password credentials.
     */
    public function submitLoginAction()
    {
        $request = $this->getRequest();
        $response = $this->getResponse();
        $data = $this->params()->fromPost();


        $result = $this->authManager->login($data['email'],
            $data['password'], true);


        return $this->redirect()->toRoute('home');
    }

    public function submitLogoutAction()
    {
        $this->authManager->logout();
        return $this->redirect()->toRoute('login');
    }

    public function submitRegisterAction()
    {
        $request = $this->getRequest();
        $response = $this->getResponse();
        $data = $this->params()->fromPost();

        $user = $this->userManager->addUser($data);

        $result = $this->authManager->login($data['email'],
            $data['password'], true);

        return $this->redirect()->toRoute('home');
    }

    public function loginAction()
    {
        $this->userManager->createAdminUserIfNotExists();
        return new ViewModel();
    }

    public function registerAction()
    {
        return new ViewModel();

    }

    public function getCurrentUserAction()
    {
        $user = $this->userManager->currentUser($this->authService->getIdentity());
        $response = $this->getResponse();
        $response->setContent(json_encode($user->getData()));
        return $response;
    }


}
