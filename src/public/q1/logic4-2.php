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
         $sql = 'SELECT * FROM spendings';
         $statement = $this->pdo->prepare($sql);
         $statement->execute();
         $spendings = $statement->fetchAll(PDO::FETCH_ASSOC);

         $totalSpendingsAmounts = [];
         for ($month = 1; $month <= 12; $month++) {
          $totalSpendingsAmounts[$month] = 0;
         }

           foreach ($spendings as $spending) {
               $date = explode('-', $spending['accrual_date']);
               $month = abs($date[1]);
               $day = abs($date[2]);

               $totalSpendingsAmounts[$month] += $spending['amount'];

               if (strpos($day, '5') !== false) {
                  $totalSpendingsAmounts[$month] -= 100;
                  }
            }

            arsort($totalSpendingsAmounts);
            return $totalSpendingsAmounts;
     }
 }

 $spendingsTotalByMonth = new SpendingsTotalByMonth('root', 'password');
 $totalSpendingsAmounts = $spendingsTotalByMonth->totalSpendingsByMonth();

 foreach ($totalSpendingsAmounts as $month => $total) {
  echo $month. "月の支出の合計:".$total."<br>";
 }
 ?>