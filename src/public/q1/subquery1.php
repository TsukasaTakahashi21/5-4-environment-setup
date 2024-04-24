<?php

class IncomeMinusSpendingByMonth {
    private $pdo;

    public function __construct($dbUserName, $dbPassword)
    {
        $this->pdo = new PDO(
            'mysql:host=mysql; dbname=tq_quest; charset=utf8',
            $dbUserName,
            $dbPassword
        );
    }

    public function calculateIncomeMinusSpendingByMonth() {
        $sql = 'SELECT DATE_FORMAT(inc.month, "%Y-%m") AS month,
                (total_income - total_spending) AS income_minus_spending
                FROM (
                    -- サブクエリ1: 収入を集計する
                    SELECT DATE_FORMAT(accrual_date, "%Y-%m-01") AS month, 
                    SUM(amount) AS total_income
                    FROM incomes
                    GROUP BY DATE_FORMAT(accrual_date, "%Y-%m-01")
                ) AS inc
                JOIN (
                    -- サブクエリ2: 支出を集計する
                    SELECT DATE_FORMAT(accrual_date, "%Y-%m-01") AS month, 
                    SUM(amount) AS total_spending
                    FROM spendings
                    GROUP BY DATE_FORMAT(accrual_date, "%Y-%m-01")
                ) AS sp
                ON inc.month = sp.month';

        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $results;
    }
}

$incomeMinusSpendingByMonth = new IncomeMinusSpendingByMonth('root', 'password');
$incomeMinusSpending = $incomeMinusSpendingByMonth->calculateIncomeMinusSpendingByMonth();

foreach ($incomeMinusSpending as $data) {
    echo $data['month'] . "の「合計収入-合計支出」: " . $data['income_minus_spending'] . "<br>";
}
?>
