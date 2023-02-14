<?php

namespace App\Controller;

use App\Entity\Food;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FoodController extends AbstractController
{
    #[Route('/food', name: 'app_food')]
    public function index(EntityManagerInterface $doctrine): Response
    {
        $repository = $doctrine->getRepository(Food::class);
        $arrayRecepies = $repository->findAll();
        return $this->render('food/showRecipes.html.twig', ["food" => $arrayRecepies]);
    }

    #[Route('/food/new', name: 'add_food')]
    public function addFood(EntityManagerInterface $doctrine): Response
    {
        $food1 = new Food();
        $food1->setName('Roquefort croquettes');
        $food1->setImage('https://www.aromamanchego.com/recursos/imagenes/productos/Imagenes_fichas/Croquetas_queso_azul.jpg');
        $food1->setIngredients(['Flour', 'Milk', 'Roquefort cheese', 'AOVE', 'Salt', 'Black pepper', 'Nutmeg']);
        $food1->setType('Starter');
        $food1->setOrigin('France');
        $food1->setTime('30');
        $food1->setDifficulty('Medium');

        $food2 = new Food();
        $food2->setName('Cheese cake');
        $food2->setImage('https://www.recetasjudias.com/wp-content/uploads/2019/12/Cheesecake2.jpg');
        $food2->setIngredients(['Cream', 'Soft cheese', 'Sugar', 'Gelatine', 'Cookies', 'Butter', 'Strawberry Jam']);
        $food2->setType('Dessert');
        $food2->setOrigin('EEUU');
        $food2->setTime('35');
        
        $food3 = new Food();
        $food3->setName('Lasagna');
        $food3->setImage('https://www.recetasdesbieta.com/wp-content/uploads/2018/10/lasagna-original..jpg');
        $food3->setIngredients(['Lasagna sheets', 'Bechamel sauce', 'Mince meat', 'Tomato sauce', 'Cheese']);
        $food3->setType('Main');
        $food3->setOrigin('Italy');
        $food3->setTime('60');

        $doctrine->persist($food1);
        $doctrine->persist($food2);
        $doctrine->persist($food3);

        $doctrine->flush();

        return new Response("Food inserted correctly");
    }

    #[Route('/food/{id}', name: 'get_recipe')]
    public function get_recipe(EntityManagerInterface $doctrine, $id): Response
    {
        $repository = $doctrine->getRepository(Food::class);
        $recipe = $repository->find($id);
        return $this->render('food/showRecipe.html.twig', ["recipe" => $recipe]);
    }
}


//http://localhost:8888/phpMyAdmin5/index.php?route=/sql&pos=0&db=food&table=food