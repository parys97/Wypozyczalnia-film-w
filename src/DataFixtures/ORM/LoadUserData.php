<?php

namespace App\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData extends Fixture implements OrderedFixtureInterface
{
    /**
     * @var \FOS\UserBundle\Util\UserManipulator
     */
    private $userManipulator;
    
    /**
     * {@inheritDoc}
     */
    public function __construct(\FOS\UserBundle\Util\UserManipulator $userManipulator)
    {
        $this->userManipulator = $userManipulator;
    }
    
    public function load(ObjectManager $manager)
    {
        // user
        $username = "student";
        $password = "student";
        $email = "student@movieshop.pl";
        $inactive = false;
        $superadmin = false;
        
        $this->userManipulator->create($username, $password, $email, !$inactive, $superadmin);
        
        $this->userManipulator->addRole($username, 'ROLE_USER');
        
        // admin
        $username = "admin";
        $password = "admin";
        $email = "admin@movieshop.pl";
        $inactive = false;
        $superadmin = false;
        
        $this->userManipulator->create($username, $password, $email, !$inactive, $superadmin);
        
        $this->userManipulator->addRole($username, 'ROLE_ADMIN');
    }
    
    public function getOrder()
    {
        return 1;
    }
}