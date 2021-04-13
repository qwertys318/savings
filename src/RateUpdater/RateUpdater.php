<?php namespace App\RateUpdater;

use App\Entity\Asset;
use Doctrine\ORM\EntityManagerInterface;
use Traversable;

class RateUpdater
{
    /**
     * RateUpdater constructor.
     * @param Traversable|RateProviderInterface[] $rateProviders
     * @param EntityManagerInterface $em
     */
    public function __construct(
        private Traversable|array $rateProviders,
        private EntityManagerInterface $em,
    )
    {
    }

    public function update(): array
    {
        $result = [];
        /** @var Asset[] $assets */
        $assets = $this->em->getRepository(Asset::class)->findAll();
        foreach ($assets as $asset) {
            $result[$asset->name] = null;
            if (null !== $asset->rateProvider) {
                $provider = $this->getProvider($asset);
                $oldRate = $asset->rate;
                $newRate = $provider->request($asset->rateProviderParams);
                $result[$asset->name] = [$oldRate, $newRate];
                $asset->rate = $newRate;
                $this->em->persist($asset);
            }
        }
        $this->em->flush();

        return $result;
    }

    private function getProvider(Asset $asset): RateProviderInterface
    {
        $className = $asset->rateProvider->class;
        foreach ($this->rateProviders as $provider) {
            if ($provider instanceof $className) {
                return $provider;
            }
        }

        throw new \RuntimeException("Rate Provider '{$className}' didn't found.");
    }
}
