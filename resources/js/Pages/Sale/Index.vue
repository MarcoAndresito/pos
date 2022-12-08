<script setup>
import AppLayoutVue from '../../Layouts/AppLayout.vue';
import ActionSection from '@/Components/ActionSection.vue';
import { Link } from '@inertiajs/inertia-vue3';
defineProps({
    sales: Array,
});
</script>
<template>
    <AppLayoutVue>
        <template #header>
            <Link class="m-2 py-2 px-4 bg-indigo-400 hover:bg-indigo-700 rounded" v-bind:href="route('sale.create')"
                as="button">Nuevo</Link>
        </template>

        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <ActionSection>
                <template #title>Lista de ventas</template>
                <template #description>Lista de ventas</template>
                <template #content>
                    <table class="w-full">
                        <thead>
                            <tr class="text-left">
                                <th>
                                    Numero de Factura
                                </th>
                                <th>
                                    Nit
                                </th>
                                <th>
                                    Nombre
                                </th>
                                <th>
                                    Fecha
                                </th>
                                <th>
                                    Ver
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="sale in sales">
                                <td>
                                    {{ sale.invoice_number }}
                                </td>
                                <td>
                                    {{ sale.nit }}
                                </td>
                                <td>
                                    {{ sale.name }}
                                </td>
                                <td>
                                    {{ sale.sale_date }}
                                </td>
                                <td>
                                    <Link class="m-2 py-2 px-4 bg-indigo-400 hover:bg-indigo-700 rounded"
                                        v-bind:href="route('sale.show', sale.id)" as="button">ver</Link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </template>
            </ActionSection>
        </div>
    </AppLayoutVue>
</template>
