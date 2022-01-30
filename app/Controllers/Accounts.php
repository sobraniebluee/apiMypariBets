<?php



class Accounts
{
    private $query;
    private $checked = 1;

    public function getAccounts ($data) {
        try {
                $this->checked = $data['checked'];

                if (isset($data['limit']) and isset($data['page'])) {
                    $limit = $data['limit'];
                    $page = $data['page'];

                    if ($page == '1') {
                        $page = 0;
                    } else {
                        $page = ($page - 1) * $limit;
                    }
                    $this->query = Database::$db->prepare('SELECT * FROM `Accounts` WHERE `CHECKED`= :checked LIMIT :limit OFFSET :offset');
                    $this->query->bindValue(':checked', (int)$this->checked, PDO::PARAM_INT);
                    $this->query->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
                    $this->query->bindValue(':offset', (int)$page, PDO::PARAM_INT);
                    $this->query->execute();
                } else {
                    $this->query = Database::$db->prepare("SELECT * FROM `Accounts` WHERE `CHECKED`=:checked");
                    $this->query->execute([
                        ':checked' => $this->checked,
                    ]);
                }
                $response = $this->query->fetchAll(PDO::FETCH_ASSOC);
                if (count($response) > 0) {
                    exit(responseOut($this->convertToJson($response)));
                } else {
                    exit(responseOut(array('error' => 'No data yet')));
                }
        } catch (Exception $e) {
            exit($e);
        }

    }
    private function convertToJson($array)
    {
        $json = [];

        foreach ($array as $key) {
            $json[] = [
                'id' => $key['ID'],
                'idPari' => $key['idPari'],
                'password' => $key['PASSWORD'],
                'checked' => ($key['CHECKED'] != 0),
                'description' => $key['DESCRIPTION'],
                'freebets' => $this->getFreeBets($key['CHECKED'],$key['ID'])
            ];
        }
        return $json;
    }
    private function getFreeBets($checked,$id)
    {

        if ($checked != 1) return null;

            $freebets = [];
            $q = Database::$db->prepare("SELECT FreeBets.ID,FreeBets.TITLE FROM FreeBets,FreeBetsWithAccounts WHERE FreeBetsWithAccounts.idAccount = :id AND FreeBets.ID = FreeBetsWithAccounts.idFreeBet");
            $q->execute([':id' => $id]);

            $responseFreebets = $q->fetchAll(PDO::FETCH_ASSOC);
            foreach ($responseFreebets as $key => $val) {
                $freebets[] = [
                    'id' => $val['ID'],
                    'title' => $val['TITLE']
                ];
            }
            return (count($freebets) > 0) ? $freebets : null;
    }
}