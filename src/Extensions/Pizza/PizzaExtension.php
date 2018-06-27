<?php
/**
 * Created by PhpStorm.
 * User: mkardakov
 * Date: 6/26/18
 * Time: 1:55 PM
 */

namespace Pizza\Extensions\Pizza;

use Behat\Behat\Gherkin\ServiceContainer\GherkinExtension;
use Behat\Testwork\Cli\ServiceContainer\CliExtension;
use Behat\Testwork\ServiceContainer\Extension;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Pizza\OrderRegistry;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class PizzaExtension implements Extension
{

    private $order;

    public function __construct()
    {
        $this->order = new OrderRegistry();
    }

    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $container->set('order', $this->order);
    }

    /**
     * Returns the extension config key.
     *
     * @return string
     */
    public function getConfigKey()
    {
        return 'pizza';
    }

    /**
     * Initializes other extensions.
     *
     * This method is called immediately after all extensions are activated but
     * before any extension `configure()` method is called. This allows extensions
     * to hook into the configuration of other extensions providing such an
     * extension point.
     *
     * @param ExtensionManager $extensionManager
     */
    public function initialize(ExtensionManager $extensionManager)
    {
        // TODO: Implement initialize() method.
    }

    /**
     * Setups configuration for the extension.
     *
     * @param ArrayNodeDefinition $builder
     */
    public function configure(ArrayNodeDefinition $builder)
    {
        // TODO: Implement configure() method.
    }

    /**
     * Loads extension services into temporary container.
     *
     * @param ContainerBuilder $container
     * @param array $config
     */
    public function load(ContainerBuilder $container, array $config)
    {
        $definition = new Definition('Pizza\Extensions\Pizza\PizzaController', array(
            new Reference(GherkinExtension::MANAGER_ID),
            $this->order
        ));
        $definition->addTag(CliExtension::CONTROLLER_TAG, array('priority' => 1));
        $container->setDefinition(
            CliExtension::CONTROLLER_TAG . ' .params',
            $definition
        );
    }
}