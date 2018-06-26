<?php
/**
 * Created by PhpStorm.
 * User: mkardakov
 * Date: 6/25/18
 * Time: 11:09 AM
 */

namespace Pizza\Context;


use Behat\MinkExtension\Context\MinkContext;
use League\CLImate\CLImate;

/**
 * Class KvartalContext
 * @package Pizza\Context
 */
class KvartalContext extends MinkContext
{

    /**
     * @var string
     */
    private $defaultPizza;

    /**
     * @var string
     */
    private $defaultCount;

    /**
     * @var CLImate
     */
    private $climate;


    /**
     * KvartalContext constructor.
     * @param $pizza
     */
    public function __construct(CLImate $CLImate, $pizza, $count)
    {
        $this->defaultPizza = $pizza;
        $this->defaultCount = $count;
        $this->climate = $CLImate;
    }

    /**
     * @Then /^I am searching some pizza$/
     */
    public function searchPizza($pageNumber = 1)
    {
        $foodBlock = $this->getSession()->getPage()
            ->find('css', "ul.products.grid");
        if (!$foodBlock) {
            throw new \Exception('Element contained pizza set is not found');
        }
        if (!$this->lookForPizza($foodBlock->getHtml())) {
            $url = preg_replace(
                '~(?<=/menu/pizza/)(page/\d/?)?$~',
                "page/" . ++$pageNumber,
                $this->getSession()->getCurrentUrl()
            );
            $this->getSession()->visit($url);
            $this->getSession()->wait(3000);
            $this->searchPizza($pageNumber);
        }
    }

    /**
     * @Then /^I open pizza page$/
     */
    public function openPizzaPage()
    {
        $this->getSession()->getPage()
            ->clickLink($this->getPizzaName());
    }

    /**
     * @Then /^I wait "(\d+)" seconds$/
     * @And /^I wait "(\d+)" seconds$/
     */
    public function setTimeout($seconds)
    {
        $this->getSession()->wait($seconds * 1000);
    }

    /**
     * @Then /^I select pizza count$/
     */
    public function setPizzaCount()
    {
        $node = $this->getSession()->getPage()
            ->find('css', '.quantity input[type="number"]');
        if (!$node) {
            die('Pizza counter is not found');
        }
        $node->setValue($this->defaultCount);

    }

    /**
     * @Then /^I dump summary info$/
     */
    public function dumpSummary()
    {
        $page = $this->getSession()->getPage();
        $summaryTable = $page->findAll('css', 'table.shop_table td');
        if (empty($summaryTable)) {
            die('Summary table is not available on a screen');
        }
        $cliTable = [];
        foreach($summaryTable as $column) {
            $cliTable[] = [
                $column->hasAttribute('data-title') ? $column->getAttribute('data-title') : '',
                $column->getText()
            ];
        }

        $this->climate->table($cliTable);
    }

    /**
     * @return int
     */
    private function lookForPizza($html)
    {
        $regex = preg_quote(trim($this->getPizzaName()), '/');
        return preg_match("/$regex/ui", $html);
    }

    /**
     * @return string
     */
    private function getPizzaName()
    {
        return $this->defaultPizza;
    }

}