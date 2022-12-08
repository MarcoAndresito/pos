<script setup>
import AppLayoutVue from '../../Layouts/AppLayout.vue';
import FormSection from '../../Components/FormSection.vue';
import DialogModal from '../../Components/DialogModal.vue';
import PrimaryButton from '../../Components/PrimaryButton.vue';
import SecondaryButton from '../../Components/SecondaryButton.vue';
import InputLabel from '../../Components/InputLabel.vue';
import TextInput from '../../Components/TextInput.vue';
import ImputError from '../../Components/InputError.vue';
import SearchInput from '../../Components/SearchInput.vue';
import { ref } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
const data = defineProps({
    'user': Object,
    'clients': Array,
    'selectedClient': Object,
    'products': Array,
    'selectedProduct': Object,
});
const showDialogNewClient = ref(false);
const showDialogSearchProduct = ref(false);
const detailProduct = ref({
    'product_id': '',
    'name': '',
    'quantity': '',
    'price': '',
});
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
    'shopping_cart': []
});
const sendNewClient = () => {
    formNewClient.post(route('client.store', { backurl: 'sale.create' }), {
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
const clientSearch = (query) => {
    Inertia.get(route('sale.create'), { q: query }, {
        only: ['clients'],
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            formNewSale.client_id = null;
        }
    });
}
const productSearch = (query) => {
    showDialogSearchProduct.value = true;
    Inertia.get(route('sale.create'), { q: query }, {
        only: ['products'],
        preserveState: true,
        preserveScroll: true,
    });
}
const selectClient = (id) => {
    Inertia.get(route('sale.create'), { id: id }, {
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
const selectProduct = (id) => {
    Inertia.get(route('sale.create'), { id: id }, {
        only: ['selectedProduct'],
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            detailProduct.value.product_id = data.selectedProduct.id;
            detailProduct.value.price = data.selectedProduct.price;
            detailProduct.value.name = data.selectedProduct.name;
        }
    })
}
const addShoppingCart = () => {
    formNewSale.shopping_cart.push({ ...detailProduct.value });
    showDialogSearchProduct.value = false;
    detailProduct.value.product_id = ''
    detailProduct.value.name = ''
    detailProduct.value.price = ''
}
const removeShoppingCart = (id) => {
    formNewSale.shopping_cart = formNewSale.shopping_cart.filter((value, index, array) => value.product_id != id);
}
const sale = () => {
    formNewSale.post(route('sale.store'))
}
</script>

<template>
    <AppLayoutVue>
        <template #header>
            <SecondaryButton class="m-2 py-2 px-4 bg-indigo-400 hover:bg-indigo-700 rounded"
                @click="showDialogNewClient = true">Nuevo Cliente</SecondaryButton>
            <SearchInput class="w-96 inline-flex" placeholder="Nombre producto..." textButton="Buscar producto"
                @search="productSearch">
            </SearchInput>
        </template>
        <template #default>
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <FormSection v-on:submitted="sale">
                    <template #title>Ventas</template>
                    <template #description>Ventas</template>
                    <template #form>
                        <div class="col-span-6 sm:col-span-4">
                            <SearchInput placeholder="Nombre cliente..." textButton="Buscar cliente"
                                @search="clientSearch"></SearchInput>
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
                            <p>Id: {{ selectedClient?.id }}</p>
                            <p>Nombre: {{ selectedClient?.name }}</p>
                            <p>Apellido: {{ selectedClient?.last_name }}</p>
                            <p>Fecha Nacimiento: {{ selectedClient?.birth_date }}</p>
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
                            <TextInput type="text" name="nit" id="nit" v-model="formNewSale.nit" class="w-full">
                            </TextInput>
                            <ImputError v-bind:message="formNewSale.errors.nit"></ImputError>
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <InputLabel for="name" value="Nombre" />
                            <TextInput type="text" name="name" id="name" v-model="formNewSale.name" class="w-full">
                            </TextInput>
                            <ImputError v-bind:message="formNewSale.errors.name"></ImputError>
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <InputLabel for="sale_date" value="Fecha Venta" />
                            <TextInput type="date" name="sale_date" id="sale_date" v-model="formNewSale.sale_date"
                                class="w-full">
                            </TextInput>
                            <ImputError v-bind:message="formNewSale.errors.sale_date"></ImputError>
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <table class="border-collapse w-full">
                                <tr>
                                    <th
                                        class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">
                                        Nombre</th>
                                    <th
                                        class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">
                                        Precio</th>
                                    <th
                                        class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">
                                        Cantidad</th>
                                    <th
                                        class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">
                                        Acciones</th>
                                </tr>
                                <tr v-for="item in formNewSale.shopping_cart"
                                    class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">
                                    <td
                                        class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                        {{ item.name }}</td>
                                    <td
                                        class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                        {{ item.price }}</td>
                                    <td
                                        class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                        {{ item.quantity }}</td>
                                    <td
                                        class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                        <SecondaryButton v-on:click="removeShoppingCart(item.product_id)">Quitar
                                        </SecondaryButton>
                                    </td>
                                </tr>
                            </table>
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

    <DialogModal v-bind:show="showDialogSearchProduct">
        <template #title>lista de productos</template>
        <template #content>
            <table class="border-collapse w-full" v-if="(detailProduct.product_id == '')">
                <tr>
                    <th
                        class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">
                        Nombre</th>
                    <th
                        class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">
                        Precio</th>
                    <th
                        class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">
                        Acciones</th>
                </tr>
                <tr v-for="product in products"
                    class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">
                    <td
                        class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                        {{ product.name }}</td>
                    <td
                        class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                        {{ product.price }}</td>
                    <td
                        class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                        <SecondaryButton @click="selectProduct(product.id)">Seleccionar</SecondaryButton>
                    </td>
                </tr>
            </table>
            <div class="grid grid-cols-6 gap-6" v-else>
                <div class="col-span-6 sm:col-span-4">
                    <p><b>Id: </b><i>{{ detailProduct.product_id }}</i></p>
                    <p><b>Nombre: </b><i>{{ selectedProduct.name }}</i></p>
                    <p><b>Precio: </b><i>{{ selectedProduct.price }}</i></p>
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <InputLabel for="count" value="Cantidad" />
                    <TextInput type="number" name="count" id="count" v-model="detailProduct.quantity" class="w-full">
                    </TextInput>
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <InputLabel for="price" value="Precio" />
                    <TextInput type="number" name="price" id="price" v-model="detailProduct.price" class="w-full">
                    </TextInput>
                </div>
            </div>
        </template>
        <template #footer>
            <SecondaryButton v-if="(detailProduct.product_id != '')" @click="addShoppingCart">Agregar al carrito
            </SecondaryButton>
            <SecondaryButton v-on:click="showDialogSearchProduct = false">Cancelar</SecondaryButton>
        </template>
    </DialogModal>
</template>
