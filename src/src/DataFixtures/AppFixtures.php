<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use App\Entity\User;
use App\Entity\Category;
use App\Entity\Post;
use App\Entity\Image;
use App\Entity\Question;
use App\Entity\Response;
use App\Factory\UserFactory;
use App\Factory\CategoryFactory;
use App\Factory\PostFactory;
use App\Factory\ImageFactory;

class AppFixtures extends Fixture
{

    // /**
    //  * @var Generator
    //  */
    
    // private Generator $faker;

    // public function __construct(){
    //     $this->faker=Factory::create("fr_FR");
    // }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        UserFactory::createMany(10);
        CategoryFactory::createMany(7);
        PostFactory::createMany(10, function(){
            return ['userId' => UserFactory::random()];
        });
        ImageFactory::createMany(15, function(){
            return ['postId' => PostFactory::random()];
        });
        PostFactory::all(function(){
            return ['images' => ImageFactory::random()];
        });
        


        // for ($i = 0; $i < 10; $i++) {
        //     $user = new User();
        //     $user->setEmail($this->faker->email());
        //     $user->setRoles(["Admin"]);
        //     $user->setPassword($this->faker->word());
        //     $user->setFirstname($this->faker->firstName());
        //     $user->setLastname($this->faker->lastName());
        //     $user->setAddress($this->faker->streetAddress());
        //     $user->setCity($this->faker->city());
        //     $user->getCreatedAt();
        //     $manager->persist($user);
        // }

        // for ($i = 0; $i < 15; $i++) {
        //     $post = new Post();
        //     $post->setName($this->faker->word());
        //     $post->setDescription($this->faker->sentence());
        //     $post->setPrice($this->faker->randomFloat(2));
        //     $post->getDate($this->faker->dateTime());
        //     $post->getUserId();
        //     $post->getCategories();
        //     $post->getQuestions();
        //     $post->getImages();
        //     $manager->persist($post);
        // }

        // for ($i = 0; $i < 5; $i++) {
        //     $category = new Category();
        //     $category->setName($this->faker->word());
        //     $category->setSlug($this->faker->slug());
        //     $category->getPostId();
        //     $manager->persist($category);
        // }


        // for ($i = 0; $i < 20; $i++) {
        //     $image = new Image();
        //     $image->setLink($this->faker->url());
        //     $image->getPostId();
        //     $manager->persist($image);
        // }

        // for ($i = 0; $i < 5; $i++) {
        //     $question = new Question();
        //     $question->getUserId();
        //     $question->setQuestionText($this->faker->sentence());
        //     $question->getDate();
        //     $manager->persist($question);
        // }

        // for ($i = 0; $i < 2; $i++) {
        //     $response = new Response();
        //     $response->setResponseText($this->faker->sentence());
        //     $response->getQuestionId();
        //     $response->getUserId();
        //     $response->getDate();
        //     $manager->persist($response);
        // }

        // $manager->flush();
    }
}
