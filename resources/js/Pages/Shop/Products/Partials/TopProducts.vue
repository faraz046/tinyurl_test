<template>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="font-semibold text-xl text-gray-800 leading-tight">Top Products</h3>
                    <div v-if="products" class="flex overflow-x-auto">
                        <template v-for="product in products" :key="product.id">
                            <div class="flex-none w-64 sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/5 p-2">
                                <div class="bg-white rounded-lg shadow-lg">
                                    <a :href="route('shop.product.show',product.id)">
                                    <div class="bg-cover bg-center h-56 p-4" :style="{ backgroundImage: 'url(https://dummyimage.com/150x100/4a5568/ffffff&text=Product+Image)' }"></div>
                                    <div class="p-4">
                                        <p class="font-bold capitalize text-xl mb-2">{{ product.name }}</p>
                                        <p class="font-semibold text-lg mb-2">${{ product.price }}</p>
                                        <p class="text-gray-700 text-base">{{ this.excerptify(product.description) }}</p>
                                    </div>
                                    </a>
                                </div>
                            </div>
                        </template>
                    </div>
                    <p v-if="!products" class="text-gray-700 text-base">No products.</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "TopProducts",
    props: {
        products: Array,
    },
    methods: {
        excerptify(text) {
            return text.substring(0, 70) + '...';
        }
    }
}

</script>