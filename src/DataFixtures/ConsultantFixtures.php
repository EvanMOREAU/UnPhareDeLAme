<?php

namespace App\DataFixtures;

use App\Entity\Consultant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ConsultantFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $consultants = [
            ['Jean', 'Dupont', '1980-05-15'],
            ['Marie', 'Curie', '1975-12-07'],
            ['Paul', 'Durand', '1990-03-22'],
            ['Sophie', 'Lemoine', '1985-09-10'],
            ['Luc', 'Martin', '1978-07-25'],
            ['Julie', 'Bernard', '1992-11-30'],
            ['Nicolas', 'Morel', '1983-06-17'],
            ['Elise', 'Roux', '1987-04-05'],
            ['Thomas', 'Lefevre', '1995-08-19'],
            ['Claire', 'Simon', '1970-01-27'],
            ['Antoine', 'Girard', '1968-10-11'],
            ['Isabelle', 'Robert', '1982-02-14'],
            ['Pierre', 'Petit', '1991-07-08'],
            ['Catherine', 'Benoit', '1979-12-21'],
            ['Alain', 'Masson', '1965-05-04'],
            ['Camille', 'Gauthier', '1988-03-29'],
            ['François', 'Chevalier', '1974-09-23'],
            ['Charlotte', 'Lambert', '1993-06-12'],
            ['Eric', 'Rousseau', '1981-11-05'],
            ['Valérie', 'Fontaine', '1969-08-31']
        ];

        foreach ($consultants as $data) {
            $consultant = new Consultant();
            $consultant->setFirstName($data[0]);
            $consultant->setLastName($data[1]);
            $consultant->setDateNaiss(new \DateTimeImmutable($data[2]));

            $manager->persist($consultant);
        }

        $manager->flush();
    }
}
