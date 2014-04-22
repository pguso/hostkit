<?php

namespace Hostkit\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class DefaultController
 * @package Hostkit\AdminBundle\Controller
 */
class DefaultController extends Controller {

    public function indexAction() {
		$totalSales = 0;
		$unpaidInvoicesAmount = 0;
		$todaySales = 0;
		$thisMonthSales = 0;
		$date = new \Datetime('now');
        $dateTmp = new \Datetime('now');
        $lastMonths = array();

        $lastMonths[] = array('name' => $dateTmp->format('Y-m'), 'count' => 0);
        $lastMonths[] = array('name' => $dateTmp->modify('-1 month')->format('Y-m'), 'count' => 0);
        $lastMonths[] = array('name' => $dateTmp->modify('-1 month')->format('Y-m'), 'count' => 0);
        $lastMonths[] = array('name' => $dateTmp->modify('-1 month')->format('Y-m'), 'count' => 0);
        $lastMonths[] = array('name' => $dateTmp->modify('-1 month')->format('Y-m'), 'count' => 0);
        $lastMonths[] = array('name' => $dateTmp->modify('-1 month')->format('Y-m'), 'count' => 0);
		
		$month =  $date->format('F'); 
		$today = $date->format('Y-m-d'); 
		$thisMonth = $date->format('m');
	
		$orders = $this->getDoctrine()->getRepository('HostkitCoreBundle:Order')->findAll();
		$invoices = $this->getDoctrine()->getRepository('HostkitCoreBundle:Invoice')->findAll();
		$unpaidInvoices = $this->getDoctrine()->getRepository('HostkitCoreBundle:Invoice')->findBy(array('status' => 1));
        $orderItems = $this->getDoctrine()->getRepository('HostkitCoreBundle:OrderItem')->findAll();

        $openSupportTickets = $this->getDoctrine()->getRepository('HostkitCoreBundle:SupportTicket')->findBy(array('status' => 1));
        $openSupportTickets = count($openSupportTickets);

        $answeredSupportTickets = $this->getDoctrine()->getRepository('HostkitCoreBundle:SupportTicket')->findBy(array('status' => 2));
        $answeredSupportTickets = count($answeredSupportTickets);

        $closedSupportTickets = $this->getDoctrine()->getRepository('HostkitCoreBundle:SupportTicket')->findBy(array('status' => 3));
        $closedSupportTickets = count($closedSupportTickets);

        $activeClients = $this->getDoctrine()->getRepository('HostkitCoreBundle:Client')->findBy(array('status_id' => 2));
        $activeClients = count($activeClients);

        $inactiveClients = $this->getDoctrine()->getRepository('HostkitCoreBundle:Client')->findBy(array('status_id' => 1));
        $inactiveClients = count($inactiveClients);

        foreach($lastMonths as $key => $lastMonth) {
            foreach($orders as $order) {
                $orderDate = $order->getOrderDate();
                $orderDate = new \Datetime($orderDate);

                if($lastMonth['name'] == $orderDate->format('Y-m')) {

                    if(isset($lastMonths[$key]['count'])) {
                        $lastMonths[$key]['count'] = $lastMonths[$key]['count'] + 1;
                    } else {
                        $lastMonths[$key]['count'] = 1;
                    }

                }
            }
        }


		foreach($orders as $order) {
			$orderDateTmp = $order->getOrderDate();
			$orderDateTmp = new \Datetime($orderDateTmp);
			$orderDate = $orderDateTmp->format('Y-m-d');
			
			$orderMonth = $orderDateTmp->format('m');
			
			$totalSales = number_format(($totalSales + $order->getAmount()), 2);
		
			if($orderDate == $today) {
				$todaySales = number_format(($todaySales + $order->getAmount()), 2);
			}
			
			if($orderMonth == $thisMonth) {
				$thisMonthSales = number_format(($thisMonthSales + $order->getAmount()), 2);
			}
		}

        foreach($orderItems as $orderItem) {

        }
		
		foreach($unpaidInvoices as $unpaidInvoice) {
			$unpaidInvoicesAmount = number_format(($unpaidInvoicesAmount + $unpaidInvoice->getAmount()), 2);
		}

	
        return $this->render('HostkitAdminBundle:Default:dashboard.html.twig', array(
			'totalSales' => $totalSales,
			'todaySales' => $todaySales,
			'thisMonthSales' => $thisMonthSales,
			'thisMonth' => $month,
			'unpaidInvoicesAmount' => $unpaidInvoicesAmount,
            'closedSupportTickets' => $closedSupportTickets,
            'openSupportTickets' => $openSupportTickets,
            'answeredSupportTickets' => $answeredSupportTickets,
            'inactiveClients' => $inactiveClients,
            'activeClients' => $activeClients,
            'lastMonths' => $lastMonths
		));
    }
}
