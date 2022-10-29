<script setup>
import AppLayout from '../../Layouts/AppLayout.vue'
import ActionSection from '../../Components/ActionSection.vue';
import { Link } from '@inertiajs/inertia-vue3';
defineProps({
    category: Object
});

</script>
<template>
    <AppLayout>
        <template #header>titulo</template>
        <template #default>
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <ActionSection>
                    <template #title>Categoria</template>
                    <template #description>Categoria</template>
                    <template #content>
                        <p>Nombre: {{ category.name }}</p>
                        <p>Tipo: {{ category.type }}</p>
                        <Link class="m-2 py-2 px-4 bg-cyan-400 hover:bg-cyan-700 rounded text-white"
                            v-bind:href="route('category.index')" as="button">volver</Link>
                    </template>
                </ActionSection>
            </div>
        </template>
    </AppLayout>
</template>