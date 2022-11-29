<script setup>
import AppLayoutVue from '../../Layouts/AppLayout.vue';
import FormSection from '../../Components/FormSection.vue';
import DialogModal from '../../Components/DialogModal.vue';
import PrimaryButton from '../../Components/PrimaryButton.vue';
import SecondaryButton from '../../Components/SecondaryButton.vue';
import InputLabel from '../../Components/InputLabel.vue';
import TextInput from '../../Components/TextInput.vue';
import ImputError from '../../Components/InputError.vue';
import { ref } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
const data = defineProps({
    'user': Object,
    'clients': Array,
    'selectedClient': Object
});
const showDialogNewClient = ref(false);
const queryClient = ref('');
const formNewClient = useForm({
    'nit': '',
    'name': '',
    'last_name': '',
    'birth_date': ''
});
const formNewSale = useForm({
    'user_id': data.user.id,
    'client_id': null,
    'invoice_number': '',
    'nit': '',
    'name': '',
    'sale_date': '',
});
const sendNewClient = () => {
    formNewClient.post(route('client.store', { backurl: 'sale.index' }), {
        only: ['selectedClient'],
        onSuccess: () => {
            showDialogNewClient.value = false;
            formNewClient.reset();
            formNewSale.client_id = data.selectedClient.id;
            formNewSale.name = data.selectedClient.name + ' ' + data.selectedClient.last_name;
            formNewSale.nit = data.selectedClient.nit;
        }
    });
};
const clientSearch = () => {
    Inertia.get(route('sale.index'), { q: queryClient.value }, {
        only: ['clients'],
        preserveState: true,
        preserveScroll: true,
        onSuccess:()=>{
            formNewSale.client_id = null;
        }
    });
}
const selectClient = (id) => {
    Inertia.get(route('sale.index'), { id: id }, {
        only: ['selectedClient'],
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            formNewSale.client_id = data.selectedClient.id;
            formNewSale.name = data.selectedClient.name + ' ' + data.selectedClient.last_name;
            formNewSale.nit = data.selectedClient.nit;
        }
    })
};
</script>

<template>
    <AppLayoutVue>
        <template #header>
            <SecondaryButton class="m-2 py-2 px-4 bg-indigo-400 hover:bg-indigo-700 rounded"
                @click="showDialogNewClient = true">Nuevo Cliente</SecondaryButton>
        </template>
        <template #default>
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <FormSection>
                    <template #title>Ventas</template>
                    <template #description>Ventas</template>
                    <template #form>
                        <div class="col-span-6 sm:col-span-4">
                            <div class="relative">
                                <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <input type="search" id="default-search"
                                    class="block p-4 pl-10 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                                    placeholder="Search Mockups, Logos..." v-model="queryClient">
                                <button type="button"
                                    class="text-white absolute right-2.5 bottom-2.5 bg-indigo-700 hover:bg-indigo-800 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-indigo-800"
                                    @click="clientSearch">Buscar</button>
                            </div>
                        </div>
                        <div class="col-span-6 sm:col-span-4"
                            v-if="(clients?.length ?? 0) > 0 && formNewSale.client_id == null">
                            <table class="border-collapse w-full">
                                <tr>
                                    <th
                                        class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">
                                        Nombre</th>
                                    <th
                                        class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">
                                        Nit</th>
                                    <th
                                        class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">
                                        Acciones</th>
                                </tr>
                                <tr v-for="client in clients"
                                    class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">
                                    <td
                                        class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                        {{ client.name }}</td>
                                    <td
                                        class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                        {{ client.nit }}</td>
                                    <td
                                        class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                        <SecondaryButton @click="selectClient(client.id)">Seleccionar</SecondaryButton>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-span-6 sm:col-span-4" v-if="formNewSale.client_id != null">
                            <p>Id: {{ selectedClient.id }}</p>
                            <p>Nombre: {{ selectedClient.name }}</p>
                            <p>Apellido: {{ selectedClient.last_name }}</p>
                            <p>Fecha Nacimiento: {{ selectedClient.birth_date }}</p>
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <InputLabel for="invoice_number" value="Numero de factura" />
                            <TextInput type="text" name="invoice_number" id="invoice_number"
                                v-model="formNewSale.invoice_number" class="w-full">
                            </TextInput>
                            <ImputError v-bind:message="formNewSale.errors.invoice_number"></ImputError>
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <InputLabel for="nit" value="Nit" />
                            <TextInput type="text" name="nit" id="nit"
                                v-model="formNewSale.nit" class="w-full">
                            </TextInput>
                            <ImputError v-bind:message="formNewSale.errors.nit"></ImputError>
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <InputLabel for="name" value="Nombre" />
                            <TextInput type="text" name="name" id="name"
                                v-model="formNewSale.name" class="w-full">
                            </TextInput>
                            <ImputError v-bind:message="formNewSale.errors.name"></ImputError>
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <InputLabel for="sale_date" value="Fecha Venta" />
                            <TextInput type="date" name="sale_date" id="sale_date"
                                v-model="formNewSale.sale_date" class="w-full">
                            </TextInput>
                            <ImputError v-bind:message="formNewSale.errors.sale_date"></ImputError>
                        </div>
                    </template>
                    <template #actions>
                        <PrimaryButton>guardar</PrimaryButton>
                    </template>
                </FormSection>
            </div>
        </template>
    </AppLayoutVue>

    <DialogModal v-bind:show="showDialogNewClient">
        <template #title>Nuevo Cliente</template>
        <template #content>
            <form @submit.prevent="sendNewClient">
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="nit" value="Nit" />
                        <TextInput type="text" name="nit" id="nit" v-model="formNewClient.nit" class="w-full">
                        </TextInput>
                        <ImputError v-bind:message="formNewClient.errors.nit"></ImputError>
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="name" value="Nombre" />
                        <TextInput type="text" name="name" id="name" v-model="formNewClient.name" class="w-full">
                        </TextInput>
                        <ImputError v-bind:message="formNewClient.errors.name"></ImputError>
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="last_name" value="Apellido" />
                        <TextInput type="text" name="last_name" id="last_name" v-model="formNewClient.last_name"
                            class="w-full">
                        </TextInput>
                        <ImputError v-bind:message="formNewClient.errors.last_name"></ImputError>
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="birth_date" value="Fecha Nacimiento" />
                        <TextInput type="date" name="birth_date" id="birth_date" v-model="formNewClient.birth_date"
                            class="w-full">
                        </TextInput>
                        <ImputError v-bind:message="formNewClient.errors.birth_date"></ImputError>
                    </div>
                    <div class="col-span-6 text-end">
                        <PrimaryButton class="mr-2">Guardar</PrimaryButton>
                        <SecondaryButton @click="showDialogNewClient = false">Cancelar</SecondaryButton>
                    </div>
                </div>
            </form>
        </template>
    </DialogModal>
</template>