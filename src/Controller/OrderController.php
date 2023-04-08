<?php

namespace App\Controller;
use App\Form\OrderType;
use App\Classe\Cart;
use App\Classe\Adress;
use App\Entity\OrderDetails;
use App\Classe\Carriers;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;



class OrderController extends AbstractController
{


    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/commande', name: 'order')] 

    public function index(Cart $cart, Request $request): Response
    {

        if (!$this->getUser()->getAdresses()->getValues())
        {
            return $this->redirectToRoute('account_adress_add');
        }


        $form =$this->createForm(OrderType::class, null, [ 
          
            'user'=>$this->getUser()
            ]);
            
           
        return $this->render('order/index.html.twig',[  
            'form'=>$form->createView(),
            'cart'=>$cart->getFull()
        ]);
    }

    #[Route('/commande/recapitulatif', name: 'order_recap')]

    public function add(Cart $cart, Request $request): Response
    {


        $form =$this->createForm(OrderType::class, null, [ 
          
            'user'=>$this->getUser()
        ]);
            
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid() ){
            $date = new \DateTimeImmutable();
            $carriers = $form->get('carriers')->getData(); 
            $delivery = $form->get('addresses')->getData(); 
            $delivery_content = $delivery->getFirstname().' '.$delivery->getLastname();
            $delivery_content .='<br/>'. $delivery->getPhone();

            if ($delivery->getCompany()){
            $delivery_content .= '<br/>'.$delivery->getCompany();
            }
            
            $delivery_content .= '<br/>'.$delivery->getAdress();
            $delivery_content .= '<br/>'.$delivery->getPostal().''.$delivery->getCity();
            $delivery_content .= '<br/>'.$delivery->getCountry();


               //enregistrer ma commande Order()
                $order = new Order();
                $order->setUser($this->getUser());
                $order->setCreatedAt($date);
                $order->setCarrierName($carriers->getName());
                $order->setCarrierPrice($carriers->getPrice());
                $order->setDelivery($delivery_content);

                //stocker nos données a l'aide de doctrine

                $this->entityManager->persist($order);

                 


                //Enregistrer mes produits OrderDetails()
               
                foreach($cart->getFull() as $product){

                $orderDetails = new OrderDetails();
                $orderDetails->setMyOrder($order);
                $orderDetails->setProduct($product['product']->getName()); 
                $orderDetails->setQuantity($product['quantity']);
                $orderDetails->setPrice($product['product']->getPrice()); 
                $orderDetails->setTotal($product['product']->getPrice() * $product['quantity']);
                $this->entityManager->persist($orderDetails);
        }
               
             // $this->entityManager->flush(); 
                return $this->render('order/add.html.twig',[  
                    'cart'=>$cart->getFull(),
                    'carrier'=> $carriers,
                    'delivery'=> $delivery_content

                ]);
             }

            return $this->redirectToRoute('cart');


       
    }
    
}