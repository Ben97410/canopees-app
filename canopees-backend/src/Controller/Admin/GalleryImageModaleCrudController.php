<?php

namespace App\Controller\Admin;

use App\Entity\GalleryImageModale;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class GalleryImageModaleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return GalleryImageModale::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            ImageField::new('image', 'Photo')
                ->setBasePath('uploads/galerie')
                ->setUploadDir('public/uploads/galerie')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),
        ];
    }
}