<?php

namespace App\Controller;

use App\Entity\Country;
use App\Entity\FilterReportForm;
use App\Entity\SendLogAggregated;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

class ReportController extends AbstractController
{
    /**
     * @Route("/report", name="")
     * @return Response
     */
    public function actionIndex(RouterInterface $router, Request $request)
    {
        $reportForm = new FilterReportForm();
        $reportForm->setDateFrom(new \DateTime('-5 days'));
        $reportForm->setDateTo(new \DateTime('today'));

        $dataReport = [];

        $form = $this->createFormBuilder($reportForm)
            ->add('dateFrom', DateType::class)
            ->add('dateTo', DateType::class)
            ->add('userName', TextType::class, [
                'attr' => [
                    'class' => 'js-user-autocomplete',
                    'data-autocomplete-url' => $router->generate('get_user_api')
                ],
                'required' => false
            ])
            ->add('countryName', TextType::class , [
                'attr' => [
                    'class' => 'js-country-autocomplete',
                    'data-autocomplete-url' => $router->generate('get_country_api')
                ],
                'required' => false
            ])
            ->add('countryId', HiddenType::class, [
                'attr' => [
                    'id' => '#hidden_country_id'
                ]
            ])
            ->add('userId', HiddenType::class, [
                'attr' => [
                    'id' => '#hidden_user_id'
                ]
            ])
            ->add('apply', SubmitType::class, ['label' => 'Apply filter'])
            ->getForm();



        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $filterForm = $form->getData();

            $dataReport = $this->getDoctrine()
                ->getRepository(SendLogAggregated::class)
                ->getAggregate($filterForm);

        }

        return $this->render('report/index.html.twig', ['form' => $form->createView(), 'dataReport' => $dataReport]);
    }

    /**
     * @Route("/user", name="get_user_api")
     * @param Request $request
     * @return mixed
     */
    public function getUserApiAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $data = $repository->findUserByQuery($request->get('term'));

        return $this->json($data);
    }

    /**
     * This endpoint for country autocomplete
     *
     * @Route("/country", name="get_country_api", methods="GET")
     * @param Request $request
     * @return mixed
     */
    public function getCountryApiAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Country::class);
        $data = $repository->findCountryByQuery($request->get('term'));

        return $this->json($data);
    }
}
