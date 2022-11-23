<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Orders;
use App\Entity\DelayedOrders;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * Class to render API Response
 */
class DelayedController extends AbstractController
{
  protected $entityManager;
  protected $orders;
  /**
  * @param  \Doctrine\Persistence\ManagerRegistry $doctrine
  */
  function __construct(ManagerRegistry $doctrine)
  {
    $entityManager = $doctrine->getManager();
    $this->entityManager = $entityManager;
    $this->orders = $doctrine->getRepository(DelayedOrders::class);
  }
  /**
  * @return \Symfony\Component\HttpFoundation\Response
  */
  public function create_delayed_orders(){
    $delayed_orders = [];
    $results = $this->entityManager->createQuery('SELECT e FROM App:Orders e WHERE e.expected_delivery < CURRENT_DATE()')
       ->getResult();
    foreach($results as $result){
      $order = new DelayedOrders();
      $order_exist = $this->orders->findOneBy([
                                                  'order_id' => $result->getId()
                                              ]);
      if (!$order_exist) {
        $order->setOrderId($result->getId());
        $this->entityManager->persist($order);
        $this->entityManager->flush();
        $delayed_orders[]=$result->getId();
     }

    }
    if(count($delayed_orders) > 0){
      $delayed_orders = json_encode($delayed_orders);
      return new Response('DelayedOrders inserted with Ids.'.$delayed_orders);
    }else{
      return new Response('No delayed orders found !!');
    }
  }
  /**
  * @return \Symfony\Component\HttpFoundation\Response
  */
  public function get_delayed_orders(){
    $orders = $this->orders->findAll();
    $delayed_orders = [];
    if (!$orders) {
            return new Response('No delayed orders found !!');
     }else{
       foreach ($orders as $key => $value) {
         $delayed_orders[] = $value->getOrderId();
       }
     }
     $delayed_orders = json_encode($delayed_orders);
     return new Response($delayed_orders);
  }


}
 ?>
