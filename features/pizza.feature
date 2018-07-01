Feature: Order some pizza
  Are you hungry?

  @just-tag
  Scenario: find a pizza
    Given I am on "https://www.pizza-kvartal.com/menu/pizza/"
    Then I am searching some pizza
    Then I open pizza page
    #Then I follow "Марэ"
    And I wait "2" seconds
    Then I fill in "pa_size" with "31"
    Then I select pizza count
    And I wait "2" seconds
    Then I press "Заказать"
    Then I am on "https://www.pizza-kvartal.com/cart/"
    Then I dump summary info
    And I wait "5" seconds
    Then I follow "Оформить заказ"
    And I wait "1" seconds
    Then I fill in "Имя" with "Provectus"
    And I fill in "Адрес" with "На кудыкину гору"
    And I fill in "Телефон" with "123123123"
    And I wait "10" seconds