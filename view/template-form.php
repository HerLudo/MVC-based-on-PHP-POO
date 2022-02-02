<div class="container">
    <form action="" method="post" class="col-6 mx-auto">
<!-- Génération du formulaire patient -->
    <?php if($dataType=='patient'):?>
        
        <?php foreach($fields as $tab):?>
                <div class="row d-flex flex-colum justify-content-center align-items-center my-3">
                        <?php if($tab['Field']!='id'):?>
                            <label for="<?=$tab['Field']?>" class="form-label"><?=ucfirst($tab['Field'])?></label>
                            <input type="<?=($tab['Field']=='birthdate') ? 'date' : 'text'?>" class="form-control" id="<?= $tab['Field']?>" placeholder="<?= $tab['Field']?>" name="<?= $tab['Field']?>" value="<?= ($op=='update') ? $values[0][$tab['Field']] : ''?>">
                        <?php endif;?>
                </div>
        <?php endforeach;?>
<!-- Génération du formulaire rdv -->
    <?php elseif ($dataType=='rdv'):?>
        
        <?php foreach($fields as $tab):?>

            <?php if($tab['Field']=='idPatients'):?>
                <div class="row d-flex flex-colum justify-content-center align-items-center my-5">
                    <select name="<?= $tab['Field']?>" id="<?= $tab['Field']?>" class="form-select">
                        <option selected>Sélectionner le Patient</option>
                        <?php foreach($selecteur as $tab=>$champ):?>    
                            <option value="<?=$champ['id']?>"><?= "$champ[firstname] $champ[lastname]"?></option>
                        <?php endforeach;?>
                    </select>   
                </div>
            
            <?php elseif($tab['Field']=='dateHour'):?>
            <div class="row d-flex flex-colum justify-content-center align-items-center">
                    <label for="<?=$tab['Field']?>" class="form-label">Entrer la date et l'heure du rendez-vous :</label>
                    <input type="datetime-local" class="form-control" id="<?=$tab['Field']?>" placeholder="<?=$tab['Field']?>" name="<?=$tab['Field']?>" value="<?=($op=='update') ? $values[0][$tab['Field']] : ''?>">
            </div>
            <?php endif;?>
        <?php endforeach;?>
<!-- Génération du formulaire patient et rdv -->
    <?php elseif ($dataType=='rdvpatient'):?>

        <?php foreach($fields as $value):?>
                <div class="row d-flex flex-colum justify-content-center align-items-center">
                        <?php if($value!='idPatients' && $value!='id'):?>
                            <div class="my-2">

                            <?php if($value=='dateHour'):?>
                                <label for="<?=$value?>" class="form-label">Entrer la date et l'heure du rendez-vous :</label>
                                <input type="datetime-local" class="form-control" id="<?=$value?>" placeholder="<?=$value?>" name="<?=$value?>"> 

                            <?php else:?>
                                <label for="<?=$value?>" class="form-label"><?=ucfirst($value)?></label>
                                <input type="<?=($value=='birthdate') ? 'date' : 'text'?>" class="form-control" id="<?= $value?>" placeholder="<?= $value?>" name="<?= $value?>" value="">
                            </div>    
                            <?php endif;?>
                        <?php endif;?>
                    
                </div>
        <?php endforeach;?>

    <?php endif;?>
        <div class="text-center">
            <button type="submit" class="btn btn-primary my-5">Enregistrer</button>
        </div>
    </form>
</div>


