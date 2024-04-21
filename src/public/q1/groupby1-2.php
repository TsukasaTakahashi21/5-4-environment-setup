<?php
class SpendingsTotalByMonth {
    private $pdo;

    public function __construct($dbUserName, $dbPassword)
    {
        $this->pdo = new PDO(
            'mysql:host=mysql; dbname=tq_quest; charset=utf8',
            $dbUserName,
            $dbPassword
        );
    }

    public function totalSpendingsByMonth() {
        $sql = 'SELECT DATE_FORMAT(accrual_date, "%Y-%m") AS month, SUM(amount) AS total_amount
                FROM spendings
                GROUP BY DATE_FORMAT(accrual_date, "%Y-%m")';

        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        $spendings = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $spendings;
    }
}

$spendingsTotalByMonth = new SpendingsTotalByMonth('root', 'password');
$totalSpendingsAmounts = $spendingsTotalByMonth->totalSpendingsByMonth();

foreach ($totalSpendingsAmounts as $spending) {
    echo $spending['month'] . "の合計収入:" . $spending['total_amount'] . "<br>";
}
?>
