<?php


namespace App\DataPersister;

use App\Entity\Depot;
use App\Entity\Compte;
use App\Entity\Partenaire;
use App\Repository\ProfilRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Config\Definition\Exception\Exception;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CompteDataPersister implements ContextAwareDataPersisterInterface
{
    
    private $entityManager;
    public function __construct(ProfilRepository $repo, EntityManagerInterface $entityManager,TokenStorageInterface $tokenStorage, UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
        $this->repo = $repo;
    }
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Compte;
        // TODO: Implement supports() method.
    }
    public function persist($data, array $context = [])
    {
      /* 
        $usercreateur=$this->tokenStorage->getToken()->getUser();
        $partenaireRepo = $this->entityManager->getRepository(Partenaire::class);
        $request = new Request();
        $values = json_decode($request->getContent(),true); 
        $ninea = $values['partenaire']['ninea'];
        $Partenaire= $partenaireRepo->findOneBy($ninea);
     
       //On fait ce traitement si le partenaire n'existe pas
        if($Partenaire==null){
            
     foreach ($data->getPartenaire()->getUserComptePartenaire() as $userPartenaire) {
          $userPartenaire->setRoles($userPartenaire->getProfil()->getLibelle());
          $userPartenaire->setPassword($this->userPasswordEncoder->encodePassword($userPartenaire, $userPartenaire->getPassword()));
          $userPartenaire->getPartenaire()->addUserPartenaire($userPartenaire);
        }
         
    }else{
      $data->setPartenaire($Partenaire);
  }

        if($data->getDepots()->getMontant() >= 500000)
     {
    $nouveauSolde = $data->getDepots()->getMontant();
    //dd($nouveauSolde);
    $data->getDepots->setCaissierAdd($usercreateur);               
      $data->setSolde($nouveauSolde);
     }else{
        throw new Exception("le Montant de Depot doit être superieur a 500000");
    }    
    */     
    $userCreateur=$this->tokenStorage->getToken()->getUser();
    $iduser=$data->getPartenaire()->getId();
    $montant=($data->getDepots()[count($data->getDepots())-1]->getMontant());
    $date=date_format($data->getDateCreation(),"Yms");
    $num=rand(1000, 9999);
  
    if($iduser == null){
    $userPass=$data->getPartenaire()->getUserComptePartenaire()[0]->getPassword();
    //le user partenaire
    $user=$data->getPartenaire()->getUserComptePartenaire()[0];
    $user->setPassword($this->userPasswordEncoder->encodePassword($user, $userPass));
    $user->setProfil($this->repo->findByLibelle("ROLE_PARTENAIRE")[0]);
    
   }//dd($user);
   //dd($data->getDepots());
    if($data->getDepots()[0]->getMontant() >= 500000){
        
        $data->setSolde($montant);
        $data->setUserCreateur($userCreateur);
        $data->getPartenaire()->setUserCreateur($userCreateur);
        $data->getDepots()[0]->setCaissierAdd($userCreateur);
        $data->setNumeroCompte($date.$num);
    }else{
        throw new Exception("Le montant doit etre superieur ou égale à 500.000");
    }           
                $this->entityManager->persist($data);
                $this->entityManager->flush();
    }
   
    public function remove($data, array $context = [])
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}