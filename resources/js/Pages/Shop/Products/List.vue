<template>
    <Head title="Products" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Products</h2>
        </template>

        <div v-if="$page.props.flash.message" class="alert alert-success text-center">
            {{ $page.props.flash.message }}
        </div>

        <!-- top products with carousel -->
        <top-products :products="topProducts"></top-products>

        <!-- all products -->
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <!-- show products -->
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="font-semibold text-xl text-gray-800 leading-tight">All Products</h3>
                        <!-- sort by -->
                        <product-sort 
                            :sort="sort" 
                            routeName="shop.product.list"
                        ></product-sort>

                        <div class="flex flex-wrap">
                            <template v-for="product in productsList" :key="product.id">
                                <product-card :product="product"></product-card>
                            </template>
                        </div>

                        <!-- pagination -->
                        <paginator 
                            :to="products.to"
                            :total="products.total"
                            :from="products.from"
                            :prevPageUrl="prevPageUrl"
                            :nextPageUrl="nextPageUrl"
                        ></paginator>
                    </div>
                    
                </div>
            </div>
        </div>

        <!-- last viewed products -->
        <last-viewed-products v-if="lastViewedProducts" :products="lastViewedProducts"></last-viewed-products>

    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import Paginator from '@/Pages/Shop/Partials/Paginator.vue';
import ProductSort from '@/Pages/Shop/Partials/ProductSort.vue';
import TopProducts from '@/Pages/Shop/Products/Partials/TopProducts.vue';
import LastViewedProducts from '@/Pages/Shop/Products/Partials/LastViewedProducts.vue';
import ProductCard from '@/Pages/Shop/Products/Partials/ProductCard.vue';

export default {
    name: 'ProductList',
    props: {
        products: Object,
        topProducts: Array,
        lastViewedProducts: Array,
        sort: String,
    },
    components: {
        AuthenticatedLayout,
        Head,
        Link,
        Paginator,
        ProductSort,
        TopProducts,
        LastViewedProducts,
        ProductCard,
    },
    data() {
        return {
            productsList: this.products.data,
            sortBy: this.sort || 'latest',
        };
    },
    methods: {
        excerptify(text) {
            return text.slice(0, 70) + '...';
        },
    },
    computed: {
        nextPageUrl() {
            return this.products.next_page_url ? this.products.next_page_url + '&sort=' + this.sortBy : null;
        },
        prevPageUrl() {
            return this.products.prev_page_url ? this.products.prev_page_url + '&sort=' + this.sortBy : null;
        },
    },
}
</script>

<style>
    .alert {
        padding: 1rem;
        border-radius: 4px;
        font-weight: bold;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
    }
</style>