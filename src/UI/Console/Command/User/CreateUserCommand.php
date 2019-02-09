<?php

declare(strict_types = 1);

namespace UI\Console\Command\User;

use App\Bus\CommandBus;
use App\Command\User\CreateUser;
use Domain\User\UserId;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Description of CreateUserCommand
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
class CreateUserCommand extends Command
{
    protected static $defaultName = 'user:create';

    /**
     * @var CommandBus
     */
    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        parent::__construct();
        $this->commandBus = $commandBus;
    }

    protected function configure()
    {
        $this
            ->addOption('username', null, InputOption::VALUE_OPTIONAL)
            ->addOption('password', null, InputOption::VALUE_OPTIONAL)
            ->addOption('name', null, InputOption::VALUE_OPTIONAL)
            ->setDescription('Add account');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        $usernameQuestion = new Question('Username: ');
        $passwordQuestion = new Question('Password: ');
        $passwordQuestion->setHidden(true);

        $username = $input->getOption('username') ?? $helper->ask($input, $output, $usernameQuestion);
        $password = $input->getOption('password') ?? $helper->ask($input, $output, $passwordQuestion);

        $userId = UserId::generate();
        $command = new CreateUser($userId, $username, $password);
        $this->commandBus->handle($command);

        $output->writeln('id: ' . $userId->toString());
    }
}
