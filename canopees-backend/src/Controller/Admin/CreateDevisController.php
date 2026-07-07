<?php

namespace App\Controller\Admin;

use App\Entity\DemandeDevis;
use App\Entity\Client;
use App\Entity\Prestation;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

#[AsController]
class CreateDevisController extends AbstractController
{
    public function __invoke(
        Request $request,
        EntityManagerInterface $em,
        ClientRepository $clientRepository
    ): JsonResponse {
        $payload = json_decode($request->getContent(), true);

        if (!$payload) {
            throw new BadRequestHttpException("Format JSON invalide.");
        }

        $devis = new DemandeDevis();
        
        // 1. Hydratation des données
        $devis->setNom($payload['nom'] ?? '');
        $devis->setPrenom($payload['prenom'] ?? '');
        $devis->setEmail($payload['email'] ?? '');
        $devis->setTelephone($payload['telephone'] ?? '');
        $devis->setBudget($payload['budget'] ?? null);
        $devis->setAdresse($payload['adresse'] ?? '');
        $devis->setMessage($payload['message'] ?? '');

        // 2. Gestion Date
        if (!empty($payload['debutTravaux'])) {
            try {
                $devis->setDebutTravaux(new \DateTime($payload['debutTravaux']));
            } catch (\Exception $e) {}
        }

        // 3. Gestion Prestation
        $prestationIri = $payload['prestation'] ?? '';
        preg_match('/(\d+)$/', $prestationIri, $matches);
        $idPrestation = isset($matches[1]) ? (int)$matches[1] : 0;

        if ($idPrestation === 0) {
            throw new BadRequestHttpException("ID de prestation invalide : " . $prestationIri);
        }

        $prestation = $em->getRepository(Prestation::class)->find($idPrestation);
        if (!$prestation) {
            throw new BadRequestHttpException("La prestation sélectionnée n'existe pas.");
        }
        $devis->setPrestation($prestation);

        // 4. Gestion sécurisée du Client (Évite l'erreur "ID not found")
        // On cherche par email, jamais par ID dans le payload
        $client = $clientRepository->findOneBy(['email' => $devis->getEmail()]);
        
        if (!$client) {
            $client = new Client();
            $client->setEmail($devis->getEmail());
        }
        
        // Mise à jour des infos
        $client->setNom($devis->getNom());
        $client->setPrenom($devis->getPrenom());
        $client->setTelephone($devis->getTelephone());
        
        $em->persist($client);
        $devis->setClient($client);

        // 5. Sauvegarde
        $em->persist($devis);
        $em->flush();

        return new JsonResponse([
            'status' => 'success',
            'message' => 'Devis créé avec succès',
            'id' => $devis->getId()
        ], 201);
    }
}