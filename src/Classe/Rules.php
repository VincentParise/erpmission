<?php

namespace App\Classe;

class Rules
{

    /*
     * Return Vrai si les 2 Tableaux sont différents : Test Nationalité entre Cibles et Agents
     */
    public function ruleCiblesAgentsNat($cibles, $agents) {
        //On récupère les libelles les nationalités des agents dans un tableau
        $tabMissionNat=[];
        foreach($agents as $key=>$element){
            $tabMissionNat[]=$agents[$key]->getPays()->getLibelle();
        }

        //On récupère les libellés des nationalités des cibles dans un tableau
        $tabCiblesNat=[];
        foreach($cibles as $key=>$element){
            $tabCiblesNat[]=$cibles[$key]->getPayscible()->getLibelle();
        }
        // Test différences
        foreach ($tabCiblesNat as $key=>$element){
            if(in_array($element,$tabMissionNat)){
                return false;
            }
        }
        return true;

    }

    /*
     * Return Vrai si les agents ont la même spécialité que la mission.
     */
    public function ruleAgentsSpecialites(string $specialite,$agents){

        // On récupère et test la ou les spécialités de l'agent :
        foreach($agents as $key=>$element){
            foreach($spe=$agents[$key]->getSpecialites() as $id=>$el){
                if($spe[$id]->getLibelle() === $specialite){
                    //Alors on rentre dans les règles métiers
                    return true;
                }
            }
        }
        return false;

    }



}