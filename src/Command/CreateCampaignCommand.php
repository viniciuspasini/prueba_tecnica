<?php

namespace App\Command;

use App\Controller\CampanaController;
use App\Entity\Campana;
use App\Repository\CampanaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Validator\Validator\ValidatorInterface;


#[AsCommand(
    name: 'app:create-campaign',
    description: 'Add a short description for your command',
)]
class CreateCampaignCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ValidatorInterface $validator
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

    private function askForDate(SymfonyStyle $io, string $question): \DateTime
    {
        return $io->askQuestion(
            (new Question($question))
                ->setValidator(function ($value) {
                    if (!\DateTime::createFromFormat('Y-m-d', $value)) {
                        throw new \RuntimeException('Formato de fecha inválido. Use YYYY-MM-DD');
                    }
                    return new \DateTime($value);
                })
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {


        $io = new SymfonyStyle($input, $output);
        $io->title('Crear Nueva Campaña');

        // Solicitar datos
        $name = $io->ask('Nombre de la campaña');
        $description = $io->ask('Descripción de la campaña (opcional)', null);

        // Validar fechas
        $startDate = $this->askForDate($io, 'Fecha de inicio (YYYY-MM-DD)');
        $endDate = $this->askForDate($io, 'Fecha de fin (YYYY-MM-DD)');

        if ($endDate < $startDate) {
            $io->error('La fecha de fin debe ser posterior a la fecha de inicio');
            return Command::FAILURE;
        }

        // Crear la campaña
        $campana = new Campana();
        $campana->setName($name);
        $campana->setDescription($description);
        $campana->setStartDate($startDate);
        $campana->setEndDate($endDate);

        // Validar la entidad
        $errors = $this->validator->validate($campana);
        if (count($errors) > 0) {
            foreach ($errors as $error) {
                $io->error($error->getPropertyPath() . ': ' . $error->getMessage());
            }
            return Command::FAILURE;
        }

        //Persistir en la base de datos
        $this->entityManager->persist($campana);
        $this->entityManager->flush();

        $io->success(sprintf(
            'Campaña creada ',
            $campana->getId(),
            $campana->getName()
        ));

        return Command::SUCCESS;

    }
}
