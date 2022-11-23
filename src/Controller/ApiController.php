<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Orders;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * Class to render API Responses
 * @method orders() : route to functions as per request methods
 */
class ApiController extends AbstractController
{
  /**
  * @var
  */
  protected $entityManager;
  /**
  * @var
  */
  protected $orders;
  /**
  * @param  \Doctrine\Persistence\ManagerRegistry $doctrine
  */
  function __construct(ManagerRegistry $doctrine)
  {
    $entityManager = $doctrine->getManager();
    $this->entityManager = $entityManager;
    $this->orders = $doctrine->getRepository(Orders::class);
  }
  /**
  * @param  \Symfony\Component\HttpFoundation\Request $request
  * @return \Symfony\Component\HttpFoundation\Response
  */
  public function orders(Request $request){
    if($request->isMethod('POST')){
      $parameters = json_decode($request->getContent(), true);
      $response = $this->save_orders($parameters);
      return $response;
    }
    if($request->isMethod('GET')){
      $order_id = $request->query->get('order_id');
      $response = $this->get_orders($order_id);
      return $response;
    }
    if($request->isMethod('PATCH')){
      $parameters = json_decode($request->getContent(), true);
      $response = $this->update_orders($parameters);
      return $response;
    }
  }
  /**
  * @param  array
  * @return \Symfony\Component\HttpFoundation\Response
  */
  private function save_orders($parameters){
        $order = new Orders();
        $order->setDeliveryAddress($parameters['delivery_address']);
        $order->setBillingAddress($parameters['billing_address']);
        $order->setExpectedDelivery(new \DateTime($parameters['expected_delivery']));
        $order->setCustomerId($parameters['customer_id']);
        $order->setOrderItems(json_encode($parameters['order_items']));
        $order->setIsDelayed(0);
        $order->setStatus($parameters['status']);

        $this->entityManager->persist($order);
        $this->entityManager->flush();

        return new Response('{"status":"success","order_id":"'.$order->getId().'"}');
  }
  /**
  * @param  array
  * @return \Symfony\Component\HttpFoundation\Response
  */
  private function get_orders($order_id){
        $order = $this->orders->find($order_id);
        if (!$order) {
              return new Response('No order found for id: '.$order_id);
       }
       else{
         $response['id'] = $order->getId();
         $response['delivery_address'] = $order->getDeliveryAddress();
         $response['billing_address'] = $order->getBillingAddress();
         $response['expected_delivery'] = $order->getExpectedDelivery();
         $response['customer_id'] = $order->getCustomerId();
         $response['order_items'] = $order->getOrderItems();
         $response['is_delayed'] = $order->getIsDelayed();
         $response['status'] = $order->getStatus();
         $response = json_encode($response);
       }
       return new Response($response);

  }
  /**
  * @param  array
  * @return \Symfony\Component\HttpFoundation\Response
  */
  private function update_orders($parameters){
    if(isset($parameters['order_id'])){
    $order = $this->orders->find($parameters['order_id']);
      if (!$order) {
            return new Response('No order found for id: '.$parameters['order_id']);
      }else{
          $order->setDeliveryAddress($parameters['delivery_address']);
          $order->setBillingAddress($parameters['billing_address']);
          $order->setExpectedDelivery(new \DateTime($parameters['expected_delivery']));
          $order->setCustomerId($parameters['customer_id']);
          $order->setOrderItems(json_encode($parameters['order_items']));
          $order->setIsDelayed(0);
          $order->setStatus($parameters['status']);

          $this->entityManager->persist($order);
          $this->entityManager->flush();

          return new Response('{"status":"success","order_id":"'.$order->getId().'"}');
        }
    }else{
      return new Response('No Order id to update');
    }

  }
}
 ?>
