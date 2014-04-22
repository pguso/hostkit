<?php

namespace Hostkit\AdminBundle\Controller\Cpanel;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Hostkit\AdminBundle\Form\Type\AccountType,
    Symfony\Component\HttpFoundation\Response,
    Symfony\Component\HttpFoundation\JsonResponse,
    Symfony\Component\HttpFoundation\Request;

/**
 * Class AccountsController
 * @package Hostkit\AdminBundle\Controller\Cpanel
 */
class AccountsController extends Controller
{

    private $accounts;
    private $server;

    /**
     * @return mixed
     */
    public function indexAction()
    {

        $title = array('name' => 'cPanel Connect', 'icon' => 'icon-chain');

        if ($this->get("hosting.management.service")->getErrors() != 201) {
            $this->accounts = $this->get("hosting.management.service")->listAccounts();
            $this->accounts = $this->accounts->acct;
        }

        $em = $this->getDoctrine()->getManager();

        $servers = $em->getRepository('HostkitCoreBundle:Server')->findAll();

        if (!empty($servers)) {
            $this->server = $servers[0]->getServerName();
        }

        return $this->render('HostkitAdminBundle:Cpanel:index-accounts.html.twig', array(
            'accounts' => $this->accounts,
            'servers' => $servers,
            'server' => $this->server,
            'connectionError' => $this->get("hosting.management.service")->getErrors(),
            'title' => $title
        ));
    }


    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function addAction(Request $request)
    {
        $title = array('name' => 'cPanel Connect', 'icon' => 'icon-chain');
        $packageList = '';
        $packages = array();
        $error = '';

        if ($this->get("hosting.management.service")->getErrors() != 201) {
            $packages = $this->get("hosting.management.service")->listPackages();
        }

        if (is_object($packages)) {
            foreach ($packages as $package) {
                $index = (string)$package->name;
                $packageList[$index] = (string)$package->name;
            }

            $form = $this->createForm(new AccountType(), null, array('attr' => $packageList));
        }  else {
            $error = 'You need to add at least one package first! <a href="/admin/packages/add">Add Package</a>';

            $form = $this->createForm(new AccountType());
        }

        


        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {

                $requestData = $request->request->all();
                $params = array(
                    'domain' => $requestData['account']['domain'],
                    'username' => $requestData['account']['username'],
                    'password' => $requestData['account']['password'],
                    'contactemail' => $requestData['account']['email'],
                    'plan' => $requestData['account']['package'],
                    'savepkg' => 0,
                    'language' => $requestData['account']['locale']
                );

                $response = $this->get("hosting.management.service")->getCpanelApi()->createacct($params);

                if ($response->result->status == 1) {
                    return $this->redirect($this->generateUrl('hostkit_xs_cpanel_accounts_overview'));
                } else {
                    $error = $response->result->statusmsg;
                }


            }
        }

        return $this->render('HostkitAdminBundle:Cpanel:add-accounts.html.twig', array(
            'form' => $form->createView(),
            'error' => $error,
            'title' => $title
        ));
    }

    /**
     * @param Request $request
     * @param         $username
     *
     * @return mixed
     */
    public function modifyAction(Request $request, $username)
    {
        $title = array('name' => 'cPanel Connect', 'icon' => 'icon-chain');

        $packageList = '';
        $packages = array();
        $error = '';

        if ($this->get("hosting.management.service")->getErrors() != 201) {
            $packages = $this->get("hosting.management.service")->listPackages();
        }

        if (is_object($packages)) {
            foreach ($packages as $package) {
                $index = (string)$package->name;
                $packageList[$index] = (string)$package->name;
            }
        }

        $accountInfo = $this->get("hosting.management.service")->getCpanelApi()->accountsummary($username);

        $form = $this->createForm(new AccountType(), null, array('attr' => $packageList));
        $form->get('domain')->setData((string)$accountInfo->acct->domain);
        $form->get('username')->setData($username);
        $form->get('password')->setData((string)$accountInfo->acct->password);
        $form->get('email')->setData((string)$accountInfo->acct->email);


        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {

                $requestData = $request->request->all();
                $params = array(
                    'user' => $username,
                    'domain' => $requestData['account']['domain'],
                    'newuser' => $requestData['account']['username'],
                    'password' => (!empty($requestData['account']['password']) ? $requestData['account']['password']['first'] : (string)$accountInfo->acct->password),
                    'contactemail' => $requestData['account']['email'],
                    'LOCALE' => $requestData['account']['locale']
                );

                $response = $this->get("hosting.management.service")->getCpanelApi()->modifyacct($params);

                if (!is_object($response)) {
                    $error = 'Could not send API call.';
                } else {
                    if ($response->result->status == 1) {
                        return $this->redirect($this->generateUrl('hostkit_xs_cpanel_accounts_overview'));
                    } else {
                        $error = $response->result->statusmsg;
                    }
                }


            }
        }

        return $this->render('HostkitAdminBundle:Cpanel:add-accounts.html.twig', array(
            'form' => $form->createView(),
            'error' => $error,
            'title' => $title,
            'modify' => 1
        ));
    }

    /**
     * @param $username
     *
     * @return mixed
     */
    public function detailAction($username)
    {
        $title = array('name' => 'cPanel Connect', 'icon' => 'icon-chain');
        $error = '';

        $account = $this->get("hosting.management.service")->getCpanelApi()->accountsummary($username);
        $bw = $this->get("hosting.management.service")->getCpanelApi()->showbw($username);

        if ((string)$account->status == 0) {
            $error = (string)$account->statusmsg;
        } else {
            $account = $account->acct;
        }

        $bw_used = $bw->bandwidth->acct->bwusage->usage;
        $bw_total = $bw->bandwidth->acct->limit;

        return $this->render('HostkitAdminBundle:Cpanel:detail-accounts.html.twig', array(
            'account' => $account,
            'bw_used' => $bw_used,
            'bw_total' => $bw_total,
            'title' => $title
        ));
    }

    /**
     * @param $username
     *
     * @return JsonResponse
     */
    public function suspendAction($username)
    {

        $title = 'Accounts';
        $error = '';

        $packageInfo = $this->get("hosting.management.service")->getCpanelApi()->suspendacct($username);

        /*if((string)$packageInfo->result->status == 0) {
            $error = (string)$packageInfo->result->statusmsg;
        }*/

        return new JsonResponse($packageInfo);
    }

    /**
     * @param $username
     *
     * @return JsonResponse
     */
    public function unsuspendAction($username)
    {

        $title = 'Accounts';
        $error = '';

        $packageInfo = $this->get("hosting.management.service")->getCpanelApi()->unsuspendacct($username);

        /*if((string)$packageInfo->result->status == 0) {
            $error = (string)$packageInfo->result->statusmsg;
        }*/

        return new JsonResponse($packageInfo);
    }
}
