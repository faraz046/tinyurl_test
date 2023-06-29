<template>
    <div class="flex flex-wrap">
        <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/5 p-2">
            <select @change="sortProducts" v-model="sortBy" class="form-select block w-full mt-1" aria-label="Default select example">
                <option value="latest">Latest</option>
                <option value="price_asc">Price - Low to high</option>
                <option value="price_desc">Price - High to low</option>
                <option value="name_asc">Name - A to Z</option>
                <option value="name_desc">Name - Z to A</option>
                <option value="category_asc">Category - A to Z</option>
                <option value="category_desc">Category - Z to A</option>
            </select>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ProductSort',
    props: {
        sort: String,
        routeName: String,
        routeId: Number,
    },
    data() {
        return {
            sortBy: this.sort || 'latest',
        }
    },
    methods: {
        sortProducts() {
            this.$inertia.visit(route(this.routeName, {category: this.routeId, sort: this.sortBy }), {
                preserveScroll: true,
            });
        }
    }
}
</script>