Feature: Order some pizza
  Do you hungry?

  @my-first-tag
  Scenario: find a pizza
    Given I am on "https://www.pizza-kvartal.com/menu/pizza/"
    Then I am searching some pizza
    Then I open pizza page
    And I wait "3" seconds
    Then I fill in "pa_size" with "31"
    And I wait "3" seconds
    Then I select pizza count
    And I wait "3" seconds
    Then I press "Заказать"
    And I wait "10" seconds
#    Then I should see "Поиск"
## Кастомные инстукции
#    Then I am searching by input params
#    Then I dump users