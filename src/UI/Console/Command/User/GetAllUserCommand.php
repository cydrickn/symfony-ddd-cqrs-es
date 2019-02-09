<?php

declare(strict_types = 1);

namespace UI\Console\Command\User;

use App\Bus\QueryBus;
use App\Query\User\GetAllUser;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Description of GetUserCommand
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
class GetAllUserCommand extends Command
{
    protected static $defaultName = 'user:all';

    /**
     * @var QueryBus
     */
    private $queryBus;

    public function __construct(QueryBus $queryBus)
    {
        parent::__construct();
        $this->queryBus = $queryBus;
    }

    protected function configure()
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $query = new GetAllUser();
        $query->setResponseAsArray();

        $result = $this->queryBus->handle($query);

        $output->writeln(json_encode($result));
    }
}
