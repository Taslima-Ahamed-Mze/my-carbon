<?php

namespace App\Service;

use Symfony\Component\Security\Core\Security;

class DataRenderService
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    
    public function getDataToRender($repository)
    {
        $user = $this->security->getUser();
        $isAdmin = $this->security->isGranted('ROLE_ADMIN');

        if ($isAdmin) {
            $data = $repository->findAll();
        } else {
            $data = $repository->findBy(['createdBy' => $user]);
        }

        return $data;
    }
}
