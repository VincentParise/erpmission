<?php


namespace App\Services;


use App\Repository\MissionsRepository;
use App\Repository\PaysRepository;
use App\Repository\SpecialitesRepository;
use App\Repository\StatutsmissionsRepository;

class Search
{

    private $paysRepository;
    private $specialitesRepository;
    private $statutsmissionsRepository;
    private $missionsRepository;

    /**
     * Search constructor.
     * @param $paysRepository
     * @param $specialitesRepository
     * @param $statutsmissionsRepository
     * @param $missionsRepository
     */
    public function __construct(PaysRepository $paysRepository,SpecialitesRepository $specialitesRepository,StatutsmissionsRepository $statutsmissionsRepository,MissionsRepository $missionsRepository)
    {
        $this->paysRepository = $paysRepository;
        $this->specialitesRepository = $specialitesRepository;
        $this->statutsmissionsRepository = $statutsmissionsRepository;
        $this->missionsRepository = $missionsRepository;
    }

    /*
     * Recuperation pays des missions sous form tableau
     */
    public function filterPaysMissions($missions){
        $paysMissions=[];
        foreach($missions as $element){
            if (!in_array($element->getPaysmission()->getLibelle(),$paysMissions)){
                $paysMissions[]=$element->getPaysmission()->getLibelle();
            }
        }
        return $paysMissions;
    }

    /*
    * Recuperation pays des Agents sous form tableau
    */
    public function filterPaysAgents($agents){
        $paysAgents=[];
        foreach($agents as $element){
            if (!in_array($element->getPays()->getLibelle(),$paysAgents)){
                $paysAgents[]=$element->getPays()->getLibelle();
            }
        }
        return $paysAgents;
    }
    /*
      * Recuperation pays des Contacts sous form tableau
      */
    public function filterPaysContacts($contacts){
        $paysContacts=[];
        foreach($contacts as $element){
            if (!in_array($element->getPays()->getLibelle(),$paysContacts)){
                $paysContacts[]=$element->getPays()->getLibelle();
            }
        }
        return $paysContacts;
    }

    /*
     * Recuperation spécialité des missions sous forme tableau
     */
    public function filterSpecialitesMissions($missions) {
        $specialiteMissions=[];
        foreach($missions as $element){
            if (!in_array($element->getSpecialitemission()->getLibelle(),$specialiteMissions)){
                $specialiteMissions[]=$element->getSpecialitemission()->getLibelle();
            }
        }
        return $specialiteMissions;
    }

    /*
   * Recuperation spécialités des agents sous forme tableau
   */
    public function filterSpecialitesAgents($agents) {
        $specialiteAgents=[];
        foreach($agents as $element){
            foreach($element->getSpecialites() as $specialite) {
                if (!in_array($specialite->getLibelle(), $specialiteAgents)) {
                    $specialiteAgents[] = $specialite->getLibelle();
                }
            }
        }
        return $specialiteAgents;
    }

    /*
     * Recuperation statut des missions sous forme tableau
     */
    public function filterStatutsMissions($missions){
        $statutMissions=[];
        foreach($missions as $element){
            if (!in_array($element->getStatutmission()->getLibelle(),$statutMissions)){
                $statutMissions[]=$element->getStatutmission()->getLibelle();
            }
        }
        return $statutMissions;
    }

    /*
     * Filtre pour AJAX liste des missions de l'agent
     */
    public function filterMissionsAgents($paysFilter,$specialiteFilter,$statutFilter,$tabMissions){

        // On cherche l'Id de la base de donnée
        $idPays=$this->paysRepository->findIdByLibelle($paysFilter);

        // On cherche l'Id de la base de donnée
        $idSpecialites=$this->specialitesRepository->findIdByLibelle($specialiteFilter);

        // On cherche l'Id de la base de donnée
        $idStatut=$this->statutsmissionsRepository->findIdByLibelle($statutFilter);


        // On recherche avec le repo en fonction des Id dans la base de donnée
        // - 1 -
        if (empty($idPays) && empty($idSpecialites) && empty($idStatut)){
            $missions=$tabMissions;
        }
        // - 2 -
        if (empty($idPays) && empty($idSpecialites) && !empty($idStatut)){
            $missions=[];
            foreach($tabMissions as $key=>$element){
                if($element->getStatutmission()->getId() === $idStatut->getId()){
                    $missions[$key]=$element;
                }
            }
        }
        // - 3 -
        if (!empty($idPays) && !empty($idSpecialites) && empty($idStatut)) {
            $missions=[];
            foreach($tabMissions as $key=>$element){
                if($element->getPaysmission()->getId() === $idPays->getId() && $element->getSpecialitemission()->getId() === $idSpecialites->getId()){
                    $missions[$key]=$element;
                }
            }
        }
        // - 4 -
        if (!empty($idPays) && !empty($idSpecialites) && !empty($idStatut)) {
            $missions=[];
            foreach($tabMissions as $key=>$element){
                if($element->getPaysmission()->getId() === $idPays->getId() && $element->getSpecialitemission()->getId() === $idSpecialites->getId() && $element->getStatutmission()->getId() === $idStatut->getId()){
                    $missions[$key]=$element;
                }
            }
        }
        // - 5 -
        if (!empty($idPays) && empty($idSpecialites) && empty($idStatut)) {
            $missions=[];
            foreach($tabMissions as $key=>$element){
                if($element->getPaysmission()->getId() === $idPays->getId()){
                    $missions[$key]=$element;
                }
            }
        }
        // - 6 -
        if (!empty($idPays) && empty($idSpecialites) && !empty($idStatut)) {
            $missions=[];
            foreach($tabMissions as $key=>$element){
                if($element->getPaysmission()->getId() === $idPays->getId() && $element->getStatutmission()->getId() === $idStatut->getId()){
                    $missions[$key]=$element;
                }
            }
        }
        // - 7 -
        if (empty($idPays) && !empty($idSpecialites) && empty($idStatut)) {
            $missions=[];
            foreach($tabMissions as $key=>$element){
                if($element->getSpecialitemission()->getId() === $idSpecialites->getId()){
                    $missions[$key]=$element;
                }
            }
        }
        // - 8 -
        if (empty($idPays) && !empty($idSpecialites) && !empty($idStatut)) {
            $missions=[];
            foreach($tabMissions as $key=>$element){
                if($element->getSpecialitemission()->getId() === $idSpecialites->getId() && $element->getStatutmission()->getId() === $idStatut->getId()){
                    $missions[$key]=$element;
                }
            }
        }
        return $missions;
    }

    /*
  * Filtre pour AJAX liste des agents
  */
    public function filterAgents($paysFilter,$specialiteFilter,$tabAgents){

        // On cherche l'Id de la base de donnée
        $idPays=$this->paysRepository->findIdByLibelle($paysFilter);
        // On cherche l'Id de la base de donnée
        $idSpecialites=$this->specialitesRepository->findIdByLibelle($specialiteFilter);

         // On recherche avec le repo en fonction des Id dans la base de donnée
        // - 1 -
        if (empty($idPays) && empty($idSpecialites)){
            $agents=$tabAgents;
        }
        // - 2 -
        if (!empty($idPays) && empty($idSpecialites)) {
            $agents=[];
            foreach($tabAgents as $key=>$element){
                if($element->getPays()->getId() === $idPays->getId()){
                    $agents[$key]=$element;
                }
            }
        }
        // - 3 -
        if (!empty($idPays) && !empty($idSpecialites)) {
            $agents=[];
            foreach($tabAgents as $key=>$element){
                if($element->getPays()->getId() === $idPays->getId()){
                    $agents[$key]=$element;
                }
            }
            foreach($agents as $key=>$element){
                foreach($element->getSpecialites() as $specialite) {
                    if ($specialite->getId() === $idSpecialites->getId()) {
                        $agents[$key] = $element;
                    }
                }
            }
        }
        // - 4 -
        if (empty($idPays) && !empty($idSpecialites)) {
            $agents = [];
            foreach ($tabAgents as $key => $element) {
                foreach ($element->getSpecialites() as $specialite) {
                    if ($specialite->getId() === $idSpecialites->getId()) {
                        $agents[$key] = $element;
                    }
                }
            }
        }
        return $agents;
    }

    /*
* Filtre pour AJAX liste des contacts
*/
    public function filterContacts($paysFilter,$tabContacts){

        // On cherche l'Id de la base de donnée
        $idPays=$this->paysRepository->findIdByLibelle($paysFilter);

        // On recherche avec le repo en fonction des Id dans la base de donnée
        // - 1 -
        if (empty($idPays)){
            $contacts=$tabContacts;
        }
        // - 2 -
        if (!empty($idPays)) {
            $contacts=[];
            foreach($tabContacts as $key=>$element){
                if($element->getPays()->getId() === $idPays->getId()){
                    $contacts[$key]=$element;
                }
            }
        }
        return $contacts;
    }


    /*
    * Filtre pour AJAX liste des missions du contact
    */
    public function filterMissionsContacts($paysFilter,$statutFilter,$tabMissions){

        // On cherche l'Id de la base de donnée
        $idPays=$this->paysRepository->findIdByLibelle($paysFilter);

        // On cherche l'Id de la base de donnée
        $idStatut=$this->statutsmissionsRepository->findIdByLibelle($statutFilter);

        // On recherche avec le repo en fonction des Id dans la base de donnée
        // - 1 -
        if (empty($idPays) && empty($idStatut)){
            $missions=$tabMissions;
        }
        // - 2 -
        if (empty($idPays) && !empty($idStatut)){
            $missions=[];
            foreach($tabMissions as $key=>$element){
                if($element->getStatutmission()->getId() === $idStatut->getId()){
                    $missions[$key]=$element;
                }
            }
        }
        // - 3 -
        if (!empty($idPays) && empty($idStatut)) {
            $missions=[];
            foreach($tabMissions as $key=>$element){
                if($element->getPaysmission()->getId() === $idPays->getId()){
                    $missions[$key]=$element;
                }
            }
        }
        // - 4 -
        if (!empty($idPays) && !empty($idStatut)) {
            $missions=[];
            foreach($tabMissions as $key=>$element){
                if($element->getPaysmission()->getId() === $idPays->getId()  && $element->getStatutmission()->getId() === $idStatut->getId()){
                    $missions[$key]=$element;
                }
            }
        }

        return $missions;
    }

    /*
     * Filtre pour AJAX liste des missions
     */
   //public function filterMissions($paysFilter,$specialiteFilter,$statutFilter,$missions){

   //   // On cherche l'Id de la base de donnée
   //   $idPays=$this->paysRepository->findIdByLibelle($paysFilter);

   //   // On cherche l'Id de la base de donnée
   //   $idSpecialites=$this->specialitesRepository->findIdByLibelle($specialiteFilter);

   //   // On cherche l'Id de la base de donnée
   //   $idStatut=$this->statutsmissionsRepository->findIdByLibelle($statutFilter);

   //   // On recherche avec le repo en fonction des Id dans la base de donnée
   //   if (empty($idPays) && empty($idSpecialites) && empty($idStatut)){
   //       $missions=$this->missionsRepository->findAll();
   //   }
   //   if (empty($idPays) && empty($idSpecialites) && !empty($idStatut)){
   //       $missions=$this->missionsRepository->findBy([
   //           'statutmission' => $idStatut,
   //       ]);
   //   }
   //   if (!empty($idPays) && !empty($idSpecialites) && empty($idStatut)) {
   //       $missions = $this->missionsRepository->findBy([
   //           'paysmission' => $idPays,
   //           'specialitemission' => $idSpecialites,
   //       ]);
   //   }
   //   if (!empty($idPays) && !empty($idSpecialites) && !empty($idStatut)) {
   //       $missions = $this->missionsRepository->findBy([
   //           'paysmission' => $idPays,
   //           'specialitemission' => $idSpecialites,
   //           'statutmission' => $idStatut,
   //       ]);
   //   }
   //   if (!empty($idPays) && empty($idSpecialites) && empty($idStatut)) {
   //       $missions = $this->missionsRepository->findBy([
   //           'paysmission' => $idPays,
   //       ]);
   //   }
   //   if (!empty($idPays) && empty($idSpecialites) && !empty($idStatut)) {
   //       $missions = $this->missionsRepository->findBy([
   //           'paysmission' => $idPays,
   //           'statutmission' => $idStatut,
   //       ]);
   //   }
   //   if (empty($idPays) && !empty($idSpecialites) && empty($idStatut)) {
   //       $missions = $this->missionsRepository->findBy([
   //           'specialitemission' => $idSpecialites,
   //       ]);
   //   }
   //   if (empty($idPays) && !empty($idSpecialites) && !empty($idStatut)) {
   //       $missions = $this->missionsRepository->findBy([
   //           'specialitemission' => $idSpecialites,
   //           'statutmission' => $idStatut,
   //       ]);
   //   }

   //   return $missions;
   //




}