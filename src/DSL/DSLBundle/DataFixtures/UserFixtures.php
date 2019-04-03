<?php
namespace DSL\DSLBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Psr\Log\LoggerInterface;

class UserFixtures extends Fixture
{
    private $encoder;
    private $userManager;
    private $logger;
    private $adminName;
    private $adminType;
    private $adminRole;    
    private $adminPlainPassword;
    private $adminPopulation;
    private $userName;
    private $userType;
    private $userRole;
    private $userPlainPassword;
    private $userPopulation;
    
    public function __construct(
        UserPasswordEncoderInterface $encoder,
        UserManagerInterface $userManager,
        LoggerInterface $logger,
        string $adminName,
        string $adminType,
        string $adminRole,
        string $adminPlainPassword,
        int $adminPopulation, 
        string $userName,
        string $userType,
        string $userRole,
        string $userPlainPassword,
        int $userPopulation
        ) {
        $this->encoder = $encoder;
        $this->userManager = $userManager;
        $this->logger = $logger;
        $this->adminName = $adminName;
        $this->adminType = $adminType;
        $this->adminRole = $adminRole;
        $this->adminPlainPassword = $adminPlainPassword;
        $this->adminPopulation = $adminPopulation;
        $this->userName = $userName;
        $this->userType = $userType;
        $this->userRole = $userRole;
        $this->userPlainPassword = $userPlainPassword;        
        $this->userPopulation = $userPopulation;
    }
    
    public function load(ObjectManager $manager)
    {
        $this->userCreate($manager, $this->adminType, $this->adminPopulation);
        $this->userCreate($manager, $this->userType, $this->userPopulation);
    }
    
    private function userCreate(ObjectMAnager $manager, string $userType, int $quantity, bool $enabled = true)
    {     
        $sufix = '@test.pl';
        
        switch ($userType) {
            case $this->adminType:
                for ($i=1; $i<=$quantity; $i++) {
                    $user = $this->userManager->createUser();
                    $user->setUsername($this->adminName. $i);
                    $user->setSuperAdmin(true);
                    $user->setEmail($this->adminName . $i . $sufix);
                    $password = $this->encoder->encodePassword($user, $this->adminPlainPassword);
                    $user->setPassword($password);
                    $user->setEnabled($enabled);
                    $manager->persist($user);
                }
                break;
            case $this->userType:
                for ($i=1; $i<=$quantity; $i++) {
                    $user = $this->userManager->createUser();
                    $user->setUsername($this->userName . $i);
                    $user->setSuperAdmin(false);
                    $user->setEmail($this->userName . $i . $sufix);
                    $password = $this->encoder->encodePassword($user, $this->userPlainPassword);
                    $user->setPassword($password);
                    $user->setEnabled($enabled);
                    $manager->persist($user);
                }
                break;
            default:
                $message = sprintf('Typ uzytkownika "%s" nie istnieje.', $userType);
                $this->logger->addError($message);
        }
        $manager->flush();
    }
}
