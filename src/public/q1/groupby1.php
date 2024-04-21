<?php
class IncomesTotalByMonth {
    private $pdo;

    public function __construct($dbUserName, $dbPassword)
    {
        $this->pdo = new PDO(
            'mysql:host=mysql; dbname=tq_quest; charset=utf8',
            $dbUserName,
            $dbPassword
        );
    }

    public function totalIncomesByMonth() {
        $sql = 'SELECT DATE_FORMAT(accrual_date, "%Y-%m") AS month, SUM(amount) AS total_amount
                FROM incomes
                GROUP BY DATE_FORMAT(accrual_date, "%Y-%m")';

        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        $incomes = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $incomes;
    }
}

$incomesTotalByMonth = new IncomesTotalByMonth('root', 'password');
$totalIncomesAmounts = $incomesTotalByMonth->totalIncomesByMonth();

foreach ($totalIncomesAmounts as $income) {
    echo $income['month'] . "の合計収入:" . $income['total_amount'] . "<br>";
}
?>
