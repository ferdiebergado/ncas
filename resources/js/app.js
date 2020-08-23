const bulmaSteps = require("bulma-steps");

require("./bootstrap");

window.Vue = require("vue");

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context("./", true, /\.vue$/i);
files
    .keys()
    .map((key) =>
        Vue.component(key.split("/").pop().split(".")[0], files(key).default)
    );

// Vue.component('testitem-options', require('./components/TestItemOptions.vue').default);
// Vue.component('competency-datatable', require('./components/CompetencyDatatable.vue').default);
// Vue.component('modal', require('./components/Modal.vue').default);
// Vue.component('notification', require('./components/Notification.vue').default);
// Vue.component('pagination-bar', require('./components/PaginationBar.vue').default);
// Vue.component('filter-bar', require('./components/FilterBar.vue').default);
// Vue.component('echo-notification', require('./components/EchoNotification.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: "#app",
    data() {
        return {
            messages: [],
        };
    },
});

document.addEventListener("DOMContentLoaded", () => {
    // Get all "navbar-burger" elements
    const $navbarBurgers = Array.prototype.slice.call(
        document.querySelectorAll(".navbar-burger"),
        0
    );

    // Check if there are any navbar burgers
    if ($navbarBurgers.length > 0) {
        // Add a click event on each of them
        $navbarBurgers.forEach((el) => {
            el.addEventListener("click", () => {
                // Get the target from the "data-target" attribute
                const { target } = el.dataset;
                const $target = document.getElementById(target);

                // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
                el.classList.toggle("is-active");
                $target.classList.toggle("is-active");
            });
        });
    }
});

document.addEventListener("DOMContentLoaded", () => {
    (document.querySelectorAll(".notification .delete") || []).forEach(
        ($delete) => {
            $notification = $delete.parentNode;

            $delete.addEventListener("click", () => {
                $notification.parentNode.removeChild($notification);
            });
        }
    );
});

bulmaSteps.attach();
