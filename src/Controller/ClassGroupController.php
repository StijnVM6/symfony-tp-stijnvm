<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ClassGroupRepository;
use App\Entity\ClassGroup;
use App\Form\ClassGroupType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

final class ClassGroupController extends AbstractController
{
    #[Route('/classGroups', name: 'app_classGroups')]
    public function index(ClassGroupRepository $classGroupRepository): Response
    {
        return $this->render('classGroup/index.html.twig', [
            'classGroups' => $classGroupRepository->findAll(),
        ]);
    }

    #[Route('/classGroup/{id<\d+>}', name: 'classGroup_show')]
    public function show(ClassGroup $classGroup): Response
    {
        return $this->render('classGroup/show.html.twig', [
            'classGroup' => $classGroup,
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/classGroup/create', name: 'classGroup_create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $classGroup = new ClassGroup();
        $form = $this->createForm(ClassGroupType::class, $classGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($classGroup);
            $entityManager->flush();
            $this->addFlash('success', 'ClassGroup created successfully');
            return $this->redirectToRoute('classGroup_show', ['id' => $classGroup->getId()]);
        }

        $form = $this->createForm(ClassGroupType::class);
        return $this->render('classGroup/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/classGroup/{id<\d+>}/edit', name: 'classGroup_edit')]
    public function edit(Request $request, ClassGroup $classGroup, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ClassGroupType::class, $classGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'ClassGroup updated successfully');
            return $this->redirectToRoute('classGroup_show', ['id' => $classGroup->getId()]);
        }

        return $this->render('classGroup/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/classGroup/{id<\d+>}/delete', name: 'classGroup_delete')]
    public function delete(
        Request $request,
        ClassGroup $classGroup,
        EntityManagerInterface $entityManager
    ): Response {
        $students = $classGroup->getStudents();

        // Get all other class groups (excluding current one)
        $otherClassGroups = $entityManager->getRepository(ClassGroup::class)
            ->createQueryBuilder('class')
            ->where('class != :current')
            ->setParameter('current', $classGroup)
            ->getQuery()
            ->getResult();

        if ($request->isMethod('POST')) {
            $newClassGroupId = $request->request->get('new_class_group');
            $newClassGroup = $entityManager->getRepository(ClassGroup::class)->find($newClassGroupId);

            if ($newClassGroup) {
                foreach ($students as $student) {
                    $student->setClassGroup($newClassGroup);
                }

                $entityManager->remove($classGroup);
                $entityManager->flush();

                $this->addFlash('success', 'Class group reassigned and deleted successfully.');
                return $this->redirectToRoute('app_classGroups');
            } else {
                $this->addFlash('error', 'Selected class group not found.');
            }
        }

        return $this->render('classGroup/delete.html.twig', [
            'classGroup' => $classGroup,
            'students' => $students,
            'otherClassGroups' => $otherClassGroups,
        ]);
    }
}
