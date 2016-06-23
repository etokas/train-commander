<?php

namespace FrontBundle\Controller;

use FrontBundle\Entity\Commande;
use FrontBundle\Entity\User;
use FrontBundle\Entity\Voyage;
use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class FrontController
 * @package FrontBundle\Controller
 */
class FrontController extends Controller
{
    /**
     * @Route("/", name="front_homepage")
     */
    public function indexAction()
    {

        return $this->render('FrontBundle::layout.html.twig');
    }


    /**
     * @Route("/ajax/voyage/{id}", name="get_voyage_ajax", options={"expose"=true})
     */
    public function getVoyageAjax($id)
    {
        /** @var Session $session */
        $session = $this->get('session');

        $session->set('id_voyage', $id);

        return new JsonResponse($id);
    }


    /**
     * @Route("/voyage/{departure}/{arrival}/{timeDepart}/{timeArrival}", name="get_voyage", options={"expose"=true})
     */
    public function getVoyageAction($departure, $arrival, $timeDepart, $timeArrival)
    {
        /** @var \GuzzleHttp\Client $browser */
        $browser = $this->get('guzzle.client.api_crm');

        $response = $browser->get($this->url_encode("/" . $departure . "/" . $arrival . "/" . $timeDepart . "/" . $timeArrival));

        $response = (string)$response->getBody();

        $json = json_decode($response);

        return new JsonResponse($json);
    }

    private function url_encode($url)
    {
        $base = "/api/trajet";

        $encode = implode("/", array_map("rawurlencode", explode("/", $url)));

        return $base . $encode;
    }

    /**
     * @param $id
     * @Route("/voyage/one/{id}", name="get_one_voyage", options={"expose"=true})
     */
    public function getOneVoyage($id)
    {
        /** @var \GuzzleHttp\Client $browser */
        $browser = $this->get('guzzle.client.api_crm');

        $response = $browser->get($this->url_encode("/" . $id));

        $response = (string)$response->getBody();

        $json = json_decode($response);

        return new JsonResponse($json);

    }

    /**
     * @return JsonResponse
     * @Route("/get/user", name="front_getuser", options={"expose"=true})
     */
    public function getUserAction()
    {
        $user = $this->getUser();

        $response = array(
            'nom' => $user->getNom(),
            'prenom' => $user->getPrenom(),
            'email' => $user->getEmail()
        );

        return new JsonResponse($response);
    }


    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/checkout/{id}", name="front_checkout")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function checkoutAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $voy = $em->getRepository("FrontBundle:Voyage")->findOneBy(array('TrajetId' => $id));

        if ($voy) {
            return $this->render('FrontBundle:Front:checkout.html.twig', ['voyage' => $voy]);
        }

        /** @var \GuzzleHttp\Client $browser */
        $browser = $this->get('guzzle.client.api_crm');

        $response = $browser->get($this->url_encode("/" . $id));

        $response = (string)$response->getBody();

        $voyage = json_decode($response);


        $entity = new Voyage();

        foreach ($voyage[0] as $property => $value) {
            // create a setter
            $method = sprintf('set%s', ucwords($property)); // or you can cheat and omit ucwords() because PHP method calls are case insensitive
            // use the method as a variable variable to set your value
            $entity->$method($value);
        }

        $em->persist($entity);
        $em->flush();


        return $this->render('FrontBundle:Front:checkout.html.twig', ['voyage' => $entity]);
    }

    /**
     * @Route("/payment/success", name="success_payment")
     */
    public function successAction()
    {
        $em = $this->getDoctrine()->getManager();

        $session = $this->get('session');
        $id = $session->get('id_voyage');
        /** @var User $user */
        $user = $this->getUser();

        $voyage = $em->getRepository('FrontBundle:Voyage')->findOneBy(array('TrajetId' => (int)$id));

        $commande = new Commande();

        $commande->setVoyage($voyage);

        $commande->setUser($user);

        $user->addCommande($commande);


        $em->persist($user);
        $em->persist($commande);

        $em->flush();

        $message = \Swift_Message::newInstance()
            ->setSubject('Confirmation d\'achat')
            ->setFrom('leslie.monema@gmail.com', 'EasyTrain')
            ->setTo($user->getEmail(), sprintf('%s %s', $user->getNom(), $user->getPrenom()))
            ->setBody(
                $this->render(
                    'FrontBundle:Front:email.html.twig', array('user' => $user, 'voyage' => $voyage)),
                'text/html'
            );
        $this->get('mailer')->send($message);

        return $this->render('FrontBundle:Front:success.html.twig', ['commande' => $commande]);
    }


}
