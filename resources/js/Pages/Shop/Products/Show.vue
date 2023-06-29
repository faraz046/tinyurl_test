<template>
    <Head :title="product.name" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ product.name }}</h2>
        </template>

        <div v-if="$page.props.flash.message" class="alert alert-success text-center">
            {{ $page.props.flash.message }}
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                    <div class="p-6 bg-white border-b border-gray-200">
                        
                            <div class="container mx-auto p-8">
                                <div class="flex flex-col md:flex-row">
                                <div class="w-full md:w-1/2">
                                    <img
                                    class="object-cover w-full h-64 md:h-auto"
                                    src="https://dummyimage.com/300x200/4a5568/ffffff&text=Product+Image"
                                    alt="Product Image"
                                    />
                                </div>
                                <div class="w-full md:w-1/2 md:ml-8">
                                    <h2 class="text-2xl capitalize font-bold mb-4">{{ product.name }}</h2>
                                    <div class="flex mb-4">
                                    <span class="mr-2 font-medium">Categories:</span>
                                    <ul class="flex">
                                        <li
                                        class="bg-gray-200 text-gray-700 py-1 px-2 rounded mr-2 text-sm cursor-pointer"
                                        v-for="(category, index) in product.categories"
                                        :key="index"
                                        @click="navigateToCategory(category.id)"
                                        >
                                        {{ category.name }}
                                        </li>
                                    </ul>
                                    </div>
                                    <div class="mb-4">
                                    <span class="font-medium">Price:</span>
                                    <span class="ml-2">${{ product.price }}</span>
                                    </div>
                                    <p class="mb-4">{{ product.description }}</p>
                                    <div class="flex">
                                        <button @click="editProduct(product.id)" class="btn btn-edit mr-2">Edit</button>
                                        <button @click="deleteProduct(product.id)" class="btn btn-delete mr-2">Delete</button>
                                        <button @click="markTop(product.id)" class="btn btn-mark-top">Mark as Top Product</button>
                                    </div>
                                </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';


export default {
    name: 'ShowProduct',
    props: {
        product: Object,
    },
    components: {
        AuthenticatedLayout,
        Head,
    },
    data() {
        return {
            
        };
    },
    methods: {
        navigateToCategory(categoryId) {
            this.$inertia.visit(route('shop.category.show', categoryId));
        },
        editProduct(productId) {
            this.$inertia.visit(route('shop.product.edit', productId));
        },
        deleteProduct(productId) {
            if (confirm('Are you sure you want to delete this product?')) {
                this.$inertia.delete(route('shop.product.destroy', productId));
            }
        },
        markTop(productId) {
            if (confirm('Are you sure you want to mark this product as top product?')) {
                this.$inertia.get(route('shop.product.mark-as-top', productId));
            }
        },
    },
    computed: {
        categories() {
            return this.product.categories;
        },
    },
}
</script>

<style>
    .btn {
        padding: 0.5rem 1rem;
        border-radius: 4px;
        font-weight: 500;
        cursor: pointer;
    }

    .btn-edit {
        background-color: #4caf50;
        color: white;
    }

    .btn-delete {
        background-color: #f44336;
        color: white;
    }

    .btn-mark-top {
        background-color: #2196f3;
        color: white;
    }

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