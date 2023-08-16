<template>
    <Head :title="product.name" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ product.name }}</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <!-- edit product -->
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="container mx-auto p-8">
                            <h2 class="text-2xl font-bold mb-4">Edit Product</h2>
                            <form @submit.prevent="submitEditForm">
                            <div class="mb-4">
                                <label for="name" class="block font-medium">Name</label>
                                <input type="text" id="name" v-model="editForm.name" class="input-field" />
                                <p v-if="editForm.errors.name" class="text-red-500 mt-1">{{ editForm.errors.name }}</p>
                            </div>
                            <div class="mb-4">
                                <label for="categories" class="block font-medium">Categories</label>
                                <Multiselect
                                    v-model="editForm.categories"
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
                                <p v-if="editForm.errors.categories" class="text-red-500 mt-1">{{ editForm.errors.categories }}</p>
                            </div>
                            <div class="mb-4">
                                <label for="price" class="block font-medium">Price</label>
                                <input type="text" id="price" v-model="editForm.price" class="input-field" />
                                <p v-if="editForm.errors.price" class="text-red-500 mt-1">{{ editForm.errors.price }}</p>
                            </div>
                            <div class="mb-4">
                                <label for="description" class="block font-medium">Description</label>
                                <textarea id="description" v-model="editForm.description" rows="4" class="input-field"></textarea>
                                <p v-if="editForm.errors.description" class="text-red-500 mt-1">{{ editForm.errors.description }}</p>
                            </div>
                            <div class="flex">
                                <button type="submit" class="btn btn-save mr-2">Save</button>
                                <button @click="cancel" class="btn btn-cancel">Cancel</button>
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



export default {
    name: 'EditProduct',
    props: {
        product: Object,
        categories: Array,
    },
    components: {
        AuthenticatedLayout,
        Head,
        Multiselect,
    },
    data() {
        return {
            editForm: this.$inertia.form({
                id: this.product.id,
                name: this.product.name,
                description: this.product.description,
                price: this.product.price,
                categories: this.product.categories.map((category) => category.id),
            }),
        };
    },
    methods: {
       submitEditForm() {
            this.editForm.post(route("shop.product.update", this.editForm.id), {
                onSuccess: () => {
                    this.editForm.reset();
                    this.editModal = false;
                    this.$buefy.toast.open({
                        type: 'is-success',
                        message: 'Updated successfully',
                    });
                },
                onError: () => {
                    this.$buefy.toast.open({
                        type: 'is-danger',
                        message: "An error occurred while updating product",
                    });
                },
            });
        },
        async searchCategories(search) {
            const { data } = await axios.get(route("shop.category.search", { search: search }), {
                params: {
                    search,
                },
            });

            return data;

        },
        cancel() {
            this.$inertia.visit(route("shop.product.show", this.product.id));
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