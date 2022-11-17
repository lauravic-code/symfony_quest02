<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use App\Repository\ProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;
#[Route('/program', name: 'program_')]
class ProgramController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ProgramRepository $programRepository ): Response
    {
       
        $programs=$programRepository->findAll();

        return $this->render('program/index.html.twig', [
            'programs' => $programs,]
        );
    }


    #[Route('/show/{id}', methods: ['GET'], requirements: ['id'=>'\d+'], name: 'show')]
    public function show(ProgramRepository $programRepository, int $id=4):Response
    {
        $program = $programRepository->findOneBy(['id'=>$id]);
        
        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : '.$id.' found in program\'s table.'
            );
        }
        return $this->render('program/show.html.twig', ['program' =>$program]);
        
    }
}