<?php

namespace App\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use App\Entity\User;
    use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AuthController extends AbstractController
{
	public function register(Request $request, UserPasswordEncoderInterface $encoder)
	{
		$em = $this->getDoctrine()->getManager();

		$username  = json_decode($request->getContent())->username;
		$password = json_decode($request->getContent())->password;

		$user = new User();
		$user->setUsername (($username));
		$user->setPassword($encoder->encodePassword($user, $password));
		$user->setRoles(['ROLE_USER']);
		$em->persist($user);
		$em->flush();

		return new Response(sprintf('User %s successfully created', $user->getUsername()));
	}

	public function api()
	{
		return new Response(sprintf('Logged in as %s', $this->getUser()->getUsername()));
	}

	public function getCompleteUser() {
		return $this->json($this->getUser());
	}
}
