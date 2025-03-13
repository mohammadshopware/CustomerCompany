import './page/customer-company-list';
import './page/customer-company-detail';
import './page/customer-company-create';
import deDE from './snippet/de-DE';
import enGB from './snippet/en-GB';

Shopware.Module.register('customer-company', {
    type: 'plugin',
    name: 'customer-company-module',
    title: 'customerCompany.general.mainMenuItemGeneral',
    description: 'customerCompany.general.descriptionTextModule',
    color: '#ff3d58',
    icon: 'regular-users',
    
    snippets: {
        'de-DE': deDE,
        'en-GB': enGB
    },

    routes: {
        list: {
            component: 'customer-company-list',
            path: 'list'
        },
        detail: {
            component: 'customer-company-detail',
            path: 'detail/:id',
            meta: {
                parentPath: 'customer.company.list'
            }
        },
        create: {
            component: 'customer-company-create',
            path: 'create',
            meta: {
                parentPath: 'customer.company.list'
            }
        }
    },

    navigation: [{
        id: 'customer-company',
        label: 'Customer Company',
        color: '#ff3d58',
        path: 'customer.company.list',
        position: 200,
        parent: 'sw-customer'
    }]
});