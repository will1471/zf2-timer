<?php

namespace Auth;

use Auth\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Validator\NoObjectExists;


class UserService
{

    /**
     * @var ObjectManager
     */
    private $om;


    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }


    /**
     * Create a new user.
     *
     * @param string $email
     * @param string $password
     *
     * @return \Auth\Entity\User
     *
     * @throws \Exception on Doctrine problems.
     */
    public function createUser($email, $password)
    {
        $user = new User();
        $user->setEmail($email)
            ->setPassword(password_hash($password, PASSWORD_BCRYPT));

        $this->om->persist($user);
        $this->om->flush();

        return $user;
    }


    /**
     * @param string $message Error message used when email is alread used.
     *
     * @return \Zend\Validator\ValidatorInterface
     */
    public function getUniqueUsernameValidator($message = 'A user with this email already exists.')
    {
        return new NoObjectExists(
            array(
                'object_repository' => $this->om->getRepository(User::class),
                'fields' => array('email'),
                'messages' => array(
                    NoObjectExists::ERROR_OBJECT_FOUND => $message,
                ),
            )
        );
    }

}