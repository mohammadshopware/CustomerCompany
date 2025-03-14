<?php declare(strict_types=1);

namespace CustomerCompany\Storefront\Page;

use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Storefront\Page\GenericPageLoaderInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\OrFilter;
use Shopware\Core\Framework\Context;

class SearchPageLoader
{
    private GenericPageLoaderInterface $genericPageLoader;

    private EventDispatcherInterface $eventDispatcher;

    private EntityRepository $customerRepository;

    public function __construct(
        GenericPageLoaderInterface $genericPageLoader, 
        EventDispatcherInterface $eventDispatcher,
        EntityRepository $customerRepository
    ) {
        $this->genericPageLoader = $genericPageLoader;
        $this->eventDispatcher = $eventDispatcher;
        $this->customerRepository = $customerRepository;
    }

    public function load(Request $request, SalesChannelContext $context): SearchPage
    {
        $page = $this->genericPageLoader->load($request, $context);
        $page = SearchPage::createFrom($page);

        $searchQuery = $request->query->get('search');
        if (empty($searchQuery)) {
            return $page;
        }

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
        
        $page->setCustomersResult($customers);

        $responseData = [];
        foreach ($customers as $customer) {
            $responseData[] = [
               'name' => $customer->get('firstName') . ' ' . $customer->get('lastName'),
               'email' => $customer->get('email'),
            ];
        }

        $page->setResponseData($responseData);

        $this->eventDispatcher->dispatch(
            new SearchPageLoadedEvent($page, $context, $request)
        );

        return $page;
    }
}