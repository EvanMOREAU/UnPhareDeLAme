<?php

namespace App\DataFixtures;

use App\Entity\WebsiteElement;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class WEFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $wE1 = new WebsiteElement();
        $wE1->setCode('mod1.1');
        $wE1->setContent('Le Phare de l\'âme');
        $wE2 = new WebsiteElement();
        $wE2->setcode('mod1.2');
        $wE2->setContent('Ravie de vous rencontrer');
        $wE3 = new WebsiteElement();
        $wE3->setcode('mod1.3');
        $wE3->setContent('En savoir plus');
        $wE4 = new WebsiteElement();
        $wE4->setcode('mod2.1');
        $wE4->setContent('Que fais-je ?');
        $wE5 = new WebsiteElement();
        $wE5->setcode('mod2.2');
        $wE5->setContent('"Votre bien-être est mon objectif"');
        $wE6 = new WebsiteElement();
        $wE6->setcode('mod2.3');
        $wE6->setContent('Communication Défuns');
        $wE7 = new WebsiteElement();
        $wE7->setcode('mod2.4');
        $wE7->setContent('Offrez-vous la possibilité d\'établir un lien avec vos proches disparus. À travers des moments de connexion respectueuse, je vous accompagne pour écouter les messages qu\'ils souhaitent transmettre et apaiser votre cœur.');
        $wE8 = new WebsiteElement();
        $wE8->setcode('mod2.5');
        $wE8->setContent('Hypnose');
        $wE9 = new WebsiteElement();
        $wE9->setcode('mod2.6');
        $wE9->setContent('Explorez la puissance de votre esprit pour surmonter les blocages, les peurs ou les habitudes indésirables. Ensemble, nous utilisons l\'hypnose pour débloquer votre potentiel et vous accompagner vers un bien-être durable.');
        $wE17 = new WebsiteElement();
        $wE17->setcode('mod2.7');
        $wE17->setContent('Magnétisme');
        $wE10 = new WebsiteElement();
        $wE10->setcode('mod2.8');
        $wE10->setContent('Ressentez l\'énergie subtile qui circule en vous pour rétablir harmonie et équilibre. Même si les mots manquent parfois pour décrire cette expérience, ses bienfaits parlent d’eux-mêmes. Laissez-vous guider par cette méthode naturelle.');
        $wE11 = new WebsiteElement();
        $wE11->setcode('mod3.1');
        $wE11->setContent('Mes services');
        $wE12 = new WebsiteElement();
        $wE12->setcode('mod3.2');
        $wE12->setContent('Cliquez sur l\'image pour avoir plus de détails');
        $wE13 = new WebsiteElement();
        $wE13->setcode('mod4.1');
        $wE13->setContent('Mon parcours');
        $wE14 = new WebsiteElement();
        $wE14->setcode('mod4.2');
        $wE14->setContent('"Ces dernières années j\'ai beaucoup évolué"');
        $wE15 = new WebsiteElement();
        $wE15->setcode('mod5.1');
        $wE15->setContent('Me contacter');
        $wE16 = new WebsiteElement();
        $wE16->setcode('mod5.2');
        $wE16->setContent('Envoyez moi un mail pour prendre contact');
        
        
        $manager->persist($wE1);
        $manager->persist($wE2);
        $manager->persist($wE3);
        $manager->persist($wE4);
        $manager->persist($wE5);
        $manager->persist($wE6);
        $manager->persist($wE7);
        $manager->persist($wE8);
        $manager->persist($wE9);
        $manager->persist($wE10);
        $manager->persist($wE11);
        $manager->persist($wE12);
        $manager->persist($wE13);
        $manager->persist($wE14);
        $manager->persist($wE15);
        $manager->persist($wE16);
        $manager->persist($wE17);

        $manager->flush();
    }
}
