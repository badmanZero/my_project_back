<?php
namespace App\Controller;


use App\Entity\User;
use App\Repository\UserRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserController extends ApiController
{
    /**
    * @Route("/users", methods="GET")
    */
    //public function index(ManagerRegistry $doctrine): Response
    public function index(UserRepository $userRepository)
    {
        $users = $userRepository->transformAll();
        return $this->respond($users);
    }

    /**
    * @Route("/userCo/{username}", methods="GET")
    */
    public function getUserCo(string $username, UtilisateurRepository $utilisateurRepository, UserRepository $userRepository)
    {
        $criteria = array('username' => $username); 
        $users = $userRepository->findOneBy($criteria);
        //$users = $utilisateurRepository->find(1);
        $users = $userRepository->transform($users);

        return $this->respond($users);
    }

    /**
    * @Route("/utilisateurs", methods="GET")
    */
    //public function index(ManagerRegistry $doctrine): Response
    public function getUtilisateur(UtilisateurRepository $utilisateurRepository)
    {
        $users = $utilisateurRepository->transformAll();
        return $this->respond($users);
    }

    /**
    * @Route("/user", methods="POST")
    */
    public function register(Request $request, UserRepository $userRepository, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder)
    {   
        $request = $this->transformJsonBody($request);

        if (! $request) {
            return $this->respondValidationError('Please provide a valid request!');
        }

        $user = new User;
        $user->setUsername($request->get('username'));
        $plainPassword = $request->get('password');
        $encoded = $encoder->encodePassword($user, $plainPassword);
        $user->setPassword($encoded);
        $user->setRoles('ROLE_USER');

        $userRepository->add($user);

        return $this->respondCreated($userRepository->transform($user));
    }

    
}
