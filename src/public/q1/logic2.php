<?php
class SpendingManager {
  private $pdo;

  public function __construct($dbUserName, $dbPassword) {
    $this->pdo = new PDO(
        'mysql:host=mysql; dbname=tq_quest; charset=utf8',
        $dbUserName,
        $dbPassword
    );
  }

  public function getSpending($month) {
    $sql = 'SELECT * FROM spendings';
    $statement = $this->pdo->prepare($sql);
    $statement->execute();
    $spendings = $statement->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($spendings as $spending) {
      $date = explode('-', $spending['accrual_date']);
      $month = abs($date[1]);
      if ($month == 2) {
          echo $spending['name'] . ': ' . $spending['amount'];
          echo '<br />';
      }
    }
  }
}

$spendingManager = new SpendingManager("root", "password");
echo "2月の支出<br/>";
$spendingManager->getSpending(2);
?>




