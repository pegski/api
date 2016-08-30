<?php

namespace Peg\Bundles\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PegWebBundle:Default:index.html.twig');
    }

    public function timelineAction($shortcode)
    {
        return $this->render('PegWebBundle:Default:timeline.html.twig', ['shortcode' => strtolower($shortcode)]);
    }
}
