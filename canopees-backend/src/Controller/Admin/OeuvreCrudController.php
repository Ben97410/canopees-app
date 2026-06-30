<?php

namespace App\Controller\Admin;

use App\Entity\Oeuvre;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;

class OeuvreCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Oeuvre::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            
            
            TextField::new('titre', 'Titre de l\'œuvre'),
            
           
            ImageField::new('image', 'Image')
                ->setUploadDir('public/uploads/oeuvres')
                ->setBasePath('uploads/oeuvres'),
                
            IntegerField::new('numCarrousel', 'Position Carrousel'),
            
            AssociationField::new('prestation', 'Prestation liée'),
        ];
    }
}