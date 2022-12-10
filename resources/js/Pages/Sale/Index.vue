<script setup>
import AppLayoutVue from '../../Layouts/AppLayout.vue';
import ActionSection from '@/Components/ActionSection.vue';
import { Link } from '@inertiajs/inertia-vue3';
defineProps({
    sales: Object,
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
                            <tr v-for="sale in sales.data">
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
                                    <a class="m-2 py-2 px-4 bg-indigo-400 hover:bg-indigo-700 rounded"
                                        v-bind:href="route('sale.show', sale.id)" target="_blank" as="button">ver</a>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2" class="text-left">
                                    <p>mostrando de {{ sales.from }} a {{ sales.to }} ventas </p>
                                </td>
                                <td colspan="3" class="text-right">
                                    <Link v-for="link in sales.links" v-bind:href="link.url"
                                        v-bind:class="['py-1 px-2', link.active ? 'bg-indigo-400 hover:bg-indigo-700' : 'hover:bg-slate-400']"
                                        v-html="link.label">
                                    </Link>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </template>
            </ActionSection>
        </div>
    </AppLayoutVue>
</template>
<style>
.si {
    color: red;
}

.no {
    color: darkgreen;
}
</style>