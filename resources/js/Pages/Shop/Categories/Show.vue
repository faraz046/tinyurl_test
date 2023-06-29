<template>
    <Head :title="`Category ${category.name}`" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Category - {{ category.name }} - Products</h2>
        </template>

        <div v-if="$page.props.flash.message" class="alert alert-success text-center">
            {{ $page.props.flash.message }}
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <!-- show products -->
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="font-semibold text-xl text-gray-800 leading-tight">Category - {{ category.name }} - Products</h3>
                        <!-- sort by -->
                        <product-sort :sort="sort" routeName="shop.category.show" :routeId="category.id"></product-sort>

                        <div class="flex flex-wrap">
                            <template v-for="product in productsList" :key="product.id">
                                <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/5 p-2">
                                    <div class="bg-white rounded-lg shadow-lg">
                                        <a :href="route('shop.product.show',product.id)">
                                            <div class="bg-cover bg-center h-56 p-4 " :style="{ backgroundImage: 'url(https://dummyimage.com/100x75/4a5568/ffffff&text=Product+Image)' }"></div>
                                            <div class="p-4 min-h-max">
                                                <p class="font-bold capitalize text-xl mb-2 min-h-max">{{ product.name }}</p>
                                                <p class="font-semibold text-lg mb-2">${{ product.price }}</p>
                                                <p class="text-gray-700 text-base">{{ this.excerptify(product.description) }}</p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
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

        
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Paginator from '@/Pages/Shop/Partials/Paginator.vue';
import ProductSort from '@/Pages/Shop/Partials/ProductSort.vue';

export default {
    name: 'CategoryProducts',
    props: {
        products: Object,
        category: Object,
        sort: String,
    },
    components: {
        AuthenticatedLayout,
        Head,
        Paginator,
        ProductSort,
    },
    data() {
        return {
            productsList: this.products.data,
            sortBy: this.sort || 'latest',
        }
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