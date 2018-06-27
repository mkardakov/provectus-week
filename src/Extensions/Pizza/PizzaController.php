<?php
/**
 * Created by PhpStorm.
 * User: mkardakov
 * Date: 6/27/18
 * Time: 11:01 AM
 */

namespace Pizza\Extensions\Pizza;


use Behat\Gherkin\Gherkin;
use Behat\Testwork\Cli\Controller;
use Pizza\OrderRegistry;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class PizzaController implements Controller
{

    const PIZZA_NAME = 'pizza-name';

    const PIZZA_COUNT = 'pizza-count';

    /**
     * @var OrderRegistry
     */
    private $order;


    /**
     * PizzaController constructor.
     * @param Gherkin $gherkin
     * @param OrderRegistry $order
     */
    public function __construct(Gherkin $gherkin, OrderRegistry $order)
    {
        $this->order = $order;
    }

    /**
     * Configures command to be executable by the controller.
     *
     * @param SymfonyCommand $command
     */
    public function configure(SymfonyCommand $command)
    {
        $command->addOption( '--' . self::PIZZA_NAME,
            null,
            InputOption::VALUE_REQUIRED,
            "Название пиццы из Итальянского квартала"
        );

        $command->addOption( '--' . self::PIZZA_COUNT,
            null,
            InputOption::VALUE_OPTIONAL,
            "Количество пицц (шт)",
            1
        );
    }

    /**
     * Executes controller.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return null|integer
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $pName = $input->getOption(self::PIZZA_NAME);
        $pCount = $input->getOption(self::PIZZA_COUNT);
        if (!empty($pName)) {
            OrderRegistry::set(self::PIZZA_NAME, $pName);
        }
        if (!empty($pCount)) {
            OrderRegistry::set(self::PIZZA_COUNT, $pCount);
        }
    }
}