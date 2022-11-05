<script setup>
import AppLayoutVue from '../../Layouts/AppLayout.vue';
import ActionSection from '@/Components/ActionSection.vue';
import { Link } from '@inertiajs/inertia-vue3';
defineProps({
    categories: Array,
});
</script>
<template>
    <AppLayoutVue>
        <template #header>

            <Link class="m-2 py-2 px-4 bg-indigo-400 hover:bg-indigo-700 rounded" v-bind:href="route('category.create')" as="button">Nuevo</Link>

        </template>

        <!-- <p v-for="juan in categories">{{juan.name}}</p> -->

        <!--
        <div v-for="category in categories">
            <p>nombre: {{ category.name }} tipo: {{ category.type }}</p>
        </div>
        -->

        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <ActionSection>
                <template #title>Lista de Categorias</template>
                <template #description>para categorizar productos</template>
                <template #content>
                    <table class="w-full">
                        <thead>
                            <tr class="text-left">
                                <th>
                                    Nombre
                                </th>
                                <th>
                                    Tipo
                                </th>
                                <th>
                                    Ver
                                </th>
                                <th>
                                    Editar
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="category in categories">
                                <td>
                                    {{ category.name }}
                                </td>
                                <td>
                                    {{ category.type }}
                                </td>
                                <td>
                                    <Link class="m-2 py-2 px-4 bg-indigo-400 hover:bg-indigo-700 rounded" v-bind:href="route('category.show', category.id)" as="button">ver</Link>
                                </td>
                                <td>
                                    <Link class="m-2 py-2 px-4 bg-orange-400 hover:bg-orange-700 rounded" v-bind:href="route('category.edit', category.id)" as="button">editar</Link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </template>
            </ActionSection>
        </div>

    </AppLayoutVue>
</template>