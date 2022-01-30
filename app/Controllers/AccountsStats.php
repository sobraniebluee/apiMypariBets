<?php

class AccountsStats
{
    public function getStats()
    {
        try {
            $qChecked = Database::$db->prepare("SELECT COUNT(ID) FROM `Accounts` WHERE `CHECKED` = :checked");
            $qChecked->execute(array(
                ':checked' => 1
            ));
            $resChecked = $qChecked->fetch(PDO::FETCH_ASSOC);

            $qUnChecked = Database::$db->prepare("SELECT COUNT(ID) FROM `Accounts` WHERE `CHECKED` = :unchecked");
            $qUnChecked->execute(array(
                ':unchecked' => 0
            ));
            $resUnChecked = $qUnChecked->fetch(PDO::FETCH_ASSOC);

            $qAllAccounts = Database::$db->prepare("SELECT COUNT(ID) FROM `Accounts`");
            $qAllAccounts->execute();

            $resAllCounts = $qAllAccounts->fetch(PDO::FETCH_ASSOC);

            exit(responseOut(array(
                'checkedAccountStats' => intval($resChecked['COUNT(ID)']),
                'unCheckedAccountStats' => intval($resUnChecked['COUNT(ID)']),
                'allAccountsStats' => intval($resAllCounts['COUNT(ID)'])
            )));

        } catch (Exception $e) {
            exit(responseOut(array(
                'error' => $e
            )));
        }
    }
}