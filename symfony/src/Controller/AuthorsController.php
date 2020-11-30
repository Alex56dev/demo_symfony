<?php

namespace App\Controller;

use App\Repository\AuthorRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Context\Context;

class AuthorsController extends AbstractFOSRestController
{
    private AuthorRepository $authorRepository;
    
    public function __construct(AuthorRepository $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }

    /**
     * @Route("/{_locale}/authors", name="authors",
     *  format="json",
     *  requirements={
     *         "_locale": "en|ru",
     *     }
     * )
     */
    public function index(): Response
    {
        $users = $this->authorRepository->findAll();

        $view = $this->view($users, 200);
        $context = new Context();
        $context->addGroup('user');
        $view->setContext($context);
        $view->setHeader('Page', 1);

        return $this->handleView($view);
    }
}
