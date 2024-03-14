<?php

declare(strict_types=1);

namespace App\Command;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class FixtureCommand extends Command
{
    /**
     * @var array
     */
    private array $config;

    /**
     * @var EntityManager
     */
    private EntityManager $entityManager;

    private const OPTIONS = [
        'append' => 'append',
        'class' => 'class',
        'file' => 'file',
        'entityManager' => 'entityManager',
        'truncate' => 'truncate',
    ];

    /**
     * @param array $config
     * @param EntityManager $entityManager
     */
    public function __construct(array $config, EntityManager $entityManager)
    {
        $this->config = $config;
        $this->entityManager = $entityManager;

        parent::__construct();
    }

    /**
     * @return void
     */
    protected function configure(): void
    {
        $this
            ->setName('data-fixtures:load')
            ->setDescription('Load data fixtures to your database')
            ->addOption(self::OPTIONS['append'], null, InputOption::VALUE_NONE, 'Append the data fixtures instead of deleting all data from the database first.')
            ->addOption(self::OPTIONS['truncate'], null, InputOption::VALUE_NONE, 'Purge data by using a database-level TRUNCATE statement.')
            ->addOption(self::OPTIONS['class'], null, InputOption::VALUE_OPTIONAL, 'Load data fixture of a specific class.')
            ->addOption(self::OPTIONS['file'], null, InputOption::VALUE_OPTIONAL, 'Load data fixture of a specific file.')
            ->setHelp(<<<EOT
The <info>%command.name%</info> command loads data fixtures from your application:

  <info>php %command.full_name%</info>

If you want to append the fixtures instead of flushing the database first you can use the <comment>--append</comment> option:

  <info>php %command.full_name%</info> <comment>--append</comment>

By default Doctrine Data Fixtures uses DELETE statements to drop the existing rows from the database.
If you want to use a TRUNCATE statement instead you can use the <comment>--truncate</comment> flag:

  <info>php %command.full_name%</info> <comment>--truncate</comment>

To execute only fixtures that live in a certain class, use:

  <info>php %command.full_name%</info> <comment>--class=SampleFixture</comment>

To execute only fixtures that live in a certain file, use:

  <info>php %command.full_name%</info> <comment>--file=SampleFixture.php</comment>
EOT
            );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $symfonyStyle = new SymfonyStyle($input, $output);

        if (! $input->getOption(self::OPTIONS['append'])) {
            if (! $symfonyStyle->confirm(
                sprintf('Careful, database "%s" will be purged. Do you want to continue?', $this->entityManager->getConnection()->getDatabase()),
                ! $input->isInteractive())
            ) {
                return Command::SUCCESS;
            }
        }

        $loader = new Loader();
        if ($input->getOption(self::OPTIONS['class'])) {
            $class = '\\' . $this->config['orm_default']['namespace'] . '\\' . $input->getOption(self::OPTIONS['class']);
            $loader->addFixture(new $class());
        } elseif ($input->getOption(self::OPTIONS['file'])) {
            $loader->loadFromFile($this->config['orm_default']['directory'] . '/' . $input->getOption(self::OPTIONS['file']));
        } else {
            $loader->loadFromDirectory($this->config['orm_default']['directory']);
        }

        $fixtures = $loader->getFixtures();
        if (! $fixtures) {
            $message = 'Could not find any fixture services to load';

            $symfonyStyle->error($message . '.');

            return Command::FAILURE;
        }

        $ormPurger = new ORMPurger($this->entityManager);
        $ormPurger->setPurgeMode($input->getOption(self::OPTIONS['truncate']) ? ORMPurger::PURGE_MODE_TRUNCATE : ORMPurger::PURGE_MODE_DELETE);

        $executor = new ORMExecutor($this->entityManager, $ormPurger);

        $executor->setLogger(static function ($message) use ($symfonyStyle) : void {
            $symfonyStyle->text(sprintf('  <comment>></comment> <info>%s</info>', $message));
        });

        $executor->execute($fixtures, $input->getOption(self::OPTIONS['append']));

        return Command::SUCCESS;
    }
}
