<?php namespace App\Command;

use App\Entity\Saving;
use App\RateUpdater\RateUpdater;
use Doctrine\ORM\EntityManagerInterface;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ShowSavingsCommand extends Command
{
    private const OPTION_UPDATE_RATES = 'update-rates';

    public function __construct(
        private EntityManagerInterface $em,
        private RateUpdater $rateUpdater,
    )
    {
        parent::__construct();
    }

    public function configure()
    {
        $this->addOption(self::OPTION_UPDATE_RATES, null, InputOption::VALUE_OPTIONAL, 'Update rates?', false);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        if (false !== $input->getOption(self::OPTION_UPDATE_RATES)) {
            $this->updateRates($io);
        }

        $io->title('Your Assets');
        $io->table(
            ['Name', 'Place', 'Amount', 'Rate', 'USD'],
            $this->compileSavingTableData(),
        );

        return 0;
    }

    private function compileSavingTableData(): array
    {
        $savingTableData = [];
        /** @var Saving[] $savings */
        $savings = $this->em->getRepository(Saving::class)->findAll();
        $totalUsd = 0;
        foreach ($savings as $saving) {
            $asset = $saving->asset;
            $place = $saving->place;
            $usd = bcmul($saving->amount, $asset->rate, 8);
            $totalUsd = bcadd($usd, $totalUsd, 8);
            $savingTableData[] = [
                $asset->name,
                $place->name,
                number_format($saving->amount, $asset->decimals),
                number_format($asset->rate, 3),
                number_format($usd, 2),
            ];
        }
        $savingTableData[] = new TableSeparator();
        $savingTableData[] = [
            '',
            '',
            '',
            'Total:',
            number_format($totalUsd, 2),
        ];

        return $savingTableData;
    }

    private function updateRates(SymfonyStyle $io): void
    {
        $io->title('Update Rates');
        $changesData = $this->rateUpdater->update();
        $changesTableData = [];
        foreach ($changesData as $assetName => $result) {
            if (null !== $result) {
                [$oldRate, $newRate] = $result;
                $changeView = $this->compileRateChangeView($oldRate, $newRate);
                $changesTableData[] = [$assetName, $newRate, $changeView];
            } else {
                $changesTableData[] = [$assetName, '', ''];
            }
        }
        $io->table(
            ['Name', 'Rate', 'Change',],
            $changesTableData,
        );
    }

    #[Pure] private function compileRateChangeView(string $oldRate, string $newRate): string
    {
        $change = bcsub($newRate, $oldRate, 8);
        $formatted = number_format($change, 8);
        $comp = bccomp($change, '0', 8);
        return match($comp) {
            1 => sprintf('<fg=green>+%s</>', $formatted),
            -1 => sprintf('<fg=#c0392b>%s</>', $formatted),
            0 => '',
        };
    }
}
