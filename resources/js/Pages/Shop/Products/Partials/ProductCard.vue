<template>
    <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/5 p-2">
        <div class="bg-white rounded-lg shadow-lg">
            <a :href="route('shop.product.show', product.id)">
                <div class="bg-cover bg-center h-56 p-4 " :style="{ backgroundImage: 'url(https://dummyimage.com/150x100/4a5568/ffffff&text=Product+Image)' }"></div>
                <div class="p-4 min-h-max">
                    <p class="font-bold capitalize text-xl mb-2 min-h-max">{{ product.name }}</p>
                    <p class="font-semibold text-lg mb-2">${{ product.price }}</p>
                    <p class="text-gray-700 text-base">{{ this.excerptify(product.description) }}</p>
                </div>
            </a>
        </div>
    </div>
</template>

<script>

export default {
    name: "ProductCard",
    props: {
        product: Object,
    },
    methods: {
        excerptify(text) {
            return text.substring(0, 70) + '...';
        }
    }
}

</script>