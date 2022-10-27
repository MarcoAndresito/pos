<script setup>
import AppLayoutVue from '../../Layouts/AppLayout.vue';
import ActionSection from '../../Components/ActionSection.vue';
defineProps({
    categories: Array,
});
</script>
<template>
    <AppLayoutVue>
        <template #header>
            Pagina Categorias
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
                            <tr>
                                <th>
                                    Nombre
                                </th>
                                <th>
                                    Tipo
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
                            </tr>
                        </tbody>
                    </table>
                </template>
            </ActionSection>
        </div>

    </AppLayoutVue>
</template>