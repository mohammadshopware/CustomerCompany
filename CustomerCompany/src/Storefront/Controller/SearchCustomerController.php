<?php declare(strict_types=1);

namespace CustomerCompany\Storefront\Controller;

use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Storefront\Controller\StorefrontController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\OrFilter;
use Shopware\Core\Framework\Context;

/**
 * @Route(defaults={"_routeScope"={"storefront"}})
 */
class SearchCustomerController extends StorefrontController
{
    public function __construct(EntityRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * @Route("/search/customer", name="frontend.search.customer", methods={"GET"}, defaults={"XmlHttpRequest"=true})
     */
    public function searchCustomer(Request $request, SalesChannelContext $context): Response
    {
        $searchQuery = $request->query->get('search');

        $responseData = [];

        if ($searchQuery) {

            $criteria = new Criteria();

            $criteria->addAssociation('company');
            $criteria->addFilter(
                new OrFilter([
                    new EqualsFilter('company.companyName', $searchQuery),
                    new EqualsFilter('company.companyId', $searchQuery),
                ])
            );

            $criteria->addFields([
                'firstName',
                'lastName',
                'email',
            ]);

            $customers = $this->customerRepository->search($criteria, Context::createDefaultContext())->getEntities();

            $responseData = [];
            foreach ($customers as $customer) {
                $responseData[] = [
                    'name' => $customer->get('firstName') . ' ' . $customer->get('lastName'),
                    'email' => $customer->get('email'),
                ];
            }
        }

        return $this->renderStorefront('@CustomerCompany/storefront/page/search_customer.html.twig', [
            'responseData' => $responseData,
            'searchQuery' => $searchQuery
        ]);
    }
}