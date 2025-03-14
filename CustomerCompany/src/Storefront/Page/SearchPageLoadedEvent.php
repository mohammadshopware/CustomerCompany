<?php declare(strict_types=1);

namespace CustomerCompany\Storefront\Page;

use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Storefront\Page\PageLoadedEvent;
use Symfony\Component\HttpFoundation\Request;

class SearchPageLoadedEvent extends PageLoadedEvent
{
    protected SearchPage $page;

    public function __construct(SearchPage $page, SalesChannelContext $salesChannelContext, Request $request)
    {
        $this->page = $page;
        parent::__construct($salesChannelContext, $request);
    }

    public function getPage(): SearchPage
    {
        return $this->page;
    }
}