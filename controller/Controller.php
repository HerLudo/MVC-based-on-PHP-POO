<?php

namespace Controller;

class Controller
{
    private $dbEntityRepo; 
    //constructeur pour initier la création de l'objet dbEntityRepo issu de la classe EntityRepository du namespace Model.
    public function __construct()
    {
        
        $this->dbEntityRepo=new \Model\EntityRepository;
    }

    //Méthode de génération des templates.
    public function render($layout,$template,$parameters=[])
    {
        extract($parameters);

        ob_start();
        require "view/$template";

        $content=ob_get_clean();

        ob_start();
        require "view/$layout";

        return ob_end_flush();//termine la mise en mémoire et libère tout l'affichage sur le navigateur.
    }

    //Méthode pour appeler le template de page d'accueil
    public function accueil()
    {
        $this->render('layout.php','accueil.php',[
            'title'=>'Bienvenue, que souhaitez vous faire ?', 
        ]);
    }

    //Méthode qui permet le traitement des recherches dans l'affichage de la liste des patients
    public function recherche()
    {
        $nomRecherche = isset($_GET['recherche']) ? $_GET['recherche']: NULL ;
        $this->redirect('index.php?op=voir&data=patient&recherche='.strtoupper($nomRecherche));
    }

    //Méthode permettant d'afficher l'ensemble des patients ou rdv. Elle contient également la recherche de patient
    public function selectAll()
    {
        if (isset($_GET['data']) && !empty($_GET['data']))
        {
            $data=$_GET['data'];  

            switch ($data)
            {
                case 'patient':

                    if(!isset($_GET['recherche']) || empty($_GET['recherche']))
                    {
                        //traitement de la pagination (ici 8 patients par page)
                        if(isset($_GET['page']) && !empty($_GET['page'])){
                            $currentPage = ($_GET['page']);
                        }else{
                            $currentPage = 1;
                        }
                        $nbPatient=$this->dbEntityRepo->countPatients();
                        $parPage=8;
                        $pages= ceil($nbPatient/$parPage);
                        $premier = ($currentPage * $parPage) - $parPage;
                        $patients=$this->dbEntityRepo->affichagePagination($premier, $parPage);

                        $this->render('layout.php','template-selectAll.php',[
                            'title'=>'Liste des '.$data.'s',
                            'dataType'=>$data,
                            'data'=>(isset($patients)) ? $patients :$this->dbEntityRepo->selectAllRepo($data),
                            'hidden'=>NULL, 
                            'currentPage'=>$currentPage,
                            'pages'=>$pages,
                            'masque'=>NULL
                        ]);
                    }
                    //Si l'utilisateur a saisi une recherche
                    elseif (isset($_GET['recherche']) && !empty($_GET['recherche']))
                    {

                        $this->render('layout.php','template-selectAll.php',[
                            'title'=>'Liste des '.$data.'s',
                            'dataType'=>$data,
                            'data'=>$this->dbEntityRepo->findPatient($_GET['recherche']),
                            'hidden'=>NULL,
                            'masque'=>'hidden'                                                  
                        ]);
                    }
                    break;

                case 'rdv':
                    $this->render('layout.php','template-selectAll.php',[
                        'title'=>'Liste des '.$data.'s',
                        'dataType'=>$data,
                        'data'=>$this->dbEntityRepo->selectAllRepo($data),
                        'hidden'=>'hidden',
                        'masque'=>'hidden' 
                    ]);
                    break;

                case 'rdvpatient':
                    $this->redirect('index.php?op=voir&data=patient&page=1');
                    break;
            }   
        }
        
    }

    //Méthode permettant d'afficher le détail d'un patient ou d'un rdv
    public function select()
    {  
        $id=isset($_GET['id']) ? $_GET['id'] : NULL;
        $data=isset($_GET['data']) ? $_GET['data'] : NULL;

        $dataPatient=($data=="patient") ? $dataPatient=$this->dbEntityRepo->selectRepo($id,$data) : NULL ;
        $dataPatient=(empty($dataPatient))? $this->dbEntityRepo->selectRepo($id,$data,false) : $dataPatient; 
        
        $dataRdv=($data=="rdv") ? $dataRdv=$this->dbEntityRepo->selectRepo($id,$data) : NULL ;
        
        if($_GET['data']=='rdv')
        {
            $recupPatient=$this->dbEntityRepo->selectRepo($id, $_GET['data']);
            $nomPatient=ucfirst(strtolower($recupPatient[0]['firstname']));
            $nomPatient.=' '.$recupPatient[0]['lastname'];
            $title='Rendez-vous de '.$nomPatient;
        }
        elseif($_GET['data']=='patient')
        {
            $recupPatient=$this->dbEntityRepo->selectRepo($id, $_GET['data'], false);
            $nomPatient=ucfirst(strtolower($recupPatient[0]['firstname']));
            $nomPatient.=' '.$recupPatient[0]['lastname'];
            $title='Détails de '.$nomPatient;
        }
        
       $this->render('layout.php', 'template-select.php',[
           'title' => $title,
           'dataType'=>$data,
           'dataPatient'=>$dataPatient,
           'dataRdv'=>$dataRdv,
           'hidden'=>'hidden'
       ]);
    }

    //Méthode permettant de supprimer un enregistrement
    public function delete()
    {
        $id= isset($_GET['id']) ? $_GET['id'] : NULL;
        $data=isset($_GET['data']) ? $_GET['data'] : NULL;
        $this->dbEntityRepo->deleteRepo($id, $data);
        $this->redirect("index.php?op=voir&data=$data");
    }

    //Méthode pour enregistrer/modifier un enregistrement de patients/rdv.
    public function save()
    { 
        $id=isset($_GET['id']) ? $_GET['id'] : NULL;

        if(isset($_GET['op']))
        {
            if($_GET['op']=='update')
            {
                if($_GET['data']=='rdv')
                {
                    $recupPatient=$this->dbEntityRepo->selectRepo($id, $_GET['data']);
                    $nomPatient=ucfirst(strtolower($recupPatient[0]['firstname']));
                    $nomPatient.=' '.$recupPatient[0]['lastname'];
                    $title='Modifier le rendez-vous de '.$nomPatient;
                }
                elseif($_GET['data']=='patient')
                {
                    $recupPatient=$this->dbEntityRepo->selectRepo($id, $_GET['data'], false);
                    $nomPatient=ucfirst(strtolower($recupPatient[0]['firstname']));
                    $nomPatient.=' '.$recupPatient[0]['lastname'];
                    $title='Modifier le patient '.$nomPatient;
                }
            }

            elseif($_GET['op']=='ajouter')        
            {
                if($_GET['data']=='patient')
                {
                $title='Ajouter un patient';
                }
                elseif($_GET['data']=='rdv')
                {
                    $title='Ajouter un rendez-vous';
                }
                elseif($_GET['data']=='rdvpatient')
                {
                    $title='Ajouter un patient et un rendez-vous';
                }               
            }
        }

        $values=($_GET['op'] =='update') ? $this->dbEntityRepo->selectRepo($id, $_GET['data'], false) : '';
        $selecteur=($_GET['data']=='rdv') ? $this->dbEntityRepo->selectAllRepo('patient') : '';

        $fields= $this->dbEntityRepo->getFieldsRepo($_GET['data']);

        if($_POST)
        {
            $this->dbEntityRepo->saveRepo($_GET['data']);

            if($_GET['data']=='rdvpatient')
            {
            $this->redirect('index.php?op=voir&data=patient');
            }

            $this->redirect('index.php?op=voir&data='.$_GET['data']);   
        }
        
        $this->render('layout.php','template-form.php', [
            'title'=> $title,
            'dataType'=>$_GET['data'],
            'fields'=>$fields,
            'values'=>$values, 
            'op'=>$_GET['op'],
            'selecteur'=>$selecteur
        ]);
    }
    
    //Méthode pour rediriger sur l'URL transmise en argument
    public function redirect($url)
    {
        header("location: $url");
    }

    //Méthode d'accueil pour renvoyer vers la bonne méthode d'action et le bon template en fonction du choix de l'internaute.
    public function handleRequest()
    {
        if(isset($_GET['recherche']) && !isset($_GET['op']))
            $this->recherche();
        
        $op=isset($_GET['op']) ? $_GET['op'] : NULL;
        switch ($op)
        {
            case 'voir':
                $this->selectAll();
                break;

            case 'ajouter':
                $this->save();               
                break;
            
            case 'update':
                $this->save();                
                break;

            case 'select':
                $this->select();
                break;

            case 'delete' :
                $this->delete();
                break;

            default :
            $this->accueil();
        }
    }
}