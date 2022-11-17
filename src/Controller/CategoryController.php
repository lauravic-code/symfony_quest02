<?php

// src/Controller/CategoryController.php
namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;

#[Route('/category', name: 'category_')]
class CategoryController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CategoryRepository $categoryRepository){
     
        $categories =$categoryRepository->findAll();
        return $this->render('category/index.html.twig',['categories'=>$categories]);
    }

    #[Route('/{categoryName}', name: 'show')]
    public function show(ProgramRepository $programRepository, CategoryRepository $categoryRepository, string $categoryName){
     
        // $programs =$programRepository->findAll();
        // var_dump($programs);
        $category= $categoryRepository->findOneByName($categoryName);
     
        if (!$category) {
            throw $this->createNotFoundException('Aucune série trouvée');
        }

        $programs =$programRepository->findBy(['category'=>$category],['id'=>'ASC']);
     
        return $this->render('category/show.html.twig',['category'=>$category, 'programs'=>$programs]);
    }

}