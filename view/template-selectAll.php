<?php
  //echo'<pre>';print_r($currentPage);echo'</pre>'
?>
<div class="container-fluid">
<!-- On vérifie que $data n'est pas vide pour pouvoir afficher les patients ou les RDV -->
  <?php if(!empty($data)):
    $nomColonne=array_keys($data[0]);?>

<!-- Formulaire de recherche, afficher uniquement pour les patients -->
    <div class="d-flex">
      <form action="" method="get" class="col-8 d-flex mx-auto" <?=$hidden?>>
        <input type="text" name="recherche" id="recherche" class="form-control" placeholder="Recherche un patient par nom,prénom,téléphone,email ou date de naissance" <?=$hidden?>>
        <button class="btn btn-primary ms-2" <?=$hidden?>>Rechercher</button>
      </form>
<!-- Bouton pour annuler la recherche et rebasculer vers l'affichage général -->
      <?php if(isset($_GET['recherche']) && !empty($_GET['recherche'])):?>
        <a href="index.php?op=voir&data=patient" class="col-3-sm"><button class="btn btn-danger ms-2">Annuler la recherche</button></a>
      <?php endif;?>
    </div>

    <!-- tableau contenant les données patients ou rdv -->
    <table class="table table-hover table-primary mx-auto">
      <thead>
        <tr>
          <?php foreach($nomColonne as $value):?>          
            <th class="text-center th" id="<?=$value?>"><?= strtoupper($value);?></th>
          <?php endforeach; ?>
        <th class="text-center">VIEW  UPDATE  DELETE</th>
        </tr>
      </thead>

      <tbody>
        <?php foreach($data as $tab):?>            
        <tr>
          <td class="text-center id"><?= implode('</td><td class="text-center">', $tab);?></td>
          <td class="text-center icons">
              <a href="?op=select&data=<?=$dataType?>&id=<?=$tab['id']?>" class="text-success tableicons mx-3-lg"><i class="bi bi-eye-fill"></i></a>
              <a href="?op=update&data=<?=$dataType?>&id=<?=$tab['id']?>" class="text-warning tableicons mx-4-lg"><i class="bi bi-pencil-square"></i></a>
              <a href="?op=delete&data=<?=$dataType?>&id=<?=$tab['id']?>" class="text-danger tableicons mx-3-lg" onclick="return(confirm('Voulez-vous réellement supprimer le <?=$dataType?> <?= $tab['id'];?>'))"><i class="bi bi-trash-fill"></i></a>
          </td>
        </tr>
        <?php endforeach;?>
      </tbody>
    </table>
    

    <!-- Pagination -->
    
    <nav aria-label="Page navigation example" <?=$masque?>>
      <ul class="pagination justify-content-end">
        <li class="page-item <?= ($currentPage == 1) ? "disabled" : "" ?>">
          <a class="page-link" href="index.php?op=voir&data=patient&page=<?= $currentPage - 1 ?>" ><</a>
        </li>
        <?php for($page = 1; $page <= $pages; $page++): ?>
        <li class="page-item" <?= ($currentPage == $page) ? "active" : "" ?>><a class="page-link" href="index.php?op=voir&data=patient&page=<?= $page ?>"><?= $page ?></a></li>
        <?php endfor;?>
        <li class="page-item <?= ($currentPage == $pages) ? "disabled" : "" ?>">
          <a class="page-link" href="index.php?op=voir&data=patient&page=<?= $currentPage + 1 ?>">></a>
        </li>
      </ul>
    </nav>

<!-- Bouton d'action pour ajouter un patient ou un RDV -->
      <div class="text-center">
        <a href="?op=ajouter&data=<?=$dataType?>" class="btn btn-primary my-5">Ajouter un <?=$dataType?></a>
      </div>

<!-- Si $data est vide, cela veut dire que la requete de recherche n'a retourné aucun résultat -->
  <?php else:?> 
      <h5 class="text-center mb-2">Désolé aucun enregistrement ne correspond à votre recherche.</h5>
      <div class="text-center my-5">
        <?php if(isset($_GET['recherche'])):?>
          <a href="index.php?op=voir&data=patient"><button class="btn btn-danger ms-2">Afficher les patients</button></a>
        <?php endif;?>
      </div>

  <?php endif;?>
</div>