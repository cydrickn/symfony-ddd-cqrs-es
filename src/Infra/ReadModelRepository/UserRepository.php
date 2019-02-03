<?php

declare(strict_types = 1);

namespace Infra\ReadModelRepository;

use Cydrickn\DDD\Common\ReadModel\AbstractReadModelIterator;
use Cydrickn\DDD\Common\ReadModel\ReadModelInterface;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;
use Domain\User\ReadModel\User;
use Domain\User\ReadModel\UserRepositoryInterface;
use Domain\User\UserId;
use Infra\Iterator\DBALReadModelIterator;

/**
 * Description of UserRepository
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
class UserRepository implements UserRepositoryInterface
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function find(string $id): ?ReadModelInterface
    {
        $queryBuilder = $this->connection->createQueryBuilder()
            ->select('u.*')
            ->from('user', 'u')
            ->where('u.id = :id')
            ->setMaxResults(1)
            ->setParameter('id', $id);

        $result = $queryBuilder->execute()->fetch(FetchMode::ASSOCIATIVE);
        if ($result === false) {
            return null;
        }

        return User::deserialize($result);
    }

    public function findAll(): AbstractReadModelIterator
    {
        $queryBuilder = $this->connection->createQueryBuilder()
            ->select('u.*')
            ->from('user', 'u');

        return new DBALReadModelIterator(User::class, $queryBuilder->execute());
    }

    public function remove(string $id): void
    {

    }

    public function save(ReadModelInterface $readModel): void
    {
        try {
            $this->connection->beginTransaction();
            $data = $readModel->serialize();
            $this->connection->insert('user', $data);
            $this->connection->commit();
        } catch (\Exception $e) {
            $this->connection->rollBack();
            throw $e;
        }
    }

    public function findIdByUsername(string $username): ?UserId
    {
        $queryBuilder = $this->connection->createQueryBuilder()
            ->select('u.id')
            ->from('user', 'u')
            ->where('u.username = :username')
            ->setMaxResults(1)
            ->setParameter('username', $username);

        $result = $queryBuilder->execute()->fetch(FetchMode::ASSOCIATIVE);

        if ($result === false) {
            return null;
        }

        return UserId::fromString($result['id']);
    }
}
