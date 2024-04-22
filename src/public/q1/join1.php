<?php
class IncomesByCategory {
  private $pdo;

  public function __construct($dbUserName, $dbPassword)
  {
    $this->pdo = new PDO(
      'mysql:host=mysql; dbname=tq_quest; charset=utf8',
      $dbUserName,
      $dbPassword);
  }

  public function getIncomesByCategory() {
    $sql = 'SELECT incomes.amount, income_sources.name
            FROM incomes
            JOIN income_sources 
            ON incomes.income_source_id = income_sources.id';
            
    
    $statement = $this->pdo->prepare($sql);
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

    $output = '';

    foreach ($results as $income) {
      $output .= $income['name'].': ' . $income['amount'] . '<br>';
    }
    return $output;
  }
}

$incomesByCategory = new IncomesByCategory('root', 'password');
echo $incomesByCategory->getIncomesByCategory();
?>