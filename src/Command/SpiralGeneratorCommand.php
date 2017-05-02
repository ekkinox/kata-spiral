<?php

namespace Ekkinox\KataSpiral\Command;

use Ekkinox\KataSpiral\Generator\SpiralGenerator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @package Ekkinox\KataSpiral\Command
 */
class SpiralGeneratorCommand extends Command
{
    const NAME = 'spiral:generate';

    /**
     * @var SpiralGenerator
     */
    private $spiralGenerator;

    /**
     * @param SpiralGenerator $spiralGenerator
     */
    public function __construct(SpiralGenerator $spiralGenerator)
    {
        parent::__construct(static::NAME);

        $this->spiralGenerator = $spiralGenerator;
    }

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this
            ->setDescription('Generates a spiral.')
            ->setHelp('This command allows you to generate a spiral.')
            ->addArgument('width', InputArgument::REQUIRED, 'Spiral width ?')
            ->addArgument('height', InputArgument::REQUIRED, 'Spiral height');
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $width  = $input->getArgument('width');
        $height = $input->getArgument('height');

        $output->writeln(
            [
                sprintf('Spiral Generator (%s x %s)', $width, $height),
                '=========================',
                ''
            ]
        );

        $board = $this->spiralGenerator->generate($width, $height);

        $output->writeln($board->getDrawing());
    }
}