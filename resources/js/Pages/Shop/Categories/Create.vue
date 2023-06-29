<template>
    <Head title="Add Category" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add Category</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <!-- Add product -->
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="container mx-auto p-8">
                            <h2 class="text-2xl font-bold mb-4">New Category</h2>
                            <form @submit.prevent="submitAddForm">
                                <div class="mb-4">
                                    <label for="name" class="block font-medium">Name</label>
                                    <input type="text" id="name" v-model="addForm.name" class="input-field" />
                                    <p v-if="addForm.errors.name" class="text-red-500 mt-1">{{ addForm.errors.name }}</p>
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



export default {
    name: 'EditProduct',
    components: {
        AuthenticatedLayout,
        Head,
    },
    data() {
        return {
            addForm: this.$inertia.form({
                name: '',
            }),
        };
    },
    methods: {
       submitAddForm() {
            this.addForm.post(route("shop.category.create"), {
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
    }
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