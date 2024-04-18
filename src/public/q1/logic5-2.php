<?php
class IncomesDifferenceCalculator {
  private $pdo;

  public function __construct($dbUserName, $dbPassword) {
    $this->pdo = new PDO('mysql:host=mysql; dbname=tq_quest; charset=utf8',
    $dbUserName,
    $dbPassword);
  }

  public function calculateIncomesDifference() {
    $sql = 'SELECT * FROM incomes';
    $statement = $this->pdo->prepare($sql);
    $statement->execute();
    $incomes = $statement->fetchAll(PDO::FETCH_ASSOC);

    $totalIncomesAmounts = [];
    for ($month = 1; $month <= 12; $month++) {
      $totalIncomesAmounts[$month] = 0;
    }

    foreach ($incomes as $income) {
      $date = explode('-', $income['accrual_date']);
      $month = abs($date[1]);
      $totalIncomesAmounts[$month] += $income['amount'];
    }

    for ($i = 1; $i <= 5; $i++) {
      $incomesDifference = abs ($totalIncomesAmounts[$i + 1] - $totalIncomesAmounts[$i]);
      echo $i . '月と' . ($i + 1) . '月の差分: ' . $incomesDifference . '円';
        echo '<br />';
    }
  }
}

$calculator = new IncomesDifferenceCalculator("root", "password");
$calculator->calculateIncomesDifference();

?>