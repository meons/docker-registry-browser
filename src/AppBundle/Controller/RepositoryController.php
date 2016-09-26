<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/repository")
 */
class RepositoryController extends Controller
{
    /**
     * @Route("/", name="repository_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $rm = $this->get('registry_manager');

        return $this->render('repository/index.html.twig', array(
            'repositories' => $rm->getRepositories(),
        ));
    }

    /**
     * @Route("/{repository}", name="repository_show")
     * @Method("GET")
     */
    public function showAction($repository)
    {
        $rm = $this->get('registry_manager');

        return $this->render('repository/show.html.twig', array(
            'tags' => $rm->getTags($repository),
        ));
    }
}
