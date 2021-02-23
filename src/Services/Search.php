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
    public function filterMissionsAgents($paysFilter,$specialiteFilter,$statutFilter,$idAgent=null){

       // On cherche l'Id de la base de donnée
       $idPays=$this->paysRepository->findIdByLibelle($paysFilter);

       // On cherche l'Id de la base de donnée
       $idSpecialites=$this->specialitesRepository->findIdByLibelle($specialiteFilter);

       // On cherche l'Id de la base de donnée
       $idStatut=$this->statutsmissionsRepository->findIdByLibelle($statutFilter);

       // On recherche avec le repo en fonction des Id dans la base de donnée
       if (empty($idPays) && empty($idSpecialites) && empty($idStatut)){
           $missions=$this->missionsRepository->findAll();
       }
       if (empty($idPays) && empty($idSpecialites) && !empty($idStatut)){
           $missions=$this->missionsRepository->findBy([
               'statutmission' => $idStatut,

           ]);
       }
       if (!empty($idPays) && !empty($idSpecialites) && empty($idStatut)) {
           $missions = $this->missionsRepository->findBy([
               'paysmission' => $idPays,
               'specialitemission' => $idSpecialites,

           ]);
       }
       if (!empty($idPays) && !empty($idSpecialites) && !empty($idStatut)) {
           $missions = $this->missionsRepository->findBy([
               'paysmission' => $idPays,
               'specialitemission' => $idSpecialites,
               'statutmission' => $idStatut,

           ]);
       }
       if (!empty($idPays) && empty($idSpecialites) && empty($idStatut)) {
           $missions = $this->missionsRepository->findBy([
               'paysmission' => $idPays,

           ]);
       }
       if (!empty($idPays) && empty($idSpecialites) && !empty($idStatut)) {
           $missions = $this->missionsRepository->findBy([
               'paysmission' => $idPays,
               'statutmission' => $idStatut,

           ]);
       }
       if (empty($idPays) && !empty($idSpecialites) && empty($idStatut)) {
           $missions = $this->missionsRepository->findBy([
               'specialitemission' => $idSpecialites,

           ]);
       }
       if (empty($idPays) && !empty($idSpecialites) && !empty($idStatut)) {
           $missions = $this->missionsRepository->findBy([
               'specialitemission' => $idSpecialites,
               'statutmission' => $idStatut,

           ]);
       }

       return $missions;

   }
    */



}