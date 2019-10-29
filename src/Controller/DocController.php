<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DocController extends AbstractController
{
    /**
     * @Route("/doc", name="doc")
     */
    public function index()
    {
        return $this->render('doc/index.html.twig');
    }

    /**
     * @Route("/doc/ville", name="docVille")
     */
    public function docVille()
    {
        return $this->render('doc/ville.html.twig');
    }

    /**
     * @Route("/doc/localisation", name="docLocalisation")
     */
    public function docLocalisation()
    {
        return $this->render('doc/localisation.html.twig');
    }

    /**
     * @Route("/doc/departement", name="docDepartement")
     */
    public function docDepartement()
    {
        return $this->render('doc/departement.html.twig');
    }

    /**
     * @Route("/doc/nom-ville", name="docNomVille")
     */
    public function docNomVIlle()
    {
        return $this->render('doc/nom-ville.html.twig');
    }

    /**
     * @Route("/doc/nom-departement", name="docNomDepartement")
     */
    public function docNomDepartement()
    {
        return $this->render('doc/nom-departement.html.twig');
    }
}
