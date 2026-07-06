<?php

namespace App\Controller\Admin;

use App\Entity\ImagePrestation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ImagePrestationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ImagePrestation::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            
            ImageField::new('image', 'Fichier image')
                ->setBasePath('uploads/modales/')
                ->setUploadDir('public/uploads/modales/')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(true),

            
            TextField::new('legende', 'Description / Légende')
                ->setHelp('Ajoutez une courte description pour cette image.'),
        ];
    }
}