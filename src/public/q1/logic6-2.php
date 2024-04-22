<?php
class SpendingsByCategory {
  private $pdo;

  public function __construct($dbUserName, $dbPassword) {
    $this->pdo = new PDO(
      'mysql:host=mysql; dbname=tq_quest; charset=utf8',
      $dbUserName,
      $dbPassword);
  }

  public function getSpendingsByCategory($categoryName)
  {
      $spendings = $this->getSpendings();
      $categoryId = $this->getCategoryId($categoryName);

      $categorySpendings = [];
      foreach ($spendings as $spending) {
          if ($spending['category_id'] == $categoryId) {
              $categorySpendings[] = $spending;
          }
      }

      return $categorySpendings;
  }
  
  private function getSpendings() {
    $spendingsSql = 'SELECT * FROM spendings';
    $statement = $this->pdo->prepare($spendingsSql);
    $statement->execute();
    return $spendings = $statement->fetchAll(PDO::FETCH_ASSOC);
  }

  private function getCategoryId($categoryName) {
    $categoriesSql = 'SELECT * FROM categories';
    $statement = $this->pdo->prepare($categoriesSql);
    $statement->execute();
    $categories = $statement->fetchAll(PDO::FETCH_ASSOC);

    foreach ($categories as $category) {
      if ($category['name'] == $categoryName) {
        return $category['id'];
    }
  }
  return null;
  }
}
$spendingsByCategory  = new SpendingsByCategory ('root', 'password');
$categoryName = "交際費";
$categorySpendings = $spendingsByCategory->getSpendingsByCategory($categoryName);

foreach ($categorySpendings as $spending) {
        echo $spending['accrual_date'] .
            'に支払った' .
            $spending['name'] .
            '料金: ' .
            $spending['amount'];
        echo '<br />';

}
?>
