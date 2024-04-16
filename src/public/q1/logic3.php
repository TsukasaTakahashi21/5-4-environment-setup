<?php
class SpendingSorter
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

    public function sortSpending() {
        $sql = 'SELECT * FROM spendings';
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        $spendings = $statement->fetchAll(PDO::FETCH_ASSOC);

        $sort = [];
        foreach ($spendings as $spendingKey => $spending) {
            $sort[$spendingKey] = $spending['amount'];
        }

        array_multisort($sort, SORT_ASC, $spendings);

        foreach ($spendings as $spendingBySort) {
            echo $spendingBySort['amount'];
            echo '<br />';
        }
    }
}

$spendingSorter = new SpendingSorter("root","password");
echo "支出の低い順<br/>";
$spendings = $spendingSorter->sortSpending();

?>