<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Taille;
use App\Form\OrderType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    /**
     * @Route("/order", name="order")
     */
    public function validerCommande()
    {
        return $this->render('order/index.html.twig', [
            'controller_name' => 'OrderController',
        ]);
    }

    /**
     * @Route("editor/boutique/commande/ajouter/{id}", name="addOrder")
     */
    public function addOrder(Request $request, EntityManagerInterface $manager, Taille $tailleId)
    {
        $user = $this->getUser();
        $order = new Order();

        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $order->setUser($user);
            $order->setValidate(0);
            $order->setTailleProduit($tailleId);
            $manager->persist($order);
            $manager->flush();

            $this->addFlash("success", "La commande a bien été prise en compte !");
            return $this->redirectToRoute("homeCompte", [
            ]);
        }

        return $this->render("boutique/addColor.html.twig", [
            "formColor" => $form->createView()
        ]);
    }

    /**
     * @Route("profil/commande/supprimer/order/{id}", name="supprimerOrder")
     */
    public function deleteOrder(Order $order, Request $request, EntityManagerInterface $manager)
    {
        $tailleObject = $order->getTailleProduit();
        $quantityObject = $tailleObject->getQuantity();
        $total = $quantityObject + 1;
        $tailleObject->setQuantity($total);
        $manager->persist($tailleObject);
        $manager->remove($order);
        $manager->flush();

        $this->addFlash("success", "La commande a bien été supprimée !");
        return $this->redirectToRoute("homeCompte", [

        ]);
    }
}
