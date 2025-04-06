<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Form\UserEditType;
use App\Repository\UserRepository;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

final class UserController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/user', name: 'app_users')]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/user/{id<\d+>}', name: 'user_show')]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/user/{id<\d+>}/edit', name: 'user_edit')]
    public function edit(Request $request, User $user, UserPasswordHasherInterface $passwordEncoder, EntityManagerInterface $entityManager): Response
    {
        // $this->denyAccessUnlessGranted('EDIT', $user);

        $form = $this->createForm(UserEditType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $email = $form->get('email')->getData();
            // $user->setEmail($email);
            $plainPassword = $form->get('password')->getData();
            if ($plainPassword) {
                $encodedPassword = $passwordEncoder->hashPassword($user, $plainPassword);
                $user->setPassword($encodedPassword);
            }

            $entityManager->flush();

            $this->addFlash('success', 'Your account has been updated.');

            return $this->redirectToRoute('user_show', ['id' => $user->getId()]);
        }

        return $this->render('user/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/user/{id<\d+>}/delete', name: 'user_delete')]
    public function delete(
        Request $request,
        User $user,
        EntityManagerInterface $entityManager,
        TokenStorageInterface $tokenStorage,
        SessionInterface $session
    ): Response {
        if ($request->isMethod('POST')) {
            $currentUser = $this->getUser();
            $entityManager->remove($user);
            $entityManager->flush();

            if ($user === $currentUser) {
                $tokenStorage->setToken(null);
                $session->invalidate();

                $this->addFlash('success', 'Your account has been deleted. You have been logged out.');
                return $this->redirectToRoute('app_home');
            }

            $this->addFlash('success', 'User deleted successfully');
            return $this->redirectToRoute('app_users');
        }

        return $this->render('user/delete.html.twig', [
            'id' => $user->getId(),
        ]);
    }
}
