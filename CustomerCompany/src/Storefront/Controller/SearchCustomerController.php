<?php declare(strict_types=1);

namespace CustomerCompany\Storefront\Controller;

use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Storefront\Controller\StorefrontController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Shopware\Core\Framework\Context;
use CustomerCompany\Storefront\Page\SearchPageLoader;

/**
 * @Route(defaults={"_routeScope"={"storefront"}})
 */
class SearchCustomerController extends StorefrontController
{
    private SearchPageLoader $searchPageLoader;

    public function __construct(
        SearchPageLoader $searchPageLoader
    ) {
        $this->searchPageLoader = $searchPageLoader;
    }

    /**
     * @Route("/search/customer", name="frontend.search.customer", methods={"GET"}, defaults={"XmlHttpRequest"=true})
     */
    public function searchCustomer(Request $request, SalesChannelContext $context): Response
    {
        $page = $this->searchPageLoader->load($request, $context);
        
        return $this->renderStorefront('@CustomerCompany/storefront/page/search-customer.html.twig', [
            'page' => $page,
            'searchQuery' => $request->query->get('search')
        ]);
    }
}