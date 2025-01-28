<?php

declare(strict_types=1);

namespace App\Common\Command;

use App\Common\Service\Reflector\AbstractCache;
use DI\Attribute\Inject;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class TestCommand extends Command
{
    public function __construct(
        #[Inject('cache.user')]
        private AbstractCache $cache
    ) {
        parent::__construct(null);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln($this->cache->getMirror(2));
        return Command::SUCCESS;
    }
}
