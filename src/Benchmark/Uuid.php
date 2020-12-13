<?php
declare(strict_types=1);

namespace FrankVerhoeven\UuidCompare\Benchmark;

use PhpBench\Benchmark\Metadata\Annotations\BeforeMethods;
use PhpBench\Benchmark\Metadata\Annotations\Iterations;
use PhpBench\Benchmark\Metadata\Annotations\Revs;
use Ramsey\Uuid\Uuid as RamseyUuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Uid\Uuid as SymfonyUuid;

/**
 * @BeforeMethods({"init"})
 */
final class Uuid
{
    private string $uuidString;
    private string $uuidBytes;
    private UuidInterface $ramseyUuid;
    private SymfonyUuid $symfonyUuid;

    public function init(): void
    {
        $this->ramseyUuid = RamseyUuid::uuid4();
        $this->symfonyUuid = SymfonyUuid::v4();
        $this->uuidString = $this->ramseyUuid->toString();
        $this->uuidBytes = $this->ramseyUuid->getBytes();
    }

    /**
     * @Revs(10000)
     * @Iterations(5)
     */
    public function benchRamseyGenerate(): void
    {
        RamseyUuid::uuid4();
    }

    /**
     * @Revs(10000)
     * @Iterations(5)
     */
    public function benchSymfonyGenerate(): void
    {
        SymfonyUuid::v4();
    }

    /**
     * @Revs(10000)
     * @Iterations(5)
     */
    public function benchRamseyFromString(): void
    {
        RamseyUuid::fromString($this->uuidString);

    }

    /**
     * @Revs(10000)
     * @Iterations(5)
     */
    public function benchSymfonyFromString(): void
    {
        new SymfonyUuid($this->uuidString);
    }

    /**
     * @Revs(10000)
     * @Iterations(5)
     */
    public function benchRamseyFromBytes(): void
    {
        RamseyUuid::fromBytes($this->uuidBytes);
    }

    /**
     * @Revs(10000)
     * @Iterations(5)
     */
    public function benchSymfonyFromBytes(): void
    {
        SymfonyUuid::fromString($this->uuidBytes);
    }

    /**
     * @Revs(10000)
     * @Iterations(5)
     */
    public function benchRamseyEquals(): void
    {
        $this->ramseyUuid->equals($this->ramseyUuid);
    }

    /**
     * @Revs(10000)
     * @Iterations(5)
     */
    public function benchSymfonyEquals(): void
    {
        $this->symfonyUuid->equals($this->symfonyUuid);
    }
}
