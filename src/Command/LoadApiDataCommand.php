<?php

namespace App\Command;

use App\Enum\VehicleType;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsCommand(
    name: 'app:load-api-data',
    description: 'Loads data from the upstream API',
)]
class LoadApiDataCommand extends Command
{
    public function __construct(
        private string $apiKey,
        private HttpClientInterface $httpClient
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->writeln('Loading API data.');
        
        $buses = $this->queryAllVehicles(VehicleType::BUS);
        var_dump($buses);
        // TODO: save to db

        return Command::SUCCESS;
    }

    private function queryAllVehicles(VehicleType $vehicleType): array
    {
        $response = $this->httpClient->request('POST', 'https://api.um.warszawa.pl/api/action/busestrams_get', [
            'query' => [
                'resource_id' => 'f2e5503e-927d-4ad3-9500-4ab9e55deb59',
                'apikey' => $this->apiKey,
                'type' => match ($vehicleType) {
                    VehicleType::BUS => '1',
                    VehicleType::TRAM => '2',
                },
            ]
        ]);

        $content = json_decode($response->getContent(), true);

        if (!is_array($content['result'])) {
            throw new \RuntimeException("Invalid request result: {$content['result']}");
        }

        return $content;
    }
}
