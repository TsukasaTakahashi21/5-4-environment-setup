<?php
class IncomesSorter
{
    private $pdo;

    public function __construct($dbUserName, $dbPassword)
    {
        $this->pdo = new PDO(
            'mysql:host=mysql; dbname=tq_quest; charset=utf8',
            $dbUserName,
            $dbPassword
        );
    }

    public function sortIncomes()
    {
        $sql = 'SELECT * FROM incomes';
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        $incomes = $statement->fetchAll(PDO::FETCH_ASSOC);

        $monthTotal = [];
        foreach ($incomes as $income) {
            $date = explode('-', $income['accrual_date']);
            $month = abs($date[1]);
            if (!isset($monthTotal[$month])) {
                $monthTotal[$month] = 0;
            }
            $monthTotal[$month] += $income['amount'];
        }
        arsort($monthTotal);

        foreach ($monthTotal as $month => $total) {
            echo $month. "月:".$total;
            echo '<br />';
        }
    }
}

$incomesSorter = new IncomesSorter('root', 'password');
echo '収入の高い順にsortして月ごとの収入の合計を一覧表示<br/>';
$income = $incomesSorter->sortIncomes();

?>
