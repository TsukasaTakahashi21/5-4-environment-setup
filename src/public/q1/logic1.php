<!-- 5. よくあるロジックにトライしよう① -->

<?php
class SpendingsAmount {
  private $pdo;

  public function __construct($dbUserName, $dbPassword) {
    $this->pdo = new PDO("mysql:host=mysql;dbname=tq_quest;charset=utf8", $dbUserName, $dbPassword);

  }

  public function getTotalSpendingsAmount() {
    $sql = "SELECT * FROM spendings";
    $statement = $this->pdo->prepare($sql);
    $statement->execute();
    $spendings = $statement->fetchAll(PDO::FETCH_ASSOC);

    $totalSpendingAmount = 0;
    foreach ($spendings as $spending) {
      $totalSpendingAmount += $spending['amount'];
    }
    echo "spendingsテーブルのamountカラムの合計: ".$totalSpendingAmount;
  }
}

  $spendingsAmount = new SpendingsAmount('root', 'password');
  echo $spendingsAmount->getTotalspendingsAmount();

  ?>