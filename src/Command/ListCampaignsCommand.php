<?php

namespace App\Command;

use App\Repository\CampanaRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:list-campaigns',
    description: 'Add a short description for your command',
)]
class ListCampaignsCommand extends Command
{
    public function __construct(
        private CampanaRepository $campanaRepository
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $campanas = $this->campanaRepository->findAll();

        if (empty($campanas)) {
            $io->warning('No se encontraron campañas');
            return Command::SUCCESS;
        }

        $table = new Table($output);
        $table->setHeaders(['ID', 'Nombre', 'Descripción', 'Inicio', 'Fin', 'Duración (días)']);

        foreach ($campanas as $campana) {
            $duration = $campana->getStartDate()->diff($campana->getEndDate())->days;

            $table->addRow([
                $campana->getId(),
                $campana->getName(),
                $campana->getDescription(),
                $campana->getStartDate()->format('Y-m-d'),
                $campana->getEndDate()->format('Y-m-d'),
                $duration
            ]);
        }

        $table->render();

        return Command::SUCCESS;

    }
}
