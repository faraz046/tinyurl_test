<template>
    <Head title="Categories" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Categories</h2>
        </template>

        <div v-if="$page.props.flash.message" class="alert alert-success text-center">
            {{ $page.props.flash.message }}
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <!-- show categories list only names and link to open a category-->
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="container mx-auto p-8">
                            <div class="flex flex-col md:flex-row">
                                <div class="w-full md:w-1/2">
                                    <ul class="">
                                        <li
                                            class="text-gray-700 py-1 px-2 mr-2 text-sm underline cursor-pointer"
                                            v-for="(category, index) in categories"
                                            :key="index"
                                            @click="navigateToCategory(category.id)"
                                            >
                                            {{ category.name }}
                                        </li>
                                    </ul>
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
    name: 'CategoryList',
    props: {
        categories: Array,
    },
    components: {
        AuthenticatedLayout,
        Head,
    },
    data() {
        
    },
    methods: {
        navigateToCategory(categoryId) {
            this.$inertia.visit(route('shop.category.show', categoryId));
        },
    },
    computed: {
        
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