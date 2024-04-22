<?php
class SpendingsByCategory
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

    public function getSpendingsByCategory()
    {
        $sql = 'SELECT spendings.amount, categories.name
            FROM spendings
            JOIN categories
            ON spendings.category_id = categories.id';

        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        $output = '';

        foreach ($results as $spending) {
            $output .= $spending['name'] . ': ' . $spending['amount'] . '<br>';
        }
        return $output;
    }
}

$spendingsByCategory = new SpendingsByCategory('root', 'password');
echo $spendingsByCategory->getSpendingsByCategory();
?>
