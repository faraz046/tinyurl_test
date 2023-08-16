<template>
    <Head title="Add Product" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add Product</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <!-- Add product -->
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="container mx-auto p-8">
                            <h2 class="text-2xl font-bold mb-4">New Product</h2>
                            <form @submit.prevent="submitAddForm">
                            <div class="mb-4">
                                <label for="name" class="block font-medium">Name</label>
                                <input type="text" id="name" v-model="addForm.name" class="input-field" />
                                <p v-if="addForm.errors.name" class="text-red-500 mt-1">{{ addForm.errors.name }}</p>
                            </div>
                            <div class="mb-4">
                                <label for="categories" class="block font-medium">Categories</label>
                                
                                <Multiselect
                                    v-model="addForm.categories"
                                    placeholder="Type to search"
                                    :filter-results="false"
                                    :min-chars="1"
                                    :resolve-on-load="false"
                                    :delay="0"
                                    :searchable="true"
                                    mode="multiple"
                                    :options="async function(query) {
                                        return await searchCategories(query) // check JS block for implementation
                                    }"
                                />

                                <p v-if="addForm.errors.categories" class="text-red-500 mt-1">{{ addForm.errors.categories }}</p>
                            </div>
                            <div class="mb-4">
                                <label for="price" class="block font-medium">Price</label>
                                <input type="text" id="price" v-model="addForm.price" class="input-field" />
                                <p v-if="addForm.errors.price" class="text-red-500 mt-1">{{ addForm.errors.price }}</p>
                            </div>
                            <div class="mb-4">
                                <label for="description" class="block font-medium">Description</label>
                                <textarea id="description" v-model="addForm.description" rows="4" class="input-field"></textarea>
                                <p v-if="addForm.errors.description" class="text-red-500 mt-1">{{ addForm.errors.description }}</p>
                            </div>
                            <div class="flex">
                                <button type="submit" class="btn btn-save mr-2">Save</button>
                                <button @click.prevent="cancel" class="btn btn-cancel">Cancel</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import Multiselect from '@vueform/multiselect'
import axios from 'axios';



export default {
    name: 'EditProduct',
    props: {
        
    },
    components: {
        AuthenticatedLayout,
        Head,
        Multiselect,
    },
    data() {
        return {
            categories: [],
            addForm: this.$inertia.form({
                name: '',
                description: '',
                price: '',
                categories: null,
            }),
        };
    },
    methods: {
       submitAddForm() {
            this.addForm.post(route("shop.product.create"), {
                onSuccess: () => {
                    this.addForm.reset();
                },
                onError: () => {
                    this.$buefy.toast.open({
                        type: 'is-danger',
                        message: "An error occurred while updating product",
                    });
                },
            });
        },
        cancel() {
            this.$inertia.visit(route("shop.product.list"));
        },
        async searchCategories(search) {
            const { data } = await axios.get(route("shop.category.search", { search: search }), {
                params: {
                    search,
                },
            });

            return data;

        },
    },
    computed: {
       
    },
}
</script>

<style>
    .input-field {
        border: 1px solid #ccc;
        padding: 0.5rem;
        width: 100%;
    }

    .btn {
        padding: 0.5rem 1rem;
        border-radius: 4px;
        font-weight: 500;
        cursor: pointer;
    }

    .btn-save {
        background-color: #4caf50;
        color: white;
    }

    .btn-cancel {
        background-color: #ccc;
        color: white;
    }
</style>
<style src="@vueform/multiselect/themes/default.css"></style>