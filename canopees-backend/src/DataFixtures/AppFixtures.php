<?php

namespace App\DataFixtures;

use App\Entity\Prestation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $data = [
            ["Entretiens espaces verts", "Entretien régulier et tonte."],
            ["Conception", "Étude et création de vos extérieurs."],
            ["Taille des haies", "Taille de formation et entretien."],
            ["Élagage", "Taille douce et soins des arbres."],
            ["Abattage", "Abattage sécurisé et démontage."],
            ["Valorisation des déchets verts", "Broyage et recyclage sur site."]
        ];

        foreach ($data as [$titre, $contenu]) {
            $prestation = new Prestation();
            $prestation->setTitre($titre);
            $prestation->setContenuDetaille($contenu);
            $manager->persist($prestation);
        }

        $manager->flush();
    }
}