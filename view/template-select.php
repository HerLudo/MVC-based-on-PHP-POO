<div class="row mx-auto">
    <div class="card col-4 mx-auto bg-primary text-white">
        <div class="card-body mx-auto">
            <h5 class="card-title text-center">Détails</h5><hr>
<!-- Affichage détails du patient -->
            <?php if($dataType=='patient'):?>          
                <?php foreach($dataPatient[0] as $key=>$value): 
                    if($key!='id' && $key!='dateHour'):?>
                        <p class="text-center"><?=ucfirst($key). " : ".ucfirst($value)?></p>
                    <?php endif;?>

                    <?php if($key=='dateHour'):
                        $hidden=($value)? '' : 'hidden' ;
                    endif;?>
                <?php endforeach;?>
<!-- Si le patient a des rdv on affiche une sous partie Rendez-vous avec la date et l'heure du rdv -->
                <h5 class="card-title text-center mt-5"<?=$hidden?>>Rendez-vous :</h5><hr <?=$hidden?>>

                <?php foreach($dataPatient as $dataTab):
                        foreach($dataTab as $key=>$value):?>
                        <?php if($key=='dateHour'):?>
                            <?php $date= new DateTime($value);?>
                            <p class="text-center">Date et heure de rendez-vous : <?= $date->format('d-m-Y à G:i'); ?></p>
                        <?php endif;
                    endforeach;    
                endforeach;?>

            <?php elseif($dataType=='rdv'):?>
                <?php foreach($dataRdv as $tabData):
                        foreach($tabData as $key=>$value):
                            if($key!='id'):?>
                        <p class="text-center"><?=ucfirst($key). " : ".ucfirst($value)?></p>
                            <?php endif;?>
                        <?php endforeach;?>
                <?php endforeach;?>
            <?php endif;?>
        </div>
    </div> 
</div>

<div class="text-center">
    <?php if($dataType=='patient'):?>
        <a href="?op=update&data=patient&id=<?=$dataPatient[0]['id']?>" class="btn btn-primary my-5">Modifier patient</a>
    <?php elseif ($dataType=='rdv'):?>
        <a href="?op=update&data=rdv&id=<?=$dataRdv[0]['id']?>" class="btn btn-primary my-5">Modifier rdv</a>
    <?php endif;?>
</div>