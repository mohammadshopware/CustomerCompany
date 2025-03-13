Shopware.Component.override('sw-customer-detail', {
    computed: {
        defaultCriteria() {
            const criteria = this.$super('defaultCriteria');
            criteria.addAssociation('company'); // Add association to fetch the company
            return criteria;
        },
    },

    methods: {
        createdComponent() {
            this.$super('createdComponent');

            // Ensure the company association is loaded
            if (this.customer && !this.customer.company) {
                this.customer.company = null;
            }
        },
    },
});