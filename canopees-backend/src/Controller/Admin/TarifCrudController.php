<?php

namespace App\Controller\Admin;

use App\Entity\Tarif;
use App\Controller\Admin\GalleryImageModaleCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;

class TarifCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Tarif::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('titreBloc', 'Titre'),
            TextField::new('prix', 'Prix'),
            TextEditorField::new('texteTarifs', 'Description'),
            
            ImageField::new('image', 'Image de couverture')
                ->setBasePath('uploads/tarifs')
                ->setUploadDir('public/uploads/tarifs')
                ->setUploadedFileNamePattern('[randomhash].[extension]'),

            
            CollectionField::new('imagesGalerie', 'Photos de la modale')
                ->useEntryCrudForm(GalleryImageModaleCrudController::class)
                ->allowAdd()
                ->allowDelete()
                ->setEntryIsComplex(true)
                ->setHelp('Ajoutez ici les images pour votre modale.'),
        ];
    }
}