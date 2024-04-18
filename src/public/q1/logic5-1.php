<?php
class SpendingsDifferenceCalculator {
  private $pdo;

  public function __construct($dbUserName, $dbPassword) {
    $this->pdo = new PDO('mysql:host=mysql; dbname=tq_quest; charset=utf8',
    $dbUserName,
    $dbPassword);
  }

  public function calculateSpendingsDifference() {
    $sql = 'SELECT * FROM spendings';
    $statement = $this->pdo->prepare($sql);
    $statement->execute();
    $spendings = $statement->fetchAll(PDO::FETCH_ASSOC);

    $totalSpendingsAmounts = [];
    for ($month = 1; $month <= 12; $month++) {
      $totalSpendingsAmounts[$month] = 0;
    }
    foreach ($spendings as $spending) {
      $date = explode('-', $spending['accrual_date']);
      $month = abs($date[1]);
      $totalSpendingsAmounts[$month] += $spending['amount'];
    }
  
    for ($i = 1; $i <= 11; $i++) {
        $spendingsDifference = abs(
            $totalSpendingsAmounts[$i+1] - $totalSpendingsAmounts[$i]
        );
        echo $i . '月と' . ($i + 1) . '月の差分: ' . $spendingsDifference . '円';
        echo '<br />';
    }  
  }
}
$calculator = new SpendingsDifferenceCalculator("root", "password");
$calculator->calculateSpendingsDifference();

?>






