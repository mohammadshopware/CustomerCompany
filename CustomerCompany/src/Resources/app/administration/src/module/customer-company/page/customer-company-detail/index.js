import template from './customer-company-detail.html.twig';

const { Component, Mixin } = Shopware;
const { Criteria } = Shopware.Data;

Shopware.Component.register('customer-company-detail', {
    template,

    inject: ['repositoryFactory'],

    mixins: [
      Mixin.getByName("notification"),
      Mixin.getByName('salutation'),
      Mixin.getByName('listing')
    ],

    data() {
        return {
            customerCompany: {
                companyId: '', // Initialize companyId
                companyName: '', // Initialize companyName
                creditLimit: 0, // Initialize creditLimit
            },
            isLoading: false,
        };
    },

    created() {
        this.getCustomerCompany();
    },
    computed: {
        customerCompanyRepo() {
            return this.repositoryFactory.create('customer_company');
        }
    },
    methods: {
        getCustomerCompany() {
            this.isLoading = true;
            this.customerCompanyRepo.get(this.$route.params.id, Shopware.Context.api).then((result) => {
                this.customerCompany = result;
                this.isLoading = false;
            });
        },

        onSave() {
            this.isLoading = true;

            this.customerCompanyRepo.save(this.customerCompany, Shopware.Context.api).then(() => {
                this.isLoading = false;
                this.$router.push({ name: 'customer.company.list' });
            }).catch((exception) => {
                this.createNotificationError({
                    title: this.$tc('global.default.error'),
                    message: this.$tc('Error')
                });
                this.isLoading = false;
                throw exception;  
            });
        }
    },
});