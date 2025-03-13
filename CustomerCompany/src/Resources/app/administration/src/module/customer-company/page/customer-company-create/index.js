const { Component } = Shopware;
import template from "../customer-company-detail/customer-company-detail.html.twig";

Component.extend("customer-company-create", "customer-company-detail", {
    template,
    methods: {
        getCustomerCompany() {
            this.customerCompany = this.customerCompanyRepo.create(Shopware.Context.api);
        },
        onClickSave() {
            this.isLoading = true;
            this.customerCompanyRepo.save(this.customerCompany, Shopware.Context.api).then(() => {
                this.createNotificationSuccess({
                    title: this.$tc('customerCompany.success.title'),
                    message: this.$tc('customerCompany.success.message')
                });
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
    }
});