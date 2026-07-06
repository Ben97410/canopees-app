<?php

namespace App\Controller\Admin;

use App\Entity\Prestation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;

class PrestationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Prestation::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            
            TextField::new('titre', 'Nom de la prestation'),

            ImageField::new('image', 'Image de couverture')
                ->setBasePath('uploads/prestations/')
                ->setUploadDir('public/uploads/prestations/')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),

            TextEditorField::new('contenuDetaille', 'Description détaillée'),

            CollectionField::new('imagesModale', 'Galerie Photos (Modale)')
                ->useEntryCrudForm(ImagePrestationCrudController::class)
                ->setEntryIsComplex(true)
                ->allowAdd()
                ->allowDelete()
                ->setFormTypeOptions([
                    'by_reference' => false,
                ])
                ->setHelp('Ajoutez ici les images qui apparaîtront dans la fenêtre modale de cette prestation.'),
        ];
    }
}