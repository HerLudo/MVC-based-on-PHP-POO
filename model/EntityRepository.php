<?php

namespace Model;

class EntityRepository
{
    private $db; 
    private $tablepatients;
    private $tableappointments; 

    //méthode permettant de construire la connexion à la bdd et de retourner un objet PDO
    public function getDb()
    {
        if(!$this->db)
        {
            try
            {
                //Récupération des infos contenues dans le fichier XML
                $xml=simplexml_load_file('app/config.xml');
                $this->tablepatients=$xml->table1;
                $this->tableappointments=$xml->table2;
                try
                {
                    $this->db= new \PDO("mysql:host=". $xml->host ."; dbname=" . $xml->db, $xml->user, $xml->password, [
                        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
                    ]);
                }
                catch(\PDOException $e)
                {
                echo"Message : " . $e->getMessage();
                }
            }
            catch(\Exception $e)
            {
                echo"Message : ".$e->getMessage();
            }
        }
        return $this->db;
    }

    //Fonction qui récupère tous les enregistrements dans les tables patients et apppointments
    public function selectAllRepo(string $data)
    {
        switch ($data)
        {
            case 'patient':
                $q=$this->getDb()->prepare("SELECT * FROM " .$this->tablepatients. " ORDER BY lastname");
                $q->execute();
                $r=$q->fetchAll(\PDO::FETCH_ASSOC);
                return $r;
            break;

            case 'rdv':
                $q=$this->getDb()->prepare("SELECT appointments.id, appointments.dateHour, patients.lastname, patients.firstname  FROM " .$this->tableappointments." INNER JOIN ".$this->tablepatients." ON ".$this->tableappointments.".idPatients=".$this->tablepatients.".id" );
                $q->execute();
                $r=$q->fetchAll(\PDO::FETCH_ASSOC);
            return $r; 
                break;
        }   
    }

    //Méthode qui permet de sélectionner un enregistrement dans les tables patients ou apppointments avec les informations connexes
    public function selectRepo (int $id, string $data, $verif=true)
    {
        switch ($data)
        {
            case 'patient':
                if($verif)
                {
                $q=$this->getDb()->prepare("SELECT patients.id, patients.lastname, patients.firstname, patients.birthdate, patients.phone, patients.mail, appointments.dateHour FROM " .$this->tablepatients." INNER JOIN ".$this->tableappointments." ON ".$this->tablepatients.".id = ".$this->tableappointments.".idPatients AND patients.id=".$id );
                $q->execute();
                $r=$q->fetchAll(\PDO::FETCH_ASSOC);
                }
                else 
                {
                $q=$this->getDb()->prepare("SELECT * FROM ".$this->tablepatients." WHERE id= ".$id);
                $q->execute();
                $r=$q->fetchAll(\PDO::FETCH_ASSOC);
                }
                return $r;
            break;

            case 'rdv':
                $q=$this->getDb()->prepare("SELECT appointments.id, appointments.dateHour, patients.lastname, patients.firstname  FROM " .$this->tableappointments." INNER JOIN ".$this->tablepatients." ON ".$this->tableappointments.".idPatients=".$this->tablepatients.".id AND appointments.id=".$id );
                $q->execute();
                $r=$q->fetchAll(\PDO::FETCH_ASSOC);
                return $r; 
            break;
        } 
    }

    //Méthode qui permet de retrouver un patient par son nom
    public function findPatient(string $name)
    {
        $q=$this->getDb()->prepare("SELECT * FROM ".$this->tablepatients." WHERE lastname=:lastname OR firstname=:firstname OR phone=:phone OR mail=:mail");
        $q->bindValue(':lastname', $name, \PDO::PARAM_STR);
        $q->bindValue(':firstname', $name,\PDO::PARAM_STR );
        $q->bindValue(':phone', $name, \PDO::PARAM_INT);
        $q->bindValue(':mail', $name, \PDO::PARAM_STR);
        $q->execute();
        $r=$q->fetchAll(\PDO::FETCH_ASSOC);
        return $r;
                
    }

    //Méthode qui permet de supprimer un enregistrement dans les tables patients ou apppointments
    public function deleteRepo(int $id, string $data)
    {
        switch ($data)
        {
            case 'patient':
                $q=$this->getDb()->prepare("DELETE FROM " .$this->tablepatients. " WHERE id=" .$id);
                $q->execute();
            break;

            case 'rdv':
                $q=$this->getDb()->prepare("DELETE FROM " .$this->tableappointments. " WHERE id=" . $id);
                $q->execute();
            break;
        }  
    }

    //Méthode qui récupère le nom des champs dans les tables patients ou apppointments
    public function getFieldsRepo(string $data)
    {
        switch ($data)
        {
            case 'patient':
                $q=$this->getDb()->prepare("DESC ".$this->tablepatients);  
                $q->execute();
                $r=$q->fetchAll(\PDO::FETCH_ASSOC);
                return $r;
            break;

            case 'rdv':
                $q=$this->getDb()->prepare("DESC ".$this->tableappointments);  
                $q->execute();
                $r=$q->fetchAll(\PDO::FETCH_ASSOC);
                return $r;
            break;

            //On renvoie les résultats des 2 cas précédents dans un seul et unique tableau.
            case 'rdvpatient' :
                $patient=$this->getFieldsRepo('patient');
                $rdv=$this->getFieldsRepo('rdv');
                $r=[];
                foreach($patient as $dataPatients)
                {
                    foreach($dataPatients as $key=>$value)
                    {
                        if($key=='Field')
                        $r[]=$value;
                    }
                }
                foreach($rdv as $dataRdv)
                {
                    foreach($dataRdv as $key=>$value)
                    {
                        if($key=='Field')
                        $r[]=$value;
                    }
                }
                ;
                
                return $r;
            break;
        }  
        
    }

    //Méthode qui permet la création ou la mise à jour d'enregistrement dans les tables patients ou apppointments
    public function saveRepo($data)
    {
        
        switch ($data)
        {
            case 'patient':
                $id=isset($_GET['id']) ? $_GET['id'] : 'NULL';
                $q=$this->getDb()->prepare("REPLACE INTO ". $this->tablepatients ."(id, lastname, firstname, birthdate, phone, mail) VALUES (:id, :lastname, :firstname, :birthdate, :phone, :mail)");
                $q->bindValue(':id', $id, \PDO::PARAM_INT);
                $q->bindValue(':lastname', mb_strtoupper($_POST['lastname']), \PDO::PARAM_STR);
                $q->bindValue(':firstname', mb_strtoupper($_POST['firstname']), \PDO::PARAM_STR);
                $q->bindValue(':birthdate', $_POST['birthdate'], \PDO::PARAM_STR);
                $q->bindValue(':phone', $_POST['phone'], \PDO::PARAM_STR);
                $q->bindValue(':mail', mb_strtoupper($_POST['mail']), \PDO::PARAM_STR);
                $q->execute();
            break;

            case 'rdv':
                $id=isset($_GET['id']) ? $_GET['id'] : 'NULL';
                $q=$this->getDb()->prepare("REPLACE INTO ". $this->tableappointments ."(id, dateHour, idPatients) VALUES (:id, :dateHour, :idPatients)");
                $q->bindValue(':id', $id, \PDO::PARAM_INT);
                $q->bindValue(':dateHour', $_POST['dateHour'], \PDO::PARAM_STR);
                $q->bindValue(':idPatients', $_POST['idPatients'], \PDO::PARAM_INT);
                $q->execute();
            break;

            case 'rdvpatient' :
                $q=$this->getDb()->prepare("INSERT INTO ".$this->tablepatients." (lastname, firstname, birthdate, phone, mail) VALUES (:lastname, :firstname, :birthdate, :phone,:mail)");
                $q->bindValue(':lastname', mb_strtoupper($_POST['lastname']), \PDO::PARAM_STR);
                $q->bindValue(':firstname', mb_strtoupper($_POST['firstname']), \PDO::PARAM_STR);
                $q->bindValue(':birthdate', $_POST['birthdate'], \PDO::PARAM_STR);
                $q->bindValue(':phone', $_POST['phone'], \PDO::PARAM_STR);
                $q->bindValue(':mail', mb_strtoupper($_POST['mail']), \PDO::PARAM_STR);
                $q->execute();

                $idPatients=$this->getDb()->lastInsertId();

                $q2=$this->getDb()->prepare("INSERT INTO ".$this->tableappointments." (dateHour, idPatients) VALUES (:dateHour, :idPatients)");
                $q2->bindValue(':dateHour', $_POST['dateHour'], \PDO::PARAM_STR);
                $q2->bindValue(':idPatients', $idPatients, \PDO::PARAM_INT);
                $q2->execute();
                break;
        }   
    }
    
    //Méthode pour compter le nombre de patient pour la pagination
    public function countPatients()
    {
        $q = $this->getDb()->prepare("SELECT COUNT(*) AS nbPatients FROM ".$this->tablepatients);
        $q->execute();
        $r=$q->fetch();
        $r= $r['nbPatients'];
        return $r;
    }

    public function affichagePagination(int $premier, int $parPage)
    {
        $q=$this->getDb()->prepare("SELECT * FROM ".$this->tablepatients." ORDER BY lastname ASC LIMIT :premier, :parpage");
        $q->bindValue(':premier', $premier, \PDO::PARAM_INT);
        $q->bindValue(':parpage', $parPage, \PDO::PARAM_INT);
        $q->execute();
        $r=$q->fetchAll(\PDO::FETCH_ASSOC);
        return $r;
    }
}

?>