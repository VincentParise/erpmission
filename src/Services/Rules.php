<?php

namespace App\Services;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Rules extends AbstractController
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
    /*
    * Return Vrai si le(s) contact(s) est dans le même pays que la mission.
    */
    public function ruleContactsPays(string $countryMission,$contacts)
    {

        //On test si l'ensemble des contacts est du même pays que la mission
        if (!empty($contacts)) {
            foreach ($contacts as $element) {
                if ($countryMission !== $element->getPays()->getLibelle()) {
                    return false;
                }
            }
        }
        return true;
    }

    /*
   * Return Vrai si le pays de la mission = pays de la planque
   */
    public function rulePaysPlanque(string $paysmission,$planques)
    {
        // On recherche parmis ces éléments si le pays de la mission = pays de la planque
        foreach ($planques as $element) {
            if ($element->getPaysplanque()->getLibelle() !== $paysmission) {
                    return false;
            }
        }
        return true;
    }

  /*
  * On récupère les nationalité des cibles dans une chaine de caractères
  */
    public function ruleNatCibles($cibles) {

        $tabNatCibles=[];
        foreach ($cibles as $element) {
            $tabNatCibles[]=$element->getPayscible()->getLibelle();

        }
        return implode('-',$tabNatCibles);

    }

    /*
     *  On test si le pays de la mission fait bien parti des pays de la planque
     */
    public function rulePlanquesPays(string $paysMission, $planques){

        $tabLibellePlanques=[];
        foreach($planques as $planque){
            $tabLibellePlanques[]=$planque->getPaysPlanque()->getLibelle();
        }
        // On test si le pays de la mission fait bien parti des pays de la planque
        if (!empty($tabLibellePlanques)){
            foreach($tabLibellePlanques as $element){
                if ($element !== $paysMission) {
                    // Message Flash
                    $this->addFlash('alert','Le pays de mission doit être le même que celui du pays de ou des planques en '.$element);
                    return false;
                }
            }
        }
        return true;
    }

    /*
    * On test si la specialite de la mission fait bien parti au moins des specialités de(s) agent(s)
    */
    public function ruleSpecialiteMissionAgents($specialitemission,$agents){

        // On recherche parmis les cibles si au moins 1 à la specialité de la mission
        foreach ($agents as $element) {
            foreach($element->getSpecialites() as $index){
                if ($index->getLibelle() === $specialitemission) {
                    return true;
                }
            }
        }
        return false;

    }

    /*
     * Retourne le tableau des libelles des spécialités
     */
    public function ruleSpecialitesAgents($specialites) {
        $tabSpecialites=[];

        foreach($specialites as $element){
            $tabSpecialites[]=$element->getLibelle();
        }

        return $tabSpecialites;
    }

    /*
     * Verification si présence agents, contacts et cibles
     */
    public function verifAgentsContactsCibles($agents,$contacts,$cibles,$statutMission){

        if (empty($statutMission)){
            $statutMission='';
        }
        $tabAgents=[];
        $tabContacts=[];
        $tabCibles=[];

        // Tableau des Id des agents
        foreach ($agents as $agent){
            $tabAgents[]=$agent->getId();
        }
        // Tableau des Id des contacts
        foreach ($contacts as $contact){
            $tabContacts[]=$contact->getId();
        }
        // Tableau des Id des cibles
        foreach ($cibles as $cible){
            $tabCibles[]=$cible->getId();
        }

        // Test si présence Agents contacts et cibles
        if(empty($tabAgents)) {
            $this->addFlash('alert','Pour passer votre mission a '.$statutMission.', veuillez sélectionner au moins 1 agent');
            return false;
        }
        if(empty($tabContacts)) {
            $this->addFlash('alert','Pour passer votre mission a '.$statutMission.', veuillez sélectionner au moins 1 contact');
            return false;
        }
        if(empty($tabCibles)) {
            $this->addFlash('alert','Pour passer votre mission a '.$statutMission.', veuillez sélectionner au moins 1 cible');
            return false;
        }

        return true;

    }


}