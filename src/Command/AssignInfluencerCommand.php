<?php

namespace App\Command;

use App\Entity\Campana;
use App\Repository\CampanaRepository;
use App\Repository\InfluencersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:assign-influencer',
    description: 'Add a short description for your command',
)]
class AssignInfluencerCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private CampanaRepository $CampanaRepository,
        private InfluencersRepository $influencersRepository
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('campana_id', InputArgument::REQUIRED, 'ID de la campaña')
            ->addArgument('influencer_id', InputArgument::REQUIRED, 'ID del influencer');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $campaignId = $input->getArgument('campana_id');
        $influencerId = $input->getArgument('influencer_id');

        $campaign = $this->CampanaRepository->find($campaignId);
        if (!$campaign) {
            $io->error(sprintf('No se encontró la campaña con ID %d', $campaignId));
            return Command::FAILURE;
        }

        $influencer = $this->influencersRepository->find($influencerId);
        if (!$influencer) {
            $io->error(sprintf('No se encontró el influencer con ID %d', $influencerId));
            return Command::FAILURE;
        }

        // Verificar si ya está asignado
        if ($campaign->getInfluencers()->contains($influencer)) {
            $io->warning(sprintf(
                'El influencer "%s" ya está asignado a la campaña "%s"',
                $influencer->getName(),
                $campaign->getName()
            ));
            return Command::SUCCESS;
        }

        // Asignar el influencer
        $campaign->addInfluencer($influencer);
        $this->entityManager->flush();

        $io->success(sprintf(
            'Influencer "%s" asignado a la campaña "%s"',
            $influencer->getName(),
            $campaign->getName()
        ));

        return Command::SUCCESS;
    }
}
