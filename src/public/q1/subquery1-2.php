<?php

class SideIncomeProfitByMonth {
    private $pdo;

    public function __construct($dbUserName, $dbPassword)
    {
        $this->pdo = new PDO(
            'mysql:host=mysql; dbname=tq_quest; charset=utf8',
            $dbUserName,
            $dbPassword
        );
    }

    public function calculateSideIncomeProfitByMonth() {
        $sql = 'SELECT DATE_FORMAT(inc.month, "%Y-%m") AS month,
                (total_income - total_expenses) AS side_income_profit
                FROM (
                  -- サブクエリ: 副業の収入を計算
                    SELECT DATE_FORMAT(i.accrual_date, "%Y-%m-01") AS month,
                    SUM(i.amount) AS total_income
                    FROM incomes i
                    JOIN income_sources s ON i.income_source_id = s.id
                    WHERE s.id = 2
                    GROUP BY DATE_FORMAT(i.accrual_date, "%Y-%m-01")
                ) AS inc
                LEFT JOIN (
                  -- サブクエリ2: 経費の合計を計算
                    SELECT DATE_FORMAT(s.accrual_date, "%Y-%m-01") AS month,
                    (SUM(CASE WHEN c.id = 1 THEN s.amount * 0.5
                              WHEN c.id = 2 THEN s.amount * 0.5
                              WHEN c.id = 3 THEN s.amount * 0.8
                              WHEN c.id = 4 THEN s.amount * 1.0
                              ELSE 0 END)) AS total_expenses
                    FROM spendings s
                    JOIN categories c ON s.category_id = c.id
                    GROUP BY DATE_FORMAT(s.accrual_date, "%Y-%m-01")
                ) AS exp
                ON inc.month = exp.month';

        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $results;
    }
}

$sideIncomeProfitByMonth = new SideIncomeProfitByMonth('root', 'password');
$sideIncomeProfit = $sideIncomeProfitByMonth->calculateSideIncomeProfitByMonth();

foreach ($sideIncomeProfit as $data) {
    echo $data['month'] . 'の「副業の利益」: ' . number_format($data['side_income_profit'], 1) . '<br>';
}
?>
