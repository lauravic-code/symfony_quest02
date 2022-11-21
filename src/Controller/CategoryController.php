<?php

// src/Controller/CategoryController.php
namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;

#[Route('/category', name: 'category_')]
class CategoryController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CategoryRepository $categoryRepository){
     
        $categories =$categoryRepository->findAll();
        return $this->render('category/index.html.twig',['categories'=>$categories]);
    }

    #[Route('/new', name: 'new')]
    public function new(Request $request, CategoryRepository $categoryRepository): Response
    {
        $category = new Category();

        // Create the form, linked with $category
        $form = $this->createForm(CategoryType::class, $category);

         // Get data from HTTP request
        $form->handleRequest($request);
        // Was the form submitted ?
        if ($form->isSubmitted()&& $form->isValid()) {
        // Deal with the submitted data
        $categoryRepository->save($category, true); 
        // For example : persiste & flush the entity
        // And redirect to a route that display the result
        return $this->redirectToRoute('category_index');
    }
        
        // Render the form (best practice)
        return $this->renderForm('category/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{categoryName}', name: 'show')]
    public function show(ProgramRepository $programRepository, CategoryRepository $categoryRepository, string $categoryName){
     
        // $programs =$programRepository->findAll();
        // var_dump($programs);
        $category= $categoryRepository->findOneByName($categoryName);
     
        if (!$category) {
            throw $this->createNotFoundException('Aucune série trouvée');
        }

        $programs =$programRepository->findBy(['category'=>$category],['id'=>'ASC'],3);
     
        return $this->render('category/show.html.twig',['category'=>$category, 'programs'=>$programs]);
    }

   

}