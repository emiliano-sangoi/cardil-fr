<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:load-users',
    description: 'Load admin and superadmin users to the table users.',
)]
class LoadUsersCommand extends Command
{

    private UserPasswordHasherInterface $passwordHasher;
    private ManagerRegistry $doctrine;

    public function __construct(UserPasswordHasherInterface $passwordHasher, ManagerRegistry $doctrine)
    {
        $this->passwordHasher = $passwordHasher;
        $this->doctrine = $doctrine;

        parent::__construct(null);
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
        $arg1 = $input->getArgument('arg1');

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        if ($input->getOption('option1')) {
            // ...
        }

        if($this->loadUsers()){
            $io->success('Users loaded sueccesfully!');
        }



        return Command::SUCCESS;
    }

    protected function loadUsers(){

        try{

            // Usuario admin:
            $uAdmin = new User();
            $uAdmin->setUsername('admin');
            $uAdmin->setEmail('emiliano.sangoi@gmail.com');
            $uAdmin->setRoles([User::ROLE_ADMIN]);
            $uAdminPlaintextPassword = '12345';
            // hash the password (based on the security.yaml config for the $user class)
            $hashedPassword = $this->passwordHasher->hashPassword(
                $uAdmin,
                $uAdminPlaintextPassword
            );
            $uAdmin->setPassword($hashedPassword);

            $em = $this->doctrine->getManager();
            $em->persist($uAdmin);
            $em->flush();


            return true;

        }catch (\Exception $ex){
            throw $ex;
        }

        // =============================================================================================================




    }
}
