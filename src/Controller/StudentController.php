<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\StudentRepository;
use App\Entity\Student;
use App\Form\StudentType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

final class StudentController extends AbstractController
{
    #[Route('/students', name: 'app_students')]
    public function index(Request $request, EntityManagerInterface $entityManager, StudentRepository $studentRepository): Response
    {
        $limit = 10;
        $page = max(1, (int) $request->query->get('page', 1));
        $offset = ($page - 1) * $limit;

        $query = $entityManager->getRepository(Student::class)
            ->createQueryBuilder('student')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery();

        $students = $query->getResult();

        $totalCount = $entityManager->getRepository(Student::class)->count([]);
        $totalPages = ceil($totalCount / $limit);

        return $this->render('student/index.html.twig', [
            'students' => $students,
            'currentPage' => $page,
            'totalPages' => $totalPages,
        ]);
    }

    #[Route('/student/{id<\d+>}', name: 'student_show')]
    public function show(Student $student): Response
    {
        return $this->render('student/show.html.twig', [
            'student' => $student,
        ]);
    }

    #[Route('/student/create', name: 'student_create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $student = new Student();
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($student);
            $entityManager->flush();
            $this->addFlash('success', 'Student created successfully');
            return $this->redirectToRoute('student_show', ['id' => $student->getId()]);
        }

        $form = $this->createForm(StudentType::class);
        return $this->render('student/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/student/{id<\d+>}/edit', name: 'student_edit')]
    public function edit(Request $request, Student $student, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Student updated successfully');
            return $this->redirectToRoute('student_show', ['id' => $student->getId()]);
        }

        return $this->render('student/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/student/{id<\d+>}/delete', name: 'student_delete')]
    public function delete(Request $request, Student $student, EntityManagerInterface $entityManager): Response
    {
        if ($request->isMethod('POST')) {
            $entityManager->remove($student);
            $entityManager->flush();
            $this->addFlash('success', 'Student deleted successfully');
            return $this->redirectToRoute('app_students');
        }

        return $this->render('student/delete.html.twig', [
            'id' => $student->getId(),
        ]);
    }
}
