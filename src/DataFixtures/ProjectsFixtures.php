<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\Project;
use App\Entity\TypeProject;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;


class ProjectsFixtures extends BaseFixture implements DependentFixtureInterface
{
    private $referencesIndex = [];


    public function getDependencies(): array
    {
        return [
            ClientsFixture::class,
            TypeProjectFixture::class
        ];
    }


    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(Project::class, 100, function(Project $project) {
            //$project->setContent(
            //    $this->faker->boolean ? $this->faker->paragraph : $this->faker->sentences(2, true)
            //);
            //$project->setAuthorName($this->faker->name);
            //$project->setCreatedAt($this->faker->dateTimeBetween('-1 months', '-1 seconds'));
            //$project->setArticle($this->getRandomReference(Clients::class));

            $project
                ->setCode($this->faker->date($format = 'ny', $max = 'now') . "/". $this->faker->randomLetter() )

                ->setDescription($this->faker->words(3,true))
                ->setClient($this->getRandomReference(Client::class))
                ->setTypeProject($this->getRandomReference(TypeProject::class));
        });
        $manager->flush();
    }
}
