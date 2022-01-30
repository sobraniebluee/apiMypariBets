<?php

class AccountData
{

    public function getUnwatchedAccountData($data,$param_url)
    {
        if(isset($param_url)) {
            if(strlen($param_url) == 9) {
                $id = htmlspecialchars($param_url);

                $q = Database::$db->prepare("SELECT * FROM `Accounts` WHERE `idPari` = :id AND `CHECKED` = :unchecked");
                $q->execute([
                    ':id' => $id,
                    ':unchecked' => 0
                ]);
                $response = $q->fetch(PDO::FETCH_ASSOC);
                $qNextAccount = Database::$db->prepare("SELECT idPari FROM Accounts WHERE ID = :id");
                $qNextAccount->execute(array(
                    ':id' => $response['ID'] + 1
                ));
                $responseNextAccount = $qNextAccount->fetch(PDO::FETCH_ASSOC);

                if(count($response) > 0) {
                    exit(responseOut(array(
                        'id' => $response['ID'],
                        'idPari' => $response['idPari'],
                        'password' => $response['PASSWORD'],
                        'checked' => $response['CHECKED'] != 0,
                        'description' => $response['DESCRIPTION'],
                        'nextAccount' => $responseNextAccount['idPari']
                    )));
                } else {
                    responseOut(array('error' => 'Is not exists'));
                }
            }
        } else {
            exit(responseOut(array('error' => 'is not set id account')));
        }
    }
    public function editAccountData($data)
    {
        if(isset($data) AND count($data) > 0) {
            $idAccount = $data['idAccount'];
            $freeBets = $data['freebets'];
            try {
                if(isset($idAccount) AND count($freeBets) > 0) {
                    foreach ($freeBets as $key) {
                        $q = Database::$db->prepare("INSERT INTO `FreeBetsWithAccounts`(`ID`,`idAccount`,`idFreeBet`) VALUES (NULL,:idAccount,:idFreeBet)");
                        $q->execute(array(
                            ':idAccount' => $idAccount,
                            ':idFreeBet' => intval($key['id'])
                        ));
                    }
                    $q = Database::$db->prepare("UPDATE `Accounts` SET `CHECKED` = :checked WHERE `ID` = :id");
                    $q->execute(array(
                        ':id' => $idAccount,
                        ':checked' => 1
                    ));

                    exit(responseOut(array('response' => 200)));
                } else {
                    exit(responseOut(array('error' => 'Data is not exists!')));
                }
            } catch (Exception $e) {
                exit(responseOut(array('error' => $e)));
            }
        } else {
            exit(responseOut(array('error' => 'Data is not exists!')));
        }
    }
    public function deleteAccountData($data)
    {
        $idAccount = $data['id'];
        try {
            if(isset($idAccount)) {
                $q = Database::$db->prepare("DELETE FROM `Accounts` WHERE `idPari` = :idAccount");
                $q->execute(array(
                    ':idAccount' => $idAccount
                ));
            } else {
                exit(responseOut(array('error' => 'Id is not exists!')));
            }
            exit(responseOut(array('response' => 200)));
        } catch (Exception $e) {
            exit(responseOut(array('error' => $e)));
        }
    }
}