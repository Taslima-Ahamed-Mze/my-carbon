<?php

namespace App\Service;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class DataStorageService
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function addProduct($product)
    {
        $products[] = $product; // Ajouter le produit au tableau
        $this->session->set('products', $products); // Stocker le tableau de produits dans la session
    }

    public function getProducts()
    {
        return $this->session->get('products', []); // Récupérer le tableau de produits ou retourner un tableau vide s'il n'existe pas
    }
}

