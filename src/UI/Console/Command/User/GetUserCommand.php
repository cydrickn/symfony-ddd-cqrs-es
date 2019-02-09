<?php

declare(strict_types = 1);

namespace UI\Console\Command\User;

use App\Bus\QueryBus;
use App\Query\User\GetUser;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

/**
 * Description of GetUserCommand
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
class GetUserCommand extends Command
{
    protected static $defaultName = 'user:get';

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
        $this->addArgument('id', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $query = new GetUser($input->getArgument('id'));
        $query->setResponseAsArray();

        $result = $this->queryBus->handle($query);

        $output->writeln(json_encode($result));
    }
}
