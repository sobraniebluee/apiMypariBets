<?php

class FreeBetsData
{
    public function getFreeBetsInfo()
    {
        try {
            $q = Database::$db->prepare("SELECT * FROM FreeBets");
            $q->execute();

            $response = $q->fetchAll(PDO::FETCH_ASSOC);

            $json = [];
            foreach ($response as $key) {
                $json[] = [
                    'id' => $key['ID'],
                    'title' => $key['TITLE']
                ];
            }
            exit(responseOut($json));
        } catch (Exception $e) {
            exit(responseOut(array('error' => $e)));
        }
    }
}