<?php

namespace Ekkinox\KataSpiral\Command;

use Ekkinox\KataSpiral\Factory\BoardFactory;
use Ekkinox\KataSpiral\Factory\SlotFactory;
use Ekkinox\KataSpiral\Factory\SpiralGeneratorFactory;
use Ekkinox\KataSpiral\Generator\SpiralGenerator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Exception;

/**
 * @package Ekkinox\KataSpiral\Command
 */
class SpiralGeneratorCommand extends Command
{
    const NAME = 'spiral:generate';

    /**
     * @var SpiralGeneratorFactory
     */
    private $spiralGeneratorFactory;

    /**
     * @var BoardFactory
     */
    private $boardFactory;

    /**
     * @var SlotFactory
     */
    private $slotFactory;

    /**
     * @param SpiralGeneratorFactory $spiralGeneratorFactory
     * @param BoardFactory $boardFactory
     * @param SlotFactory $slotFactory
     */
    public function __construct(
        SpiralGeneratorFactory $spiralGeneratorFactory,
        BoardFactory $boardFactory,
        SlotFactory $slotFactory
    ) {
        parent::__construct(static::NAME);

        $this->spiralGeneratorFactory = $spiralGeneratorFactory;
        $this->boardFactory           = $boardFactory;
        $this->slotFactory            = $slotFactory;
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
            ->addArgument('height', InputArgument::REQUIRED, 'Spiral height')
            ->addArgument('way', InputArgument::OPTIONAL, 'Spiral way', SpiralGenerator::WAY_CLOCKWISE);
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $width  = $input->getArgument('width');
        $height = $input->getArgument('height');
        $way    = $input->getArgument('way');

        $this
            ->validateSideSize('width', $width)
            ->validateSideSize('height', $height);

        $output->writeln(
            [
                sprintf('Spiral Generator (%sx%s, %s)', $width, $height, $way),
                ''
            ]
        );

        $spiralGenerator = $this->spiralGeneratorFactory->create(
            $this->boardFactory,
            $this->slotFactory,
            $width,
            $height,
            $way
        );

        $output->writeln($spiralGenerator->generate()->getDrawing());
    }

    /**
     * @param string $type
     * @param int    $size
     *
     * @return SpiralGeneratorCommand
     *
     * @throws Exception
     */
    protected function validateSideSize(string $type, int $size): self
    {
        if ($size < 5) {
            throw new Exception(
                sprintf('%s must be at least of length 5, %s given', $type, $size)
            );
        }

        return $this;
    }
}