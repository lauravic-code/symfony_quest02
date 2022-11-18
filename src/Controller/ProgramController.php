<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use App\Entity\Program;
use App\Repository\ProgramRepository;
use App\Repository\SeasonRepository;
use App\Repository\EpisodeRepository;
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
    public function show(Program $program, ProgramRepository $programRepository, int $id=4):Response
    {
        // $program = new Program();
        $programShow = $programRepository->findOneBy(['id'=>$id]);
        
        if (!$programShow) {
            throw $this->createNotFoundException(
                'No program with id : '.$id.' found in program\'s table.'
            );
        }

        $seasons= $program->getSeasons();
        return $this->render('program/show.html.twig', ['program' =>$programShow, 'seasons'=>$seasons ]);
        
    }

    #[Route('/{programId}/seasons/{seasonId}', methods: ['GET'], requirements: ['id'=>'\d+'], name: 'season_show')]
    public function showSeason(int $programId, int $seasonId,ProgramRepository $programRepository,EpisodeRepository $episodeRepository,SeasonRepository $seasonRepository )
    {
        $season=$seasonRepository->findOneBy(['id'=>$seasonId]);
        $program=$programRepository->findOneBy(['id'=>$programId]);
        $episodes=$season->getEpisodes();
        return $this->render('program/season_show.html.twig', ['program' =>$program, 'season'=>$season,'episodes'=>$episodes]);

    }
}