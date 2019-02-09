<?php

declare(strict_types = 1);

namespace UI\Console\Command\Builder;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

/**
 * Description of CreateDomainCommand
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
class CreateDomainCommand extends Command
{
    protected static $defaultName = 'domain:create';

    /**
     * @var \Twig\Environment
     */
    private $twig;
    private $domainDir;

    public function __construct(string $kernelRoot)
    {
        parent::__construct();
        $this->twig = new \Twig\Environment(new \Twig\Loader\FilesystemLoader(__DIR__ . '/CreateDomain'));
        $this->twig->addFilter(new \Twig_Filter('camel_case', function ($value) {
            return camel_case($value);
        }));
        $this->domainDir = $kernelRoot . '/Domain';
    }

    protected function configure()
    {
        $this
            ->addArgument('namespace', InputArgument::REQUIRED, 'Domain Namespace')
            ->addArgument('domain', InputArgument::REQUIRED, 'Domain Class Name')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        $domain = $input->getArgument('domain');
        $vars = [
            'namespace' => $input->getArgument('namespace'),
            'domain' => $input->getArgument('domain'),
            'fields' => [],
        ];
        $vars['author'] = [
            'name' => $helper->ask($input, $output, new Question('Author: ')),
            'email' => $helper->ask($input, $output, new Question('Author Email: ')),
        ];
        $vars['eventsource'] = $helper->ask($input, $output, new ConfirmationQuestion('With Evensourcing?'));

        $output->writeln('Use snake case for all fields, and leave blank to finish the fields input.');
        do {
            $fieldName = $helper->ask($input, $output, new Question('Field Name: '));
            if ($fieldName !== null) {
                $vars['fields'][] = [
                    'name' => $fieldName,
                    'type' => $helper->ask($input, $output, new Question('Field Type: ')),
                ];
            }
        } while ($fieldName !== null);

        $finder = new \Symfony\Component\Finder\Finder();
        $filesystem = new \Symfony\Component\Filesystem\Filesystem();

        $finder->files()->in(__DIR__ . '/CreateDomain');
        $filesystem->mkdir($this->domainDir . '/' . $domain);

        foreach ($finder as $file) {
            /* @var $file \Symfony\Component\Finder\SplFileInfo */
            if ($file->isFile()) {
                $parse = $this->twig->render($file->getRelativePathname(), $vars);
                $filename = str_replace('Domain', $domain, $file->getFilename());
                $filename = str_replace('.twig', '', $filename);
                $filename = $file->getRelativePath() . '/' . $filename;
                $filesystem->dumpFile($this->domainDir . '/' . $domain . '/' . $filename, $parse);
            }
        }
    }
}
