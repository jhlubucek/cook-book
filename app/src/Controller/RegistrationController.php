<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\ResetPasswdFormType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends BaseController
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

//            $user->setRoles(['admin']);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new/passwd", name="app_change_passwd")
     */
    public function updatePasswd(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = $this->userRepository->findOneById($this->getUser()->getId());

        $form = $this->createForm(ResetPasswdFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $passwd = $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                );
            $this->userRepository->upgradePassword($user, $passwd);

//            $user->setRoles(['admin']);
//            $entityManager = $this->getDoctrine()->getManager();
//            $entityManager->persist($user);
//            $entityManager->flush();
            // do anything else you need here, like send an email

            $this->addFlash('success', 'Updated.');
            return $this->redirectToRoute('main_page');
        }

        return $this->render('registration/new_passwd.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
