/*browser:true*/
/*global define*/
define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (
        Component,
        rendererList
    ) {
        'use strict';
        rendererList.push(
            {
                type: 'bizum',
                component: 'Catgento_Bizum/js/view/payment/method-renderer/bizum'
            }
        );
        /** Add view logic here if needed */
        return Component.extend({});
    }
);