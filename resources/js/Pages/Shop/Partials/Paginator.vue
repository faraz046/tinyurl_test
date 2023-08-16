<template>
    <div>
        <nav class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6" aria-label="Pagination">
            <div class="hidden sm:block">
                <p v-if="total > 0" class="text-sm text-gray-700">
                    Showing
                    <span class="font-medium">{{ from }}</span>
                    to
                    <span class="font-medium">{{ to }}</span>
                    of
                    <span class="font-medium">{{ total }}</span>
                    results
                </p>
                <!-- <p v-if="!total" class="text-sm text-gray-700">
                    No results
                </p> -->
            </div>
            <div class="flex-1 flex justify-between sm:justify-end">
                <Link preserve-scroll :href="prevPageUrl" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">Previous</Link>
                <Link preserve-scroll :href="nextPageUrl" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">Next</Link>
            </div>
        </nav>
    </div>
</template>

<script>
import { Link } from '@inertiajs/vue3';
export default {
    name: 'Paginator',
    props: {
        from: Number,
        to: Number,
        total: Number,
        prevPageUrl: String,
        nextPageUrl: String,
    },
    components: {
        Link,
    },
}
</script>