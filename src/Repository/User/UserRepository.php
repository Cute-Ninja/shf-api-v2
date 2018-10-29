<?php

namespace App\Repository\User;

use App\Entity\User\User;
use App\Repository\AbstractBaseRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * @method User findOneByCriteria(array $criteria = [], array $selects = [])
 * @method User[] findManyByCriteria(array $criteria = [], array $selects = [], array $orders = [], $limit = null): array
 */
class UserRepository extends AbstractBaseRepository implements UserProviderInterface, UserLoaderInterface
{
    /**
     * @param QueryBuilder    $queryBuilder
     * @param string|string[] $username
     *
     * @return bool
     */
    public function addCriterionUsername(QueryBuilder $queryBuilder, $username): bool
    {
        return $this->addCriterion($queryBuilder, $this->getAlias(), 'username', $username);
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param bool         $isAdmin
     *
     * @return bool
     */
    public function addCriterionIsAdmin(QueryBuilder $queryBuilder, $isAdmin): bool
    {
        return $this->addCriterion($queryBuilder, $this->getAlias(), 'isAdmin', $isAdmin);
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param string       $confirmationKey
     *
     * @return bool
     */
    public function addCriterionConfirmationKey(QueryBuilder $queryBuilder, string $confirmationKey): bool
    {
        return $this->addCriterion($queryBuilder, $this->getAlias(), 'confirmationKey', $confirmationKey);
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param string|null  $alias
     */
    public function addSelectCharacter(QueryBuilder $queryBuilder, string $alias = null): void
    {
        $alias = $alias ?? $this->getAlias();

        $queryBuilder->leftJoin($alias . '.character', 'user_character');
        $queryBuilder->addSelect('user_character');
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias(): string
    {
        return 'user';
    }

    public function getDefaultSelects(): array
    {
        return array_merge(['character'], parent::getDefaultSelects());
    }


    ####################################################################################################################
    #                                               AUTHENTICATION                                                     #
    ####################################################################################################################

    /**
     * {@inheritdoc}
     */
    public function loadUserByUsername($username)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->andWhere('user.username = :username OR user.email = :username');
        $queryBuilder->setParameter('username', $username);

        $user = $queryBuilder->getQuery()->getOneOrNullResult();
        if (null === $user) {
            throw new UsernameNotFoundException(sprintf('User "%s" not found.', $username));
        }

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }
        return $this->loadUserByUsername($user->getUsername());
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass($class)
    {
        return $class === 'App\Entity\User';
    }
}