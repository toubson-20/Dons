<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\EditProfileType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UtilisateurController extends AbstractController
{
    #[Route('/utilisateur', name: 'app_utilisateur')]
    public function index(Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        // récupération de l'utilisateur connecté
        $utilisateur = $this->getUser();

        return $this->render('utilisateur/profil.html.twig', [
            'controller_name' => 'UtilisateurController',
            'utilisateur' => $utilisateur,
        ]);
    }

    #[Route('/utilisateur/editProfil', name: 'app_edit_profil')]
    public function editProfile(Request $request, EntityManagerInterface $em)
    {
        $user = $this->getUser();
        $form = $this->createForm(EditProfileType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($user);
            $em->flush();

            $this->addFlash('message', 'Profil mis à jour');
            return $this->redirectToRoute('app_utilisateur');
        }

        return $this->render('utilisateur/editProfil.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // fonctionne malgré l'erreur

    #[Route('/utilisateur/editPassword', name: 'app_edit_password')]
    public function editPassword(Request $request, UserPasswordHasherInterface $passwordEncoder, EntityManagerInterface $entityManager)
    {
        $user = $this->getUser();
        if ($request->isMethod('POST')) {
            // verifier si le mot de passe actuel est valide
            if ($passwordEncoder->isPasswordValid($user, $request->request->get('latestPassword'))) {
                if ($request->request->get('password') == $request->request->get('confirmPassword')) {

                    // Encoder le nouveau mot de passe
                    $hashedPassword = $passwordEncoder->hashPassword($user, $request->request->get('password'));

                    // Mettre à jour l'entité User en base de données
                    $user->setPassword($hashedPassword);
                    $entityManager->flush();

                    $this->addFlash('succes', 'Mot de passe mis à jour');

                    return $this->redirectToRoute('app_utilisateur');
                } else {
                    $this->addFlash('error1', 'Les mots de passe ne sont pas identiques');
                }
            } else {
                $this->addFlash('error2', 'Dernier mot de passe incorrect');
            }
        }


        return $this->render('utilisateur/editPassword.html.twig');
    }
}
