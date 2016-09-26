<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/repository")
 */
class ImageController extends Controller
{
    /**
     * @Route("/", name="repository_index")
     */
    public function indexAction()
    {
        $rm = $this->get('registry_manager');

        return $this->render('repository/index.html.twig', array(
            'repositories' => $rm->getRepositories(),
        ));
    }
}
