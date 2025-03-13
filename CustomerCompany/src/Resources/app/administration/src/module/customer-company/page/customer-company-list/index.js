import template from './customer-company-list.html.twig';

const {Criteria} = Shopware.Data;
const { Mixin } = Shopware;

Shopware.Component.register('customer-company-list', {
    template,
    inject: ['repositoryFactory','acl'],
    mixins: [
        Mixin.getByName('listing'),
    ],
    data() {
        return {
            customerCompanies: null,
            isLoading: false,
        };
    },
    computed: {
        customerCompanyRepo() {
            return this.repositoryFactory.create('customer_company');
        },
        columns() {
            return this.getColumns();
        },
    },

    created() {
        this.getCustomerCompanies();
    },

    methods: {
        getCustomerCompanies() {
            this.isLoading = true;

            this.customerCompanyRepo.search(new Criteria(), Shopware.Context.api).then((result) => {
                this.customerCompanies = result;
                this.isLoading = false;
            });
        },

        onAddCustomerCompany() {
            this.$router.push({ name: 'customer.company.create' });
        },

        onEditCustomerCompany(id) {
            this.$router.push({ name: 'customer.company.detail', params: { id } });
        },

        onDeleteCustomerCompany(id) {
            this.customerCompanyRepo.delete(id, Shopware.Context.api).then(() => {
                this.getCustomerCompanies();
            });
        },
        getColumns() {
            const columns = [{
                    property: 'companyId',
                    label: 'customerCompany.list.companyId',
                    width: '250px',
                    useCustomSort: true,
                    allowResize: true,
                }, {
                    property: 'companyName',
                    label: 'customerCompany.list.companyName',
                    useCustomSort: true,
                    allowResize: true,
                }, {
                    property: 'creditLimit',
                    label: 'customerCompany.list.creditLimit',
                    useCustomSort: true,
                    allowResize: true,
                }
            ];
            return columns;
        },
    },
});